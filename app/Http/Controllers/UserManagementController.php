<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationMail;
use Illuminate\Validation\ValidationException;

class UserManagementController extends Controller
{
    private function canManageAllUsers(): bool
    {
        return auth()->check() && auth()->user()->isSuperAdmin();
    }

    private function ensureManageAllUsersOrAbort(): void
    {
        if (! $this->canManageAllUsers()) {
            abort(403, 'Only a super admin can manage users.');
        }
    }

    /**
     * @return array<string, string>
     */
    private function canonicalRoleLabels(): array
    {
        return [
            'super-admin' => 'Super Admin',
            'admin' => 'Admin',
            'guest' => 'Normal User',
        ];
    }

    /**
     * Keep stored role names aligned with the labels shown in System Users.
     */
    private function ensureCanonicalRoleNames(): void
    {
        foreach ($this->canonicalRoleLabels() as $slug => $name) {
            Role::query()->where('slug', $slug)->where('name', '!=', $name)->update(['name' => $name]);
        }
    }

    private function roleFromRequest(Request $request): Role
    {
        $labels = $this->canonicalRoleLabels();
        $slug = (string) $request->input('role_slug', '');

        $role = null;
        if ($slug !== '' && array_key_exists($slug, $labels)) {
            $role = Role::query()->where('slug', $slug)->first();
        }

        if (! $role && $request->filled('role_id')) {
            $role = Role::query()
                ->whereKey((int) $request->input('role_id'))
                ->whereIn('slug', array_keys($labels))
                ->first();
        }

        if (! $role) {
            throw ValidationException::withMessages([
                'role_slug' => 'Choose Super Admin, Admin, or Normal User.',
            ]);
        }

        return $role;
    }

    private function assignRole(User $user, Role $role): void
    {
        DB::table('users')->where('id', $user->id)->update([
            'role_id' => $role->id,
            'updated_at' => now(),
        ]);

        $user->role_id = $role->id;
        $user->unsetRelation('role');
        $user->setRelation('role', $role);
    }

    private function isLastSuperAdmin(User $user): bool
    {
        $superAdminRoleId = Role::where('slug', 'super-admin')->value('id');
        if (! $superAdminRoleId || (int) $user->role_id !== (int) $superAdminRoleId) {
            return false;
        }

        return User::where('role_id', $superAdminRoleId)->where('id', '!=', $user->id)->doesntExist();
    }

    public function index()
    {
        $this->ensureManageAllUsersOrAbort();
        $this->ensureCanonicalRoleNames();

        $isManager = true;
        $users = User::with('role')->whereNull('deleted_at')->latest()->get();
        $roles = Role::whereIn('slug', ['super-admin', 'admin', 'guest'])->get()
            ->sortBy(fn (Role $role) => match ($role->slug) {
                'super-admin' => 0,
                'admin' => 1,
                default => 2,
            })
            ->values();
        $superAdminRole = $roles->firstWhere('slug', 'super-admin');

        return view('content-management.users.index', compact('users', 'roles', 'superAdminRole', 'isManager'));
    }

    public function store(Request $request)
    {
        $this->ensureManageAllUsersOrAbort();

        try {
            $role = $this->roleFromRequest($request);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
                'verify_immediately' => 'nullable|boolean',
            ]);

            $email = strtolower(trim((string) $request->email));
            $existing = DB::table('users')->whereRaw('LOWER(email) = ?', [$email])->first();

            if ($existing && empty($existing->deleted_at)) {
                return response()->json([
                    'success' => false,
                    'message' => 'That email is already used by '.$existing->name.'. Edit that user, or use a different email.',
                ], 422);
            }

            $verifyNow = $request->boolean('verify_immediately');
            $payload = [
                'name' => $request->name,
                'email' => $email,
                'password' => Hash::make($request->password),
                'role_id' => $role->id,
                'updated_at' => now(),
                'email_verified_at' => $verifyNow ? now() : null,
                'email_verified_by' => $verifyNow ? auth()->id() : null,
                'verification_token' => $verifyNow ? null : Str::random(60),
            ];

            if ($existing) {
                DB::table('users')->where('id', $existing->id)->update(array_merge($payload, [
                    'deleted_at' => null,
                ]));
                $user = User::findOrFail($existing->id);
                $message = 'The deleted account was added back';
            } else {
                $payload['user_id'] = (string) \Ramsey\Uuid\Uuid::uuid4();
                $payload['created_at'] = now();
                $payload['status'] = 'Active';
                $userId = DB::table('users')->insertGetId($payload);
                $user = User::findOrFail($userId);
                $message = 'User created successfully';
            }

            if (! $verifyNow) {
                try {
                    Mail::to($user->email)->send(new EmailVerificationMail($user));
                    $message .= ' and a verification email was sent.';
                } catch (\Throwable $e) {
                    report($e);
                    $message .= ', but the verification email could not be sent. You can verify the account from the list.';
                }
            } else {
                $message .= ' and verified.';
            }

            $label = $this->canonicalRoleLabels()[$role->slug] ?? $role->name;

            return response()->json([
                'success' => true,
                'message' => $message.' Role is '.$label.'.',
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Could not add this user. '. $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $this->ensureManageAllUsersOrAbort();

        $user = User::with('role')->findOrFail($id);
        $role = $this->roleFromRequest($request);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        $currentSlug = $user->role->slug ?? null;
        $leavingSuperAdmin = $currentSlug === 'super-admin' && $role->slug !== 'super-admin';
        if ($leavingSuperAdmin && $this->isLastSuperAdmin($user)) {
            return response()->json([
                'success' => false,
                'message' => 'This is the only super admin. Assign the Super Admin role to another user before changing this one.',
            ], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $this->assignRole($user, $role);

        $savedSlug = User::with('role')->findOrFail($user->id)->role->slug ?? null;
        if ($savedSlug !== $role->slug) {
            return response()->json([
                'success' => false,
                'message' => 'The role could not be saved. Please try again.',
            ], 500);
        }

        $label = $this->canonicalRoleLabels()[$role->slug] ?? $role->name;

        return response()->json([
            'success' => true,
            'message' => 'User updated. Role is now '.$label.'.',
            'role_slug' => $role->slug,
            'role_label' => $label,
        ]);
    }

    public function verifyEmail($id)
    {
        $this->ensureManageAllUsersOrAbort();

        $user = User::findOrFail($id);
        $user->email_verified_at = now();
        $user->email_verified_by = auth()->id();
        $user->verification_token = null;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Email verified successfully']);
    }

    public function resendVerification($id)
    {
        $this->ensureManageAllUsersOrAbort();

        $user = User::findOrFail($id);
        
        if (!$user->verification_token) {
            $user->verification_token = Str::random(60);
            $user->save();
        }

        Mail::to($user->email)->send(new EmailVerificationMail($user));

        return response()->json(['success' => true, 'message' => 'Verification email sent successfully']);
    }

    public function destroy($id)
    {
        $this->ensureManageAllUsersOrAbort();

        $user = User::findOrFail($id);
        if ((int) $user->id === (int) auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account.',
            ], 422);
        }
        if ($this->isLastSuperAdmin($user)) {
            return response()->json([
                'success' => false,
                'message' => 'This is the only super admin and cannot be deleted.',
            ], 422);
        }
        try {
            $user->delete();
        } catch (\Throwable $e) {
            DB::table('users')->where('id', $user->id)->update([
                'deleted_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }

    public function show($id)
    {
        $this->ensureManageAllUsersOrAbort();

        $user = User::with('role:id,name,slug')->findOrFail($id);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'role' => $user->role ? [
                'id' => $user->role->id,
                'name' => $user->role->name,
                'slug' => $user->role->slug,
            ] : null,
        ]);
    }

    /**
     * Reset user password without requiring the old password
     * Super Admin can reset any user's password
     */
    public function resetPassword(Request $request, $id)
    {
        $this->ensureManageAllUsersOrAbort();

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true, 
            'message' => 'Password reset successfully. The user can now login with the new password.'
        ]);
    }
}

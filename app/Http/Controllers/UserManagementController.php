<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationMail;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    private function canManageAllUsers(): bool
    {
        return auth()->check() && strtolower((string) auth()->user()->email) === 'admin@iremetech.com';
    }

    private function ensureManageAllUsersOrAbort(): void
    {
        if (! $this->canManageAllUsers()) {
            abort(403, 'Only admin@iremetech.com can manage users.');
        }
    }

    public function index()
    {
        $this->ensureManageAllUsersOrAbort();

        $isManager = true;
        $users = User::with('role')->latest()->get();
        // Super Admin is seeded only — not assignable here
        $roles = Role::whereIn('slug', ['admin', 'guest'])->orderBy('name')->get();
        $superAdminRole = Role::where('slug', 'super-admin')->first();

        return view('content-management.users.index', compact('users', 'roles', 'superAdminRole', 'isManager'));
    }

    public function store(Request $request)
    {
        $this->ensureManageAllUsersOrAbort();

        $allowedRoleIds = Role::whereIn('slug', ['admin', 'guest'])->pluck('id')->all();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => ['required', Rule::in($allowedRoleIds)],
            'verify_immediately' => 'nullable|boolean',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'user_id' => \Ramsey\Uuid\Uuid::uuid4(),
        ];

        // If Super Admin wants to verify immediately
        if ($request->has('verify_immediately') && $request->verify_immediately) {
            $userData['email_verified_at'] = now();
            $userData['email_verified_by'] = auth()->id();
        } else {
            $userData['verification_token'] = Str::random(60);
        }

        $user = User::create($userData);

        // Send verification email only if not verified immediately
        if (!$user->email_verified_at) {
            Mail::to($user->email)->send(new EmailVerificationMail($user));
            $message = 'User created successfully. Verification email sent.';
        } else {
            $message = 'User created and verified successfully.';
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function update(Request $request, $id)
    {
        $this->ensureManageAllUsersOrAbort();

        $user = User::findOrFail($id);
        $allowedRoleIds = Role::whereIn('slug', ['admin', 'guest'])->pluck('id')->all();
        $superAdminRoleId = Role::where('slug', 'super-admin')->value('id');
        if ($superAdminRoleId && (int) $user->role_id === (int) $superAdminRoleId) {
            $allowedRoleIds[] = (int) $superAdminRoleId;
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role_id' => ['required', Rule::in($allowedRoleIds)],
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'User updated successfully']);
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
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }

    public function show($id)
    {
        $this->ensureManageAllUsersOrAbort();

        $user = User::with('role')->findOrFail($id);
        return response()->json($user);
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

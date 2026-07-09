<?php

namespace App\Actions\Fortify;

use Ramsey\Uuid\Uuid;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;


class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $guestRole = Role::where('slug', 'guest')->firstOrFail();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'user_id' => Uuid::uuid4(),
            'role_id' => $guestRole->id,
            'status' => 'Active',
            'password' => Hash::make($input['password']),
        ]);
    }
}

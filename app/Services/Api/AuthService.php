<?php
namespace App\Services\Api;

use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService extends BaseService
{

    public function register(array $validatedData): array
    {
        // Create the user using the vaidated data
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return $this->success('User registered successfully', $user);
    }


    public function login(array $validatedData): array
    {
        // Find the use by email
        $user = User::where('email', $validatedData['email'])->first();

        // Check if the use exists and if the password is correct
        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Generate an authentication token and add it to the user object
        $user->token = $user->createToken('auth_token')->plainTextToken;

        return $this->success('You are logged in', $user);
    }

    public function logout($user): array
    {
        // Revoke all tokens for everyone
        $user->tokens()->delete();

        return $this->success('Logged out successfully', $user);
    }

}

<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerService
{
    /**
     * Creates new customer
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return array
     */
    public function create(string $name, string $email, string $password): array
    {
        $customer = Customer::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        return $customer->only('id', 'name', 'email');
    }

    /**
     * Checks customer credentials
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function checkCredentials(string $email, string $password): bool
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);
    }

    /**
     * Creates api token for given customer
     *
     * @param string $email
     * @return string
     */
    public function createApiToken(string $email): string
    {
        $customer = Customer::where('email', $email)->first();
        // $customer->tokens()->delete(); // uncomment this for using single sessions instead of multiple

        return $customer->createToken('auth_token')->plainTextToken;
    }
}

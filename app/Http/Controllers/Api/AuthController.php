<?php

namespace App\Http\Controllers\Api;

use App\Classes\ResponseCodes;
use App\Exceptions\ResponderException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\CustomerService;

class AuthController
{
    private $customerService;

    /**
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Register new user
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $customer = $this->customerService->create(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        return responder()->send($customer);
    }

    /**
     * Check login credentials and get api token
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ResponderException
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $canLogin = $this->customerService->checkCredentials(
            $request->input('email'),
            $request->input('password')
        );

        if (!$canLogin) {
            throw new ResponderException(ResponseCodes::VALIDATION_INVALID_LOGIN_DETAILS);
        }

        $token = $this->customerService->createApiToken($request->input('email'));

        return responder()
            ->send([
                'token_type' => 'Bearer',
                'access_token' => $token,
            ]);
    }
}

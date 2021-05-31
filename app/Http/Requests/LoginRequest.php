<?php

namespace App\Http\Requests;

class LoginRequest extends Base
{
    /**
     * Login request rules
     *
     * @return string[]
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ];
    }
}

<?php

namespace App\Http\Requests;

class RegisterRequest extends Base
{
    /**
     * Register new customer rules
     *
     * @return string[]
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8',
        ];
    }
}

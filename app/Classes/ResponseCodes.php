<?php


namespace App\Classes;


abstract class ResponseCodes
{
    public const SUCCESS = [
        'code' => 0,
        'message' => null
    ];

    public const ERROR = [
        'code' => 1001,
        'message' => 'An error occurred.'
    ];

    public const UNAUTHENTICATED = [
        'code' => 1010,
        'message' => 'Unauthenticated.'
    ];

    public const VALIDATION_FAILED = [
        'code' => 2001,
        'message' => 'Validation failed.'
    ];

    public const VALIDATION_INVALID_LOGIN_DETAILS = [
        'code' => 2002,
        'message' => 'Invalid login details.'
    ];

    public const VALIDATION_NOT_ENOUGH_STOCK = [
        'code' => 2003,
        'message' => 'We don\'t have enough stock for this product.'
    ];
}

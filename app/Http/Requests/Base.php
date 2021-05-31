<?php

namespace App\Http\Requests;

use App\Classes\ResponseCodes;
use App\Exceptions\ResponderException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class Base extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if (!config('app.debug')) {
            throw new ResponderException(ResponseCodes::VALIDATION_FAILED);
        }

        $messages = [];

        foreach ($validator->errors()->messages() as $fieldMessages) {
            foreach ($fieldMessages as $fieldMessage) {
                $messages[] = $fieldMessage;
            }
        }

        throw new ResponderException([
            'code' => ResponseCodes::VALIDATION_FAILED['code'],
            'message' => implode(PHP_EOL, $messages),
            'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
        ]);
    }
}

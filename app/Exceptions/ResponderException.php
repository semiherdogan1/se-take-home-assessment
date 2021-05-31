<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ResponderException extends Exception
{
    private $response;

    public function __construct($response)
    {
        parent::__construct($response['message'], $response['code']);

        $this->response = $response;
    }

    /**
     * Disable reporting
     */
    public function report()
    {
        //
    }

    /**
     * Returns api response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return responder()
            ->setHttpStatusCode($this->response['status_code'] ?? Response::HTTP_BAD_REQUEST)
            ->setResponseMeta($this->response)
            ->send();
    }
}

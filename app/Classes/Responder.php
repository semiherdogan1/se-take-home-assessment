<?php


namespace App\Classes;

class Responder
{
    private $httpStatus = 200;
    private $responseCode = ResponseCodes::SUCCESS['code'];
    private $responseMessage = ResponseCodes::SUCCESS['message'];
    private $responseData = null;

    /**
     * Sends response, you can also add response data as parameter
     *
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function send($data = null): \Illuminate\Http\JsonResponse
    {
        if (!is_null($data)) {
            $this->setData($data);
        }

        return $this->sendResponse();
    }

    /**
     * Sets status code for response
     *
     * @param int $httpStatus
     * @return $this
     */
    public function setHttpStatusCode(int $httpStatus): self
    {
        $this->httpStatus = $httpStatus;

        return $this;
    }

    /**
     * Set response error code and message from array
     *
     * @param array $response
     * @return $this
     * @see \App\Classes\ResponseCodes
     */
    public function setResponseMeta(array $response): self
    {
        $this->setResponseCode($response['code']);
        $this->setResponseMessage($response['message']);

        return $this;
    }

    /**
     * Sets response code for response.
     *
     * @param int $code
     * @return $this
     */
    public function setResponseCode(int $code): self
    {
        $this->responseCode = $code;

        return $this;
    }

    /**
     * Sets response message for response
     *
     * @param string|null $message
     * @return $this
     */
    public function setResponseMessage(?string $message): self
    {
        $this->responseMessage = $message;

        return $this;
    }

    /**
     * Sets data for response
     *
     * @param $data
     * @return $this
     */
    public function setData($data): self
    {
        $this->responseData = $data;

        return $this;
    }

    /**
     * Sends response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function sendResponse(): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json(
                [
                    'code' => $this->responseCode,
                    'message' => $this->responseMessage,
                    'data' => $this->responseData,
                ],
                $this->httpStatus
            );
    }
}

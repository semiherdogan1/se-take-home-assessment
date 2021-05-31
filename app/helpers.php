<?php

if (!function_exists('responder')) {
    /**
     * @param null $data
     * @return \App\Classes\Responder
     */
    function responder($data = null)
    {
        $responder = new \App\Classes\Responder();

        if (!is_null($data)) {
            $responder->setData($data);
        }

        return $responder;
    }
}

if (!function_exists('customer')) {
    function customer(?string $key = null)
    {
        $customer = request()->user();

        return $key ? optional($customer)->{$key} : $customer;
    }
}

if (!function_exists('formatFloat')) {
    function formatFloat(float $number): float
    {
        return (float) number_format($number, 2, '.', '');
    }
}

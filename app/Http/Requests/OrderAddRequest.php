<?php

namespace App\Http\Requests;

class OrderAddRequest extends Base
{
    /**
     * Add order request rules
     *
     * @return string[]
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }
}

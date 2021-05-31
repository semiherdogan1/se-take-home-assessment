<?php

namespace App\Http\Requests;

class OrderRemoveRequest extends Base
{
    /**
     * Remove order request rules
     *
     * @return string[]
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ];
    }
}

<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\ApiBaseRequest;

class OrderApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'products' => ['required', 'array', 'min:1'],
            'courier' => ['required', 'boolean'],
            'cash' => ['required', 'boolean'],
            'user_address_id' => ['required', 'numeric', 'exists:user_addresses,id'],
            'products.*.id' => ['required', 'numeric', 'exists:products,id', 'distinct'],
            'products.*.quantity' => ['required', 'numeric', 'min:1']
        ];
    }

}

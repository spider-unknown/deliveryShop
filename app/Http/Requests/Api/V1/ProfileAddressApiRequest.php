<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\ApiBaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProfileAddressApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'city_id' => ['required', 'exists:cities,id', 'numeric'],
            'address' => ['required', 'string'],
            'comment' => ['string'],
            'main' => ['required', 'boolean'],
            'id' => ['numeric', 'exists:user_addresses,id']
        ];
    }


}

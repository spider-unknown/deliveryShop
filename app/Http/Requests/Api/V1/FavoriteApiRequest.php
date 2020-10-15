<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\ApiBaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class FavoriteApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'product_id' => ['required', 'numeric', 'exists:products,id']
        ];
    }

}

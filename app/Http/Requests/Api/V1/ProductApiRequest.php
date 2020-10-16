<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\ApiBaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProductApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'category_id' => ['numeric', !request()->get('favorite') ? 'required' : '', 'exists:categories,id', 'nullable'],
            'favorite' => ['boolean', !request()->get('category_id') ? 'required' : '', 'nullable']
        ];
    }

}

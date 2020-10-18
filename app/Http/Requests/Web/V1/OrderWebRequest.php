<?php

namespace App\Http\Requests\Web\V1;

use App\Http\Requests\Web\WebBaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class OrderWebRequest extends WebBaseRequest
{
    public function injectedRules()
    {
        return [
            'id' => ['required', 'numeric', 'exists:orders,id']
        ];
    }

}

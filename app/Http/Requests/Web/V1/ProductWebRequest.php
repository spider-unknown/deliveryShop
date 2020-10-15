<?php

namespace App\Http\Requests\Web\V1;

use App\Http\Requests\Web\WebBaseRequest;

class ProductWebRequest extends WebBaseRequest
{
    public function injectedRules()
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'image' => [$this->isStore() ? 'required' : '', 'image'],
            'id' => ['numeric', 'exists:products,id', !$this->isStore() ? 'required' : '']
        ];
    }
}

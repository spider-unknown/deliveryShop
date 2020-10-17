<?php

namespace App\Http\Requests\Web\V1;

use App\Http\Requests\Web\WebBaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CountryWebRequest extends WebBaseRequest
{
    public function injectedRules()
    {
        return [
            'name' => ['required', 'string'],
            'id' => ['numeric', 'exists:countries,id', !$this->isStore() ? 'required' : '']

        ];
    }

}

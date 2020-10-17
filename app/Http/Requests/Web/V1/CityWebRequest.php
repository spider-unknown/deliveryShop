<?php

namespace App\Http\Requests\Web\V1;

use App\Http\Requests\Web\WebBaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CityWebRequest extends WebBaseRequest
{
    public function injectedRules()
    {
        return [
            'name' => ['required', 'string'],
            'id' => ['numeric', 'exists:cities,id', !$this->isStore() ? 'required' : '']

        ];
    }

}

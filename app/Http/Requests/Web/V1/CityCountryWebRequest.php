<?php

namespace App\Http\Requests\Web\V1;

use App\Http\Requests\Web\WebBaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CityCountryWebRequest extends WebBaseRequest
{
    public function injectedRules()
    {
        return [
            'country_id' => ['numeric', 'exists:countries,id', 'required']
        ];
    }

}

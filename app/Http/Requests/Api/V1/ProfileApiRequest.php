<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\ApiBaseRequest;
use App\Models\Enums\Sex;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'name' => ['required', 'string'],
            'surname' => ['required', 'string'],
            'email' => ['required', 'email'],
            'sex' => ['required', Rule::in([Sex::FEMALE, Sex::MALE])],
            'birth_date' => ['required', 'date'],
            'notification' => ['required', 'boolean']
        ];
    }

}

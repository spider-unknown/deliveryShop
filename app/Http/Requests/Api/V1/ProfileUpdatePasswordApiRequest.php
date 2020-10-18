<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\ApiBaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdatePasswordApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'old_password' => ['required', 'min:8', 'string'],
            'password' => ['required', 'min:8', 'string'],
            'password_confirmation' => ['required_with:password', 'same:password'],
        ];
    }

}

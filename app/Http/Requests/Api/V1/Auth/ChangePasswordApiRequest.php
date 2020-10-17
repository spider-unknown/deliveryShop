<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 11.08.2020
 * Time: 12:14
 */

namespace App\Http\Requests\Api\V1\Auth;


use App\Http\Requests\Api\ApiBaseRequest;

class ChangePasswordApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'phone' => ['required', 'string', 'exists:users,phone', 'regex:/^[0-9]+$/', 'min:6', 'max:15'],
            'password' => ['required', 'min:8', 'string'],
            'password_confirmation' => ['required_with:password', 'same:password'],
            'code' => ['required', 'min:4', 'string', 'max:4', 'regex:/^[0-9]+$/']
        ];
    }

}

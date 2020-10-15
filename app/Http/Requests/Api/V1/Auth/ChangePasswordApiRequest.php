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
            'phone' => ['required', 'exists:users,phone'],
            'password' => ['required'],
            'code' => ['required']
        ];
    }

}
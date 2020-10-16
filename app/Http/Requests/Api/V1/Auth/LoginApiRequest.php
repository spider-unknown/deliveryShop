<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 12.07.2020
 * Time: 16:30
 */

namespace App\Http\Requests\Api\V1\Auth;


use App\Http\Requests\Api\ApiBaseRequest;
use App\Models\Enums\Platform;
use Illuminate\Validation\Rule;

class LoginApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'phone' => ['required', 'string', 'exists:users,phone', 'regex:/^[0-9]+$/', 'min:6', 'max:15'],
            'password' => ['required', 'string'],
            'platform' => ['required', Rule::in([Platform::ANDROID, Platform::IOS])],
            'push_id' => ['string']
        ];
    }

}

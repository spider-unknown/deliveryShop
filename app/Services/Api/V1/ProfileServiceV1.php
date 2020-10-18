<?php


namespace App\Services\Api\V1;


use App\Http\Requests\Api\V1\ProfileAddressApiRequest;
use App\Http\Requests\Api\V1\ProfileApiRequest;
use App\Http\Requests\Api\V1\ProfileAvatarApiRequest;
use App\Http\Requests\Api\V1\ProfileUpdatePasswordApiRequest;

interface ProfileServiceV1
{
    public function profile($user_id);
    public function addresses($user_id);
    public function addOrEditAddress($user_id, ProfileAddressApiRequest $request);
    public function changeAvatar($user_id, ProfileAvatarApiRequest $request);
    public function updateProfile($user_id, ProfileApiRequest $request);
    public function updatePassword($user_id, ProfileUpdatePasswordApiRequest $request);
}

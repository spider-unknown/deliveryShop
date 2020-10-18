<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProfileAddressApiRequest;
use App\Http\Requests\Api\V1\ProfileApiRequest;
use App\Http\Requests\Api\V1\ProfileAvatarApiRequest;
use App\Http\Requests\Api\V1\ProfileUpdatePasswordApiRequest;
use App\Services\Api\V1\ProfileServiceV1;
use Illuminate\Http\Request;

class ProfileApiController extends ApiBaseController
{
    protected $profileService;

    /**
     * AuthController constructor.
     * @param $authService
     */
    public function __construct(ProfileServiceV1 $profileService)
    {
        $this->profileService = $profileService;
    }
    public function profile() {
        return $this->ok($this->profileService->profile($this->getCurrentUserId()));
    }

    public function profileUpdate(ProfileApiRequest $request) {
        return $this->ok($this->profileService->updateProfile($this->getCurrentUserId(), $request));
    }

    public function avatarChange(ProfileAvatarApiRequest $request) {
        return $this->ok($this->profileService->changeAvatar($this->getCurrentUserId(), $request));
    }

    public function addresses() {
        return $this->ok($this->profileService->addresses($this->getCurrentUserId()));
    }

    public function addOrEditAddress(ProfileAddressApiRequest $request) {
        return $this->ok($this->profileService->addOrEditAddress($this->getCurrentUserId(), $request));
    }

    public function passwordUpdate(ProfileUpdatePasswordApiRequest $request) {
        return $this->ok($this->profileService->updatePassword($this->getCurrentUserId(), $request));
    }
}

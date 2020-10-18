<?php


namespace App\Services\Api\V1\impl;


use App\Http\Requests\Api\V1\ProfileAddressApiRequest;
use App\Http\Requests\Api\V1\ProfileApiRequest;
use App\Http\Requests\Api\V1\ProfileAvatarApiRequest;
use App\Http\Requests\Api\V1\ProfileUpdatePasswordApiRequest;
use App\Models\Entities\Core\User;
use App\Models\Entities\UserAddress;
use App\Models\Enums\ErrorCode;
use App\Services\Api\V1\ProfileServiceV1;
use App\Services\BaseService;
use App\Services\Common\V1\Support\FileService;
use Illuminate\Support\Facades\Hash;

class ProfileServiceImplV1 extends BaseService implements ProfileServiceV1
{

    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }


    public function profile($user_id)
    {
        $user = $this->getUser($user_id);
        return $user;
    }

    public function addresses($user_id)
    {
        $addresses = UserAddress::where('user_id', $user_id)
            ->orderBy('updated_at', 'desc')
            ->with('city.country')
            ->get();
        return $addresses;
    }

    public function addOrEditAddress($user_id, ProfileAddressApiRequest $request)
    {
        $user = $this->getUser($user_id);
        if($request->id) {
            $address = $user->addresses->where('id', $request->id)->first();
            if(!$address) {
                $this->apiFail([
                    'errorCode' => ErrorCode::RESOURCE_NOT_FOUND,
                    'errors' => [
                        trans('error.not.found')
                    ]
                ]);
            }
            $address->update([
                'user_id' => $user_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'comment' => $request->comment,
                'main' => $request->main
            ]);
        } else {
            $address = UserAddress::create([
                'user_id' => $user_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'comment' => $request->comment,
                'main' => $request->main
            ]);
        }
        if($address->main == true) {
            UserAddress::where('user_id', $user_id)->where('id', '!=', $address->id)->update(['main' => false]);
        }
        return ['message' => trans('actions.edited')];
    }

    public function changeAvatar($user_id, ProfileAvatarApiRequest $request)
    {
        $user = $this->getUser($user_id);
        $path = $this->fileService->updateWithRemoveOrStore($request->avatar, User::AVATAR_DIRECTORY, $user->avatar_path);
        $user->avatar_path = $path;
        $user->save();
        return $user;
    }

    public function updateProfile($user_id, ProfileApiRequest $request)
    {
        $user = $this->getUser($user_id);
        $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'sex' => $request->sex,
            'birth_date' => $request->birth_date,
            'notification' => $request->notification,
            'email' => $request->email,
        ]);
        return $user;
    }

    public function updatePassword($user_id, ProfileUpdatePasswordApiRequest $request)
    {
        $user = $this->getUser($user_id);
        if (!Hash::check($request->old_password, $user->password)) {
            $this->apiFail([
                'errorCode' => ErrorCode::INVALID_OLD_PASSWORD,
                'errors' => [
                    trans('auth.failed')
                ]
            ]);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        return $user;
    }

    private function getUser($user_id) {
        return User::where('id', $user_id)->withCount('addresses', 'orders')->first();
    }

}

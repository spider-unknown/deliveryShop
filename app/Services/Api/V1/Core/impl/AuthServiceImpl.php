<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 12.07.2020
 * Time: 16:28
 */

namespace App\Services\Api\V1\Core\impl;


use App\Core\Utils\JwtUtil;
use App\Exceptions\Api\ApiServiceException;
use App\Models\Entities\Core\PushUser;
use App\Models\Entities\Core\Role;
use App\Models\Entities\Core\User;
use App\Models\Enums\ErrorCode;
use App\Services\Api\V1\Core\AuthService;
use App\Services\BaseService;
use App\Services\Common\V1\Support\CodeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthServiceImpl extends BaseService implements AuthService
{

    protected $codeService;

    /**
     * AuthServiceImpl constructor.
     * @param $codeService
     */
    public function __construct(CodeService $codeService)
    {
        $this->codeService = $codeService;
    }


    public function login($phone, $password, $platform, $push_id)
    {
        $user = User::where('phone', $phone)->first();
        if (!Hash::check($password, $user->password)) {
            $this->apiFail([
                'errorCode' => ErrorCode::AUTH_ERROR,
                'errors' => [
                    trans('auth.failed')
                ]
            ]);
        }
        try {
            DB::beginTransaction();
            $user->devices()->delete();
            PushUser::create([
                'user_id' => $user->id,
                'platform' => $platform,
                'push_id' => $push_id
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->apiFail([
                'errorCode' => ErrorCode::SYSTEM_ERROR,
                'errors' => [
                    trans('error.system'),
                    $exception->getMessage()
                ]
            ]);
        }
        return [
            'token' => JwtUtil::generateTokenFromUser($user),
            'user' => $user
        ];
    }

    public function register($phone, $password, $platform, $push_id)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'phone' => $phone,
                'role_id' => Role::CLIENT_ID,
                'password' => bcrypt($password)
            ]);
            PushUser::create([
                'user_id' => $user->id,
                'platform' => $platform,
                'push_id' => $push_id
            ]);
            $user = User::find($user->id);
            DB::commit();
            return [
                'token' => JwtUtil::generateTokenFromUser($user),
                'user' => $user
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->apiFail([
                'errorCode' => ErrorCode::SYSTEM_ERROR,
                'errors' => [
                    trans('error.system'),
                    $exception->getMessage()
                ]
            ]);

        }
    }

    public function sendCode($phone)
    {
        $code = $this->codeService->generateCode($phone);
        return [
            'code' => $code
        ];
    }

    public function me()
    {
        return auth()->user();
    }

    public function changePassword($phone, $password, $code)
    {
        if (!$this->codeService->checkCode($phone, $code)) {
            $this->apiFail([
                'errors' => [
                    trans('auth.invalid.code')
                ],
                'errorCode' => ErrorCode::INVALID_CODE
            ]);
        }

        $user = User::where('phone', $phone)->first();
        if (!$user) {
            $this->apiFail([
                'errorCode' => ErrorCode::RESOURCE_NOT_FOUND,
                'errors' => [
                    trans('actions.not.found')
                ]
            ]);
        }

        $user->password = bcrypt($password);
        $user->save();
        return [
            'message' => trans('actions.edited')
        ];
    }


}

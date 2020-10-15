<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 12.07.2020
 * Time: 16:29
 */

namespace App\Http\Controllers\Api\V1\Core;


use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\V1\Auth\ChangePasswordApiRequest;
use App\Http\Requests\Api\V1\Auth\LoginApiRequest;
use App\Http\Requests\Api\V1\Auth\RegisterApiRequest;
use App\Http\Requests\Api\V1\Auth\SendCodeApiRequest;
use App\Services\Api\V1\Core\AuthService;

class AuthController extends ApiBaseController
{

    protected $authService;

    /**
     * AuthController constructor.
     * @param $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function login(LoginApiRequest $request)
    {
        return $this->ok(
            $this->authService->login(
                $request->phone,
                $request->password,
                $request->platform,
                $request->push_id
            )
        );
    }

    public function register(RegisterApiRequest $request)
    {
        return $this->ok($this->authService->register(
            $request->phone,
            $request->password,
            $request->platform,
            $request->push_id
        ));
    }

    public function sendCode(SendCodeApiRequest $request)
    {
        return $this->ok(
            $this->authService->sendCode($request->phone)
        );
    }

    public function me()
    {
        return $this->ok(
            $this->authService->me()
        );
    }

    public function changePassword(ChangePasswordApiRequest $request)
    {
        return $this->ok(
            $this->authService->changePassword($request->phone, $request->password, $request->code)
        );
    }
}

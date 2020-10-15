<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 12.07.2020
 * Time: 16:28
 */

namespace App\Services\Api\V1\Core;


interface AuthService
{
    public function login($phone, $password, $platform, $push_id);

    public function register($phone, $password, $platform, $push_id);

    public function me();

    public function sendCode($phone);

    public function changePassword($phone, $password, $code);
}

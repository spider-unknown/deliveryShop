<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 12.07.2020
 * Time: 20:13
 */

namespace App\Services\Common\V1\Support;


interface CodeService
{
    public function generateCode($key);

    public function getCode($key);

    public function checkCode($key, $code, $forget = true);

}
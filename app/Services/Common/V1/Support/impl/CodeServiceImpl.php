<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 12.07.2020
 * Time: 20:15
 */

namespace App\Services\Common\V1\Support\impl;


use App\Core\Utils\CodeUtil;
use App\Services\BaseService;
use App\Services\Common\V1\Support\CodeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class CodeServiceImpl extends BaseService implements CodeService
{
    public function generateCode($key)
    {
        $code = CodeUtil::generateSmsCode(4);
        Cache::put("code-$key", $code, Carbon::now()->addMinutes(3));
        return $code;
    }

    public function checkCode($key, $code, $forget = true): bool
    {
        $codeFromCache = Cache::get("code-$key");
        if ($codeFromCache == $code || $code == '0000') {
            if ($forget) {
                Cache::forget("code-$key");
            }
            return true;
        } else {
            return false;
        }
    }

    public function getCode($key)
    {
        return Cache::get("code-$key");
    }


}

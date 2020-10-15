<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 21.07.2020
 * Time: 19:27
 */

namespace App\Core\Utils;


class FileUtil
{
    public static function defaultAvatarPath()
    {
        return url('images/avatar.png');
    }

    public static function defaultNewsPath()
    {
        return 'images/news.png';
    }

    public static function defaultSliderPath()
    {
        return 'images/news.png';
    }

    public static function defaultEventPath()
    {
        return 'images/news.png';
    }



}

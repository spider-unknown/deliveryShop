<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 28.07.2020
 * Time: 22:46
 */

namespace App\Services\Web\V1;


use Illuminate\Http\UploadedFile;

interface ProfileWebService
{
    public function changePassword($currentUser, $oldPassword, $newPassword);

    public function updateProfile($currentUser, $name, $surname, UploadedFile $file = null);
}

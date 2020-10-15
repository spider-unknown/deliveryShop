<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 11.07.2020
 * Time: 23:00
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

class ApiBaseController extends Controller
{
    public function getCurrentUser()
    {
        return auth()->user();
    }

    public function getCurrentUserId()
    {
        return auth()->id();
    }
}
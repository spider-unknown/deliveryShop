<?php

namespace App\Http\Controllers;

use App\Core\Interfaces\WithUser;
use App\Core\Traits\RespTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController implements WithUser
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, RespTrait;
}

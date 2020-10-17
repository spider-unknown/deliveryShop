<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\Entities\Advertisement;
use App\Models\Entities\Country;
use Illuminate\Http\Request;

class CommonApiController extends ApiBaseController
{
    public function advertisements() {
        return $this->ok(Advertisement::orderBy('created_at', 'desc')->with('product')->get());
    }

    public function cities() {
        return $this->ok(Country::with('cities')->get());
    }
}

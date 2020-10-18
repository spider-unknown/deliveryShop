<?php


namespace App\Services\Api\V1;


use App\Http\Requests\Api\V1\OrderApiRequest;

interface OrderServiceV1
{
    public function orders($user_id);
    public function makeOrder($user_id, OrderApiRequest $request);
}

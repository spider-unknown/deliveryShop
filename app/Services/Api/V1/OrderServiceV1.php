<?php


namespace App\Services\Api\V1;


use App\Http\Requests\Api\V1\OrderApiRequest;
use Illuminate\Http\Request;

interface OrderServiceV1
{
    public function orders($user_id);
    public function makeOrder($user_id, OrderApiRequest $request);
    public function payOrder($transaction_id);
    public function orderStatus($transaction_id);
    public function orderProcess(Request $request);
}

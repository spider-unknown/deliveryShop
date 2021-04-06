<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\V1\OrderApiRequest;
use App\Services\Api\V1\OrderServiceV1;
use Illuminate\Http\Request;

class OrderApiController extends ApiBaseController
{
    protected $orderService;


    public function __construct(OrderServiceV1 $orderService)
    {
        $this->orderService = $orderService;
    }

    public function orders() {
        return $this->ok($this->orderService->orders($this->getCurrentUserId()));
    }

    public function makeOrder(OrderApiRequest $request) {
        return $this->ok($this->orderService->makeOrder($this->getCurrentUserId(), $request));
    }

    public function orderPay(Request $request) {
        return $this->orderService->payOrder($request->transaction_id);
    }

    public function kkbOrderProcess(Request $request) {
        return $this->orderService->orderProcess($request);
    }

    public function kkbOrderStatus(Request $request) {
        return $this->ok($this->orderService->orderStatus($request->transaction_id));
    }

    public function kkbSuccess() {
        return view('modules.kkb.success');
    }

    public function kkbFailure(Request $request) {
        return view('modules.kkb.failure');
    }
}

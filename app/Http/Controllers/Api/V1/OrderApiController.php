<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\V1\OrderApiRequest;
use App\Services\Api\V1\OrderServiceV1;

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
}

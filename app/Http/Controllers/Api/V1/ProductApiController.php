<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FavoriteApiRequest;
use App\Http\Requests\Api\V1\ProductApiRequest;
use App\Services\Api\V1\ProductServiceV1;
use Illuminate\Http\Request;

class ProductApiController extends ApiBaseController
{
    protected $productService;


    public function __construct(ProductServiceV1 $productService)
    {
        $this->productService = $productService;
    }

    public function categories() {
        return $this->ok($this->productService->categories());
    }

    public function products(ProductApiRequest $request) {
        return $this->ok($this->productService->products($request, $this->getCurrentUserId()));
    }

    public function favorite(FavoriteApiRequest $request) {
        return $this->ok($this->productService->favorite($request->product_id, $this->getCurrentUserId()));
    }
}

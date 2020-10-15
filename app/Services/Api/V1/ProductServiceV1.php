<?php


namespace App\Services\Api\V1;


use App\Http\Requests\Api\V1\FavoriteApiRequest;
use App\Http\Requests\Api\V1\ProductApiRequest;
use App\Models\Entities\Core\User;

interface ProductServiceV1
{
    public function categories();
    public function products(ProductApiRequest $request, $user_id);
    public function favorite($product_id, $user_id);
}

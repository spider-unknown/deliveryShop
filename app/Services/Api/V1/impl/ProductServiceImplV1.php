<?php


namespace App\Services\Api\V1\impl;


use App\Http\Requests\Api\V1\ProductApiRequest;
use App\Models\Entities\Category;
use App\Models\Entities\Favorite;
use App\Models\Entities\Product;
use App\Services\Api\V1\ProductServiceV1;
use App\Services\BaseService;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class ProductServiceImplV1 extends BaseService implements ProductServiceV1
{
    public function categories()
    {
        return Category::all();
    }

    public function products(ProductApiRequest $request, $user_id)
    {
        $favorites_sub = DB::table('favorites')
            ->where('user_id', $user_id)
            ->select(['product_id', DB::raw('count(id) as count')])
            ->groupBy('product_id');

        $product_query = Product::select(['products.*',
            DB::raw('case when favorite.product_id is null then false else true end as favorite'),
            ])->leftJoinSub($favorites_sub, 'favorite', function (JoinClause $query) {
            $query->on('favorite.product_id', '=', 'products.id');

        })->orderBy('created_at', 'desc');
        if($request->category_id) {
            $product_query = $product_query->where('category_id', $request->category_id);
        }
        else {
            $favorite_ids = Favorite::where('user_id', $user_id)->pluck('id');
            $product_query = $product_query->whereIn('id', $favorite_ids);
        }
        return $product_query->get();
    }

    public function favorite($product_id, $user_id)
    {
        $favorite = Favorite::where('product_id', $product_id)->where('user_id', $user_id)->first();
        if($favorite) {
            $favorite->delete();
            return ['favorite' => false];

        }
        Favorite::create([
            'product_id' => $product_id,
            'user_id' => $user_id
        ]);
        return ['favorite' => true];
    }


}

<?php

namespace App\Models\Entities\Order;

use App\Models\Entities\Product;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = ['quantity', 'total_price', 'product_id', 'order_id'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

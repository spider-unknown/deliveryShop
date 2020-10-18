<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Web\WebBaseController;
use App\Models\Entities\Order\Order;

class OrderController extends WebBaseController
{
    public function index() {
        $orders = Order::orderBy('created_at', 'desc')->with('details.product', 'address.city.country')->paginate(10);
        return $this->adminPagesView('order.index', compact('orders'));
    }
}

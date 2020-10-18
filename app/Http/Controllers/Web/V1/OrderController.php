<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Web\WebBaseController;
use App\Http\Requests\Web\V1\OrderWebRequest;
use App\Models\Entities\Order\Order;

class OrderController extends WebBaseController
{
    public function index() {
        $orders = Order::orderBy('created_at', 'desc')
            ->with('details.product', 'address.city.country', 'user')->paginate(10);
        return $this->adminPagesView('order.index', compact('orders'));
    }

    public function show(OrderWebRequest $request) {
        $order = Order::where('id', $request->id)->orderBy('created_at', 'desc')
            ->with('details.product', 'address.city.country', 'user')->first();
        return $this->adminPagesView('order.show', compact('order'));
    }

    public function accept(OrderWebRequest $request) {
        $order = Order::find($request->id);
        $order->status = Order::ACCEPTED;
        //PushSend todo
        $order->save();
        $this->edited();
        return redirect()->route('order.index');
    }

    public function delivered(OrderWebRequest $request) {
        $order = Order::find($request->id);
        $order->status = Order::DELIVERED;
        //PushSend todo
        $order->save();
        $this->edited();
        return redirect()->route('order.index');
    }
}

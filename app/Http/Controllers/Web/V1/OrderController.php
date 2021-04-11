<?php

namespace App\Http\Controllers\Web\V1;

use App\Exceptions\Web\WebServiceExplainedException;
use App\Http\Controllers\Web\WebBaseController;
use App\Http\Requests\Web\V1\OrderWebRequest;
use App\Models\Entities\Order\Order;
use App\Models\Entities\Order\Transaction;

class OrderController extends WebBaseController
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')
            ->with('details.product', 'address.city.country', 'user')->paginate(10);
        $transactions = [];
        foreach ($orders as $order) {
             $transactions[] = $order->transaction_detail;
        }
        return $this->adminPagesView('order.index', compact('orders'));
    }

    public function show(OrderWebRequest $request)
    {
        $order = Order::where('id', $request->id)->orderBy('created_at', 'desc')
            ->with('details.product', 'address.city.country', 'user')->first();
        return $this->adminPagesView('order.show', compact('order'));
    }

    public function accept(OrderWebRequest $request)
    {
        $order = Order::find($request->id);
        if ($order->cash) {
           $transaction = Transaction::where('order_id', $order->id)->first();
           if($transaction && $transaction->status == Transaction::PROCESS) {
               throw new WebServiceExplainedException('Транзакция не оплачена!');
           }
        }
        $order->status = Order::ACCEPTED;
        //PushSend todo
        $order->save();
        $this->edited();
        return redirect()->route('order.index');
    }

    public function delivered(OrderWebRequest $request)
    {
        $order = Order::find($request->id);
        $order->status = Order::DELIVERED;
        //PushSend todo
        $order->save();
        $this->edited();
        return redirect()->route('order.index');
    }
}

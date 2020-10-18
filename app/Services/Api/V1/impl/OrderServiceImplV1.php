<?php


namespace App\Services\Api\V1\impl;


use App\Http\Requests\Api\V1\OrderApiRequest;
use App\Models\Entities\Order\Order;
use App\Models\Entities\Order\OrderDetail;
use App\Models\Entities\Product;
use App\Models\Entities\UserAddress;
use App\Models\Enums\ErrorCode;
use App\Services\Api\V1\OrderServiceV1;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class OrderServiceImplV1 extends BaseService implements OrderServiceV1
{
    public function orders($user_id)
    {
        return Order::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->with('details.product', 'address.city.country')->paginate(10);
    }

    public function makeOrder($user_id, OrderApiRequest $request)
    {
        $total_quantity = 0;
        $total_price = 0.0;
        $address = UserAddress::where('id', $request->user_address_id)->where('user_id', $user_id)->first();
        if(!$address) {
            $this->apiFail([
                'errorCode' => ErrorCode::RESOURCE_NOT_FOUND,
                'errors' => [
                    trans('error.not.found')
                ]
            ]);
        }
        $orders_products = [];
        $order_details = [];
        foreach ($request->products as $product_order) {
            $now = now();
            $product = Product::find($product_order['id']);
            $total = $product->price * $product_order['quantity'];
            $orders_products[] = array(
                'product_id' => $product_order['id'],
                'quantity' => $product_order['quantity'],
                'total_price' => $total,
                'created_at' => $now,
                'updated_at' => $now
            );
            $total_price += $total;
            $total_quantity += $product_order['quantity'];
        }
        try {
            DB::beginTransaction();
            $order = Order::create([
                'total_quantity' => $total_quantity,
                'total_amount' => $total_price,
                'status' => Order::PROCESS,
                'courier' => $request->courier,
                'cash' => $request->cash,
                'user_id' => $user_id,
                'user_address_id' => $request->user_address_id,
            ]);
            foreach ($orders_products as $product) {
                $order_details[] = array(
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'total_price' => $product['total_price'],
                    'order_id' => $order->id,
                    'created_at' => $product['created_at'],
                    'updated_at' => $product['updated_at']
                );
            }
            OrderDetail::insert($order_details);
            DB::commit();
            return ['message' => trans('actions.added')];
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->apiFail([
                'errorCode' => ErrorCode::SYSTEM_ERROR,
                'errors' => [
                    trans('error.system.fail'),
                    $exception->getMessage()
                ]
            ]);
        }
    }


}

<?php

namespace App\Models\Entities\Order;

use App\Models\Entities\Core\User;
use App\Models\Entities\UserAddress;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const PROCESS = 0;
    public const ACCEPTED = 1;
    public const DELIVERED = 2;

    protected $fillable = [
        'total_quantity', 'total_amount', 'user_id', 'user_address_id',
        'status', 'courier', 'cash'];

    public function details() {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function address() {
        return $this->belongsTo(UserAddress::class, 'user_address_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

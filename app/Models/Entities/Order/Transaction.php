<?php

namespace App\Models\Entities\Order;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public const PROCESS = 0;
    public const PAID = 1;
    public const FAILS = 2;
    protected $fillable = ['approval_code', 'reference', 'terminal',
        'status', 'amount', 'order_id', 'transaction_id'];

    public static function generateTransactionId()
    {
        do
        {
            $transaction_id = mt_rand(1, 9);
            while (strlen($transaction_id) < 15)
                $transaction_id .= mt_rand(0, 9);
        }
        while (self::where('transaction_id', $transaction_id)->first() != null);

        return $transaction_id;
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}

<?php


namespace App\Services\Integration\V1;


use Illuminate\Http\Request;

interface KKBService
{
    public function pay($transaction_id, $user, $order);
    public function status($transaction_id);
    public function process(Request $request);
}

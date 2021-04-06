<?php


namespace App\Services\Integration\V1\impl;


use App\Exceptions\Api\ApiServiceException;
use App\Models\Enums\ErrorCode;
use App\Services\BaseService;
use App\Services\Integration\KKBSign;
use App\Services\Integration\V1\KKBService;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class KKBServiceImpl extends BaseService implements KKBService
{
    public function pay($transaction_id, $user, $order_detail)
    {

        $merchant_id = env('KKB_MERCHANT_ID');
        $cert_id = File::get(storage_path() . '/keys/kkb/' . $merchant_id . '/merchant_cert_id');
        $merchant_name = File::get(storage_path() . '/keys/kkb/' . $merchant_id . '/merchant_name');
        $keypass = File::get(storage_path() . '/keys/kkb/' . $merchant_id . '/password');

        $merchant_name = preg_replace("/\r|\n/", '', $merchant_name);
        $keypass = preg_replace("/\r|\n/", '', $keypass);
        $cert_id = preg_replace("/\r|\n/", '', $cert_id);

        $currency = 398;
        $xml = new \SimpleXMLElement('<document></document>');
        $merchant = $xml->addChild('merchant');
        $merchant->addAttribute('cert_id', $cert_id);
        $merchant->addAttribute('name', $merchant_name);
        $order = $merchant->addChild('order');
        $order->addAttribute('amount', $order_detail->total_amount);
        $order->addAttribute('currency', $currency);
        $order->addAttribute('order_id', $transaction_id);

        $department = $order->addChild('department');
        $department->addAttribute('merchant_id', $merchant_id);
        $department->addAttribute('amount', $order_detail->total_amount);
        $department->addAttribute('phone', $user->phone);
        $signer = new KKBSign();
        $signer->invert();
        $signer->load_private_key(storage_path() . "/keys/kkb/" . $merchant_id . "/cert.prv", $keypass);
        $xml_signature = $signer->sign64($xml->merchant[0]->asXML());
        $merchant_sign = $xml->addChild('merchant_sign');
        $merchant_sign->addAttribute('type', "RSA");
        $merchant_sign[0] = $xml_signature;
        $appendix = new \SimpleXMLElement('<document></document>');
        $item = $appendix->addChild('item');
        $item->addAttribute('name', "Заказ");
        $item->addAttribute('quantity', $order_detail->total_quantity);
        $item->addAttribute('amount', $order_detail->total_amount);
//        $url = 'https://testpay.kkb.kz/jsp/process/logon.jsp';
                $url = 'https://epay.kkb.kz/jsp/process/logon.jsp';
        return view('modules.kkb.redirect')->with('url', $url)
            ->with('signed_order_b64', base64_encode(preg_replace('!^[^>]+>(\r\n|\n|)!', '', $xml->asXML())))
            ->with('email', $user->email)
            ->with('post_link', URL::asset('api/V1/order/payment/process'))
            ->with('back_link', URL::asset('api/V1/order/payment/success'))
            ->with('failure_link', URL::asset('api/V1/order/payment/failure'));
    }

    public function status($transaction_id)
    {
        $merchant_id = env('KKB_MERCHANT_ID');
        $cert_id = File::get(storage_path() . '/keys/kkb/' . $merchant_id . '/merchant_cert_id');
        $keypass = File::get(storage_path() . '/keys/kkb/' . $merchant_id . '/password');

        $keypass = preg_replace("/\r|\n/", '', $keypass);
        $cert_id = preg_replace("/\r|\n/", '', $cert_id);

        $xml = new \SimpleXMLElement('<document></document>');

        $merchant = $xml->addChild('merchant');
        $merchant->addAttribute('id', $merchant_id);

        $order = $merchant->addChild('order');
        $order->addAttribute('id', $transaction_id);

        $signer = new KKBSign();
        $signer->invert();
        $signer->load_private_key(storage_path() . "/keys/kkb/" . $merchant_id . "/cert.prv", $keypass);
        $xml_signature = $signer->sign64($xml->merchant[0]->asXML());
        $merchant_sign = $xml->addChild('merchant_sign');
        $merchant_sign->addAttribute('cert_id', $cert_id);
        $merchant_sign[0] = $xml_signature;
        $url = 'https://testpay.kkb.kz/jsp/remote/checkOrdern.jsp' . '?' . urlencode($xml->asXml());
        $client = new \GuzzleHttp\Client();
        $response_raw = $client->request('GET', $url, [
            'http_errors' => false
        ]);

        if ($response_raw->getStatusCode() != 200)
            throw new ApiServiceException("", 400);

        $response_body = $response_raw->getBody();
        $response_xml = simplexml_load_string($response_body, "SimpleXMLElement", LIBXML_NOCDATA);
        $error = (string)$response_xml[0];
        if ($error != null)
            $this->apiFail([
                'errorCode' => ErrorCode::INVALID_ARGUMENT,
                'errors' => [$error]
            ]);
        $signature = (string)$response_xml->bank_sign;
        $payment = (bool)$response_xml->bank->response['payment'];
        $status = (int)$response_xml->bank->response['status'];
        $result = (int)$response_xml->bank->response['result'];
        $signer = new KKBSign();
        $signer->invert();
        if (!$signer->check_sign64($response_xml->bank[0]->asXML(), $signature, storage_path() . "/keys/kkb/" . $merchant_id . "/kkbca.pem"))
            $this->apiFail([
                'errorCode' => ErrorCode::INVALID_ARGUMENT,
                'errors' => ["Invalid signature"]
            ]);
        $result1 = 'status: ' . $status . ' payment: ' . $payment . ' result: ' . $result;
        return $result1;
    }

    public function process(Request $request)
    {
        $merchant_id = env('KKB_MERCHANT_ID');
        $xml = simplexml_load_string($request->get('response'), "SimpleXMLElement", LIBXML_NOCDATA);
        $signature = (string)$xml->bank_sign;
        $signature = str_replace(' ', '+', $signature);
        $signer = new KKBSign();
        $signer->invert();
        if (!$signer->check_sign64($xml->bank[0]->asXML(), $signature, storage_path() . "/keys/kkb/". $merchant_id ."/kkbca.pem"))
            $this->apiFail([
                'errorCode' => ErrorCode::INVALID_ARGUMENT,
                'errors' => ["Invalid signature"]
            ]);

        $order_id = (string)$xml->bank->customer->merchant->order['order_id'];
        $status = (string)$xml->bank->results->payment['response_code'];
        $merchant_id = (int)$xml->bank->results->payment['merchant_id'];
        $amount = (int)$xml->bank->results->payment['amount'];
        $approval_code = (int)$xml->bank->results->payment['approval_code'];
        $reference = (string)$xml->bank->results->payment['reference'];

        if ($status !== "00")
            $this->apiFail([
                'errorCode' => ErrorCode::PAYMENT_REJECTED,
                'errors' => ["status" => $status]
            ]);
        return [
            'merchant_id' => $merchant_id,
            'order_id' => $order_id,
            'amount' => $amount,
            'reference' => $reference,
            'approval_code' => $approval_code
        ];
    }


}

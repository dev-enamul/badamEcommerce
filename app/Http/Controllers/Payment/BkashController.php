<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BkashController extends Controller
{
    private $base_url;
    private $app_key;
    private $app_secret;
    private $username;
    private $password;
    public function __construct()
    {
        // bKash Merchant API Information

        // You can import it from your Database
        $bkash_app_key = '1mfFpqJA1O3puvvVzEfX0HQJch'; // '4f6o0cjiki2rfm34kfdadl1eqq'; // bKash Merchant API APP KEY
        $bkash_app_secret = 'fABkIH59TDteButf5z41V08QZ6WUjSCHteyuEGltOsxWJzGjztAB'; // '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b'; // bKash Merchant API APP SECRET
        $bkash_username = '01316120390'; // 'sandboxTokenizedUser02'; // bKash Merchant API USERNAME
        $bkash_password = 'etX4h.0<MNF'; // 'sandboxTokenizedUser02@12345'; // bKash Merchant API PASSWORD
        $bkash_base_url = 'https://tokenized.pay.bka.sh/v1.2.0-beta'; // 'https://checkout.pay.bka.sh/v1.2.0-beta';  // For Live Production URL: https://checkout.pay.bka.sh/v1.2.0-beta

        $this->app_key = $bkash_app_key;
        $this->app_secret = $bkash_app_secret;
        $this->username = $bkash_username;
        $this->password = $bkash_password;
        $this->base_url = $bkash_base_url;
    }


    public function getToken()
    {

        $post_token = array(
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret
        );

        // return $post_token;

        $url = curl_init("$this->base_url/tokenized/checkout/token/grant");
        // $post_token = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
            "password:$this->password",
            "username:$this->username"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $post_token);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);

        $response = json_decode($resultdata, true);
        // $response2 = json_encode($response, true);
        return $response;
    }

    public function createPayment($order_code, $amount)
    {

        return  $tokenResponse = self::getToken();

        $token = $tokenResponse['id_token'];

        $body_data = array(
            'mode' => '0011',
            'payerReference' => null,
            'callbackURL' => url('/bkash/callback'), //'https://badami.com/bkash/callback', //'https://badami.com.bd/order-confirmed?orderCode=' . $order_code,
            'amount' => $amount, //Session::get('payment_amount'),
            'successCallbackURL' => url('/success'), //'https://badami.com/success',
            'failureCallbackURL' => url('/cancel'), //'https://badami.com/cancel',
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $order_code
        );
        $request_data_json = json_encode($body_data);

        $url = curl_init("$this->base_url/tokenized/checkout/create");
        // $token = Session::get('bkash_token_final');
        // Zone::find(115)->update([
        //     'token' => $token
        // ]);
        $header = array(
            'Content-Type:application/json',
            "Authorization: $token",
            "X-APP-Key: $this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);


        return json_decode($resultdata, true);
    }



    public function pay(Request $request)
    {
        // return $request->all();
        $response =  self::createPayment($request->order_code, $request->amount);
        return $response;
    }


    public function updateTrnId(Request $request)
    {
        CombinedOrder::where('code', $request->order_code)->update(['transaction_id' => $request->paymentID]);
    }

    public function executePayment(Request $request)
    {
        // return $request->paymentID;
        $tokenResponse = self::getToken();
        $token = $tokenResponse['id_token'];

        $url = curl_init("$this->base_url/tokenized/checkout/execute");
        $header = array(
            'Content-Type:application/json',
            "Authorization:$token",
            "X-App-Key:$this->app_key"
        );
        $body_data = array(
            'paymentID' => $request->paymentID,

        );
        $request_data_json = json_encode($body_data);

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);

        // Transaction::create([
        //     'statusCode' => $resultdata['statusCode'],
        //     'statusMessage' => $resultdata['statusMessage'],
        //     'paymentID' => $resultdata['paymentID'],
        //     'payerReference' => $resultdata['payerReference'],
        //     'customerMsisdn' => $resultdata['customerMsisdn'],
        //     'trxID' => $resultdata['trxID'],
        //     'amount' => $resultdata['amount'],
        //     'transactionStatus' => $resultdata['transactionStatus'],
        //     'paymentExecuteTime' => Carbon::parse($resultdata['paymentExecuteTime'])->format('Y-m-d'),
        //     'currency' => $resultdata['currency'],
        //     'intent' => $resultdata['intent'],
        //     'merchantInvoiceNumber' => $resultdata['merchantInvoiceNumber'],
        // ]);

        $combinedOrder = CombinedOrder::where('transaction_id', $request->paymentID)->first();
        Order::where('combined_order_id', $combinedOrder->id)->update(['payment_status' => 'paid']);

        return $resultdata; // redirect()->to(url('/success?payment_type=bkash'));
    }


    public function callback(Request $request)
    {
        // return $request;

        if ($request->status === "success") {

            return redirect()->to(url('/proceed?paymentID=' . $request->paymentID));
        }

        // return redirect()->to(url('/success?payment_type=bkash'));

        if ($request->status === "cancel") {

            return redirect()->to(url('/cancel?payment_type=bkash'));
        }

        if ($request->status === "failure") {

            return redirect()->to(url('/failed?payment_type=bkash'));
        }
    }



    public function bkashRefund(Request $request)
    {

        // return $request->all();
        $tokenResponse = self::getToken();
        $token = $tokenResponse['id_token'];

        $url = curl_init("$this->base_url/tokenized/checkout/payment/refund");
        $header = array(
            'Content-Type:application/json',
            'Accept:application/json',
            "Authorization:$token",
            "X-App-Key:$this->app_key"
        );



        $body_data = array(
            'paymentID' => $request->paymentID,
            'amount' => $request->amount,
            'trxID' => $request->trxID,
            'sku' => $request->sku,
            'reason' => $request->reason,

        );
        $request_data_json = json_encode($body_data);

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);
        return $resultdata;
    }



    public function storeLog($url, $header, $body_data, $response)
    {
        $log_data = ["url" => $this->base_url . $url, "header" => $header, "body" => $body_data, "api response" => json_decode($response)];
        return Log::channel('bkash')->info($log_data);
    }






    public function queryPayment()
    {
        $tokenResponse = self::getToken();
        $token = $tokenResponse['id_token'];
        $paymentID = "TR00119F1666420768226"; //$request->payment_info['payment_id'];


        $requestbody = array(
            'paymentID' => $paymentID
        );
        $requestbodyJson = json_encode($requestbody);

        $url = curl_init("$this->base_url/tokenized/checkout/payment/status");


        $header = array(
            'Content-Type:application/json',
            "authorization:$token",
            "x-app-key:$this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdatax = curl_exec($url);
        curl_close($url);

        return response()->json(json_decode($resultdatax, true));
    }

    public function bkashSuccess(Request $request)
    {
        // IF PAYMENT SUCCESS THEN YOU CAN APPLY YOUR CONDITION HERE
        if ('Noman' == 'success') {

            // THEN YOU CAN REDIRECT TO YOUR ROUTE

            Session::flash('successMsg', 'Payment has been Completed Successfully');

            return response()->json(['status' => true]);
        }

        Session::flash('error', 'Noman Error Message');

        return response()->json(['status' => false]);
    }

    public function bkashCancel(Request $request)
    {
    }


    public function bkashFailed(Request $request)
    {
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CombinedOrder;
use App\Models\Order;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\OrderUpdate;
use Session;
use Auth;
use Notification;
use App\Notifications\OrderPlacedNotification;


use Illuminate\Support\Facades\Redirect;

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
        $bkash_base_url = 'https://checkout.pay.bka.sh/v1.2.0-beta'; //  'https://tokenized.sandbox.bka.sh/v1.2.0-beta';  // For Live Production URL: https://checkout.pay.bka.sh/v1.2.0-beta

        $this->app_key = $bkash_app_key;
        $this->app_secret = $bkash_app_secret;
        $this->username = $bkash_username;
        $this->password = $bkash_password;
        $this->base_url = $bkash_base_url;
    }


    public function getToken()
    {

        $request_data = array(
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret

        );

        $request_data_json = json_encode($request_data);


        $url = curl_init("$this->base_url/checkout/token/grant");
        // $post_token = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
            "password:$this->password",
            "username:$this->username"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        $resultdata = curl_exec($url);
        curl_close($url);

        $response = json_decode($resultdata, true);
        return $response;
    }

    public function createPayment($order_code, $amount)
    {

        // return $amount;

        $tokenResponse = self::getToken();

        $token = $tokenResponse['id_token'];

        $request_data = array(
            'amount' => $amount,
            'grand_total' => $amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $order_code,
            
        );

        $url = curl_init("$this->base_url/checkout/payment/create");
        $request_data_json = json_encode($request_data);
        $header = array(
            "Content-Type:application/json",
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
        // return $request->amount;
        $response =  self::createPayment($request->order_code, $request->amount);
        return $response;
    }


    public function updateTrnId(Request $request)
    {
        CombinedOrder::where('code', $request->order_code)->update(['transaction_id' => $request->paymentID]);
    }

    public function executePayment(Request $request)
    {
        // return  $request;
        $tokenResponse = self::getToken();
        $token = $tokenResponse['id_token'];

        $url = curl_init("$this->base_url/checkout/payment/execute/$request->paymentID");

        $header = array(
            "Content-Type:application/json",
            "Authorization:$token",
            "X-App-Key:$this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);

        $combinedOrder = CombinedOrder::where('transaction_id', $request->paymentID)->first();
        Order::where('combined_order_id', $combinedOrder->id)->update(['payment_status' => 'paid']);
        $order =  Order::where('combined_order_id', $combinedOrder->id)->where('user_id', $combinedOrder->user_id)->first();

        $itemIds = OrderDetail::where('order_id', $order->id)->pluck('product_id')->toArray();
        
        foreach($itemIds as $key => $item){
          Cart::where('user_id', $combinedOrder->user_id)->delete(); 
        }

        $user = User::find($combinedOrder->user_id); //auth('api')->user();

    try {
            Notification::send($user, new OrderPlacedNotification($combinedOrder));           
        } catch (\Exception $e) {
    }

        return $resultdata; // redirect()->to(url('/success?payment_type=bkash'));
    }


    public function callback(Request $request)
    {
        // return $request;

        if ($request->status === "success") {
            $combinedOrder = CombinedOrder::where('transaction_id', $request->paymentID)->first();
            $order = Order::where('combined_order_id', $combinedOrder->id)->first();
            $orderDetails = OrderDetail::where('order_id', $order->id)->first();
            Cart::destroy('product_id', $orderDetails->product_id);
            return redirect()->to(url('/proceed?paymentID=' . $request->paymentID));
        }

        // return redirect()->to(url('/success?payment_type=bkash'));

        if ($request->status === "cancel") {

        // return $request;
        $combinedOrder = CombinedOrder::where('transaction_id', $request->paymentID)->first();
        // Order::where('combined_order_id', $combinedOrder->id)->update(['payment_status' => 'unpaid']);
        $order = Order::where('combined_order_id', $combinedOrder->id)->first();
        OrderDetail::where('order_id', $order->id)->delete();
        OrderUpdate::where('order_id', $order->id)->delete();
        Order::where('combined_order_id', $combinedOrder->id)->delete();
        CombinedOrder::where('transaction_id', $request->paymentID)->delete();
            return redirect()->to(url('/cancel?payment_type=bkash'));
        }

        if ($request->status === "failure") {
            // $combinedOrder = CombinedOrder::where('transaction_id', $request->paymentID)->first();
            // Order::where('combined_order_id', $combinedOrder->id)->update(['payment_status' => 'unpaid']);
            
             $combinedOrder = CombinedOrder::where('transaction_id', $request->paymentID)->first();
            // Order::where('combined_order_id', $combinedOrder->id)->update(['payment_status' => 'unpaid']);
            $order = Order::where('combined_order_id', $combinedOrder->id)->first();
            OrderDetail::where('order_id', $order->id)->delete();
            OrderUpdate::where('order_id', $order->id)->delete();
            Order::where('combined_order_id', $combinedOrder->id)->delete();
            CombinedOrder::where('transaction_id', $request->paymentID)->delete();
            
            return redirect()->to(url('/failed?payment_type=bkash'));
        }
    }


    public function queryPayment()
    {
        // return $request->payment_id;
        $tokenResponse = self::getToken();
        $token = $tokenResponse['id_token'];

        $paymentID = "76E43H41667307467001"; //'X11TZRI1667308149695';
        // $requestbody = array(
        //     'paymentID' => $paymentID
        // );
        // $requestbodyJson = json_encode($requestbody);

        $url = curl_init("$this->base_url/checkout/payment/query/$paymentID");


        $header = array(
            "Content-Type:application/json",
            "Authorization:$token",
            "X-App-Key:$this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdatax = curl_exec($url);

        curl_close($url);

        return response()->json(json_decode($resultdatax, true));
    }

    public function bkashRefund(Request $request)
    {

        // return $request->all();
        $tokenResponse = self::getToken();
        $token = $tokenResponse['id_token'];

        $url = curl_init("$this->base_url/checkout/payment/refund");
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

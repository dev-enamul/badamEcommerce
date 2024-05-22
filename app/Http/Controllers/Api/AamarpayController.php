<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use \Shipu\Aamarpay\Aamarpay;

class AamarpayController extends Controller
{

    public function aamarpay(Request $request)
    {
        $url = 'https://secure.aamarpay.com/request.php';
        $fields = array(
            'store_id' => 'badami', //'aamarpay' //store id will be aamarpay,  contact integration@aamarpay.com for test/live id
            'amount' => $request->amount, //transaction amount
            'payment_type' => 'VISA', //no need to change
            'currency' => 'BDT',  //currenct will be USD/BDT
            'tran_id' => $request->order_code, // rand(1111111, 9999999), //transaction id must be unique from your end
            'cus_name' => $request->cus_name,  //customer name
            'cus_email' => $request->cus_email, //customer email address
            'cus_add1' => $request->cus_add1,  //customer address
            'cus_add2' => 'Mohakhali DOHS', //customer address
            'cus_city' => $request->cus_city,  //customer city
            'cus_state' => $request->cus_state,  //state
            'cus_postcode' => $request->cus_postcode, //postcode or zipcode
            'cus_country' => 'Bangladesh',  //country
            'cus_phone' => $request->cus_phone, //customer phone number
            'cus_fax' => 'Not¬Applicable',  //fax
            'ship_name' => 'ship name', //ship name
            'ship_add1' => 'House B-121, Road 21',  //ship address
            'ship_add2' => 'Mohakhali',
            'ship_city' => 'Dhaka',
            'ship_state' => 'Dhaka',
            'ship_postcode' => '1212',
            'ship_country' => 'Bangladesh',
            'desc' => 'payment description',
            'success_url' => url('/payment/aamarpay/success'), //your success route
            'fail_url' => url('/cancel?payment_type=aamarpay'), //'https://badami.com.bd/cancel?payment_type=aamarpay', //your fail route
            'cancel_url' => url('/cancel?payment_type=aamarpay'), //'https://badami.com.bd/cancel?payment_type=aamarpay', //your cancel url
            'opt_a' => 'Reshad',  //optional paramter
            'opt_b' => 'Akil',
            'opt_c' => 'Liza',
            'opt_d' => 'Sohel',
            'signature_key' => '744a804598ddb62e9b423051aa3df176', // '28c78bb1f45112f5d40b956fe104645a'
        );


        $fields_string = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));
        $payment_url = 'https://secure.aamarpay.com' . $url_forward;
        curl_close($ch);

        return $payment_url;

        // $this->redirect_to_merchant($url_forward);


    }

    public function aamarpaySuccess(Request $request)
    {
        // return $request->all();


    }
}

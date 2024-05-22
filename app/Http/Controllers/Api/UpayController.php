<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UpayController extends Controller
{

    private  $merchant_id;
    private  $merchant_key;
    private  $upay_base_url;

    public function __construct()
    {
        $merchant_id = "1150413040007635"; //"1110101010000002";
        $merchant_key = "CmOPkwNhTX5W0uGx2v33pgdo7A803Sl7"; //"q1116pgDpVUuU82na9OzAJyrBKY344b7";
        $upay_base_url = "https://pg.upaysystem.com"; //"https://uat-pg.upay.systems";

        $this->merchant_id = $merchant_id;
        $this->merchant_key = $merchant_key;
        $this->upay_base_url = $upay_base_url;
    }

    public function getToken()
    {

        $credentials = array(
            'merchant_id' => $this->merchant_id,
            'merchant_key' => $this->merchant_key
        );

        $url = $this->upay_base_url . '/payment/merchant-auth/';



        $fields_string = http_build_query($credentials);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }


    public function createPayment($order_code, $amount)
    {
    }

    public function upay(Request $request)
    {
    }
}

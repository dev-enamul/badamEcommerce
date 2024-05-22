<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BDPaymentController extends Controller
{
    public function bdPaymentMethod(){
        $paymentMethods = Setting::where('value', 1)->get();

        $data = [];

        foreach ($paymentMethods as $key => $paymentMethod) {

            if($paymentMethod->type == "bkash"){
                $data['bkash'] = $paymentMethod->value;
            }

            if($paymentMethod->type == "nagad"){
                $data['nagad'] = $paymentMethod->value;
            }

            if($paymentMethod->type == "upay"){
                $data['upay'] = $paymentMethod->value;
            }

            if($paymentMethod->type == "aamarpay"){
                $data['aamarpay'] = $paymentMethod->value;
            }

        }

        return response()->json($data);
    }
}

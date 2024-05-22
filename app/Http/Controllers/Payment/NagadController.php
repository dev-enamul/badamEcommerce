<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DGvai\Nagad\Facades\Nagad;

class NagadController extends Controller
{
    public function nagadSuccess(Request $request)
    {
        return $request;
    }


    public function createNagadPayment(Request $request)
    {
        // return $request->all();
        /**
         * Method 2: Manual Redirection
         * This will return only the redirect URL and manually redirect to the url
         * */

        $url = Nagad::setOrderID($request->order_code)
            ->setAmount($request->amount)
            ->checkout()
            ->getRedirectUrl();
        // dd($url);
        return ['url' => $url];
    }


    public function callback(Request $request)
    {
        // return 'it works';
        $verified = Nagad::callback($request)->verify();
        if ($verified->success()) {

            // Get Additional Data
            dd($verified->getAdditionalData());

            // Get Full Response
            dd($verified->getVerifiedResponse());
        } else {

            $message = $verified->getErrors();
            return redirect()->to(url('/cancel'));
            // dd($verified->getErrors());
        }
    }
}

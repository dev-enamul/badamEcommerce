<?php

namespace App\Http\Controllers\Payment;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\CombinedOrder;
use Illuminate\Support\Carbon;
use Codeboxr\Upay\Facade\Payment;
use App\Http\Controllers\Controller;

class UpayController extends Controller
{

    public function upaySuccess(Request $request)
    {
        return $request;
    }

    public function createUpayPayment(Request $request)
    {
        // return $request->all();
        $order_date = Carbon::now()->format('Y-m-d');
        $response =  Payment::executePayment($request->amount, $request->order_code, $request->order_code, $order_date);
        // dd($response);
        return $response;
    }

    public function callback(Request $request)
    {
        // ORD2022102616442459
        // return Payment::queryPayment('ORD2022102616442459');

        if ($request->status === "successful") {

            $combinedOrder = CombinedOrder::where('code', $request->invoice_id)->first();
            Order::where('combined_order_id', $combinedOrder->id)->update(['payment_status' => 'paid']);
            return redirect()->to(url('/order-confirmed?orderCode=' . $request->invoice_id));
        }

        // return redirect()->to(url('/success?payment_type=upay'));

        if ($request->status === "cancel") {
            // return $request;
            return redirect()->to(url('/cancel?payment_type=upay'));
        }

        if ($request->status === "failed") {

            return redirect()->to(url('/failed?payment_type=upay'));
        }

        if ($request->status === "expired") {

            return redirect()->to(url('/failed?payment_type=upay&status=expired'));
        }
    }
}

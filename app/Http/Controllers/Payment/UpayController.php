<?php

namespace App\Http\Controllers\Payment;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CombinedOrder;
use Illuminate\Support\Carbon;
use Codeboxr\Upay\Facade\Payment;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\OrderUpdate;
use Notification;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Auth;

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

    public function removeOrderDetails($request){
        $combinedOrder = CombinedOrder::where('code', $request->invoice_id)->first();
        // Order::where('combined_order_id', $combinedOrder->id)->update(['payment_status' => 'unpaid']);
        $order = Order::where('combined_order_id', $combinedOrder->id)->first();
        OrderDetail::where('order_id', $order->id)->delete();
        OrderUpdate::where('order_id', $order->id)->delete();
        Order::where('combined_order_id', $combinedOrder->id)->delete();
        CombinedOrder::where('transaction_id', $request->paymentID)->delete();
    }

    public function callback(Request $request)
    {
        // ORD2022102616442459
        // return Payment::queryPayment('ORD2022102616442459');

        if ($request->status === "successful") {

            $combinedOrder = CombinedOrder::where('code', $request->invoice_id)->first();

            

            Order::where('combined_order_id', $combinedOrder->id)->update(['payment_status' => 'paid']);

            
            $order =  Order::where('combined_order_id', $combinedOrder->id)->where('user_id', $combinedOrder->user_id)->first();

            $itemIds = OrderDetail::where('order_id', $order->id)->pluck('product_id')->toArray();
        
            foreach($itemIds as $key => $item){
            Cart::where('user_id', $combinedOrder->user_id)->delete(); 
            }

            $user = User::find($combinedOrder->user_id); //Auth::user(); //auth('api')->user();           

            try {
                    Notification::send($user, new OrderPlacedNotification($combinedOrder));
                } catch (\Exception $e) {
            }

            return redirect()->to(url('/order-confirmed?orderCode=' . $request->invoice_id));
            
        }

        // return redirect()->to(url('/success?payment_type=upay'));

        if ($request->status === "cancel") {
            // return $request;
           
            $this->removeOrderDetails($request);

            return redirect()->to(url('/cancel?payment_type=upay'));
        }

        if ($request->status === "failed") {
            $this->removeOrderDetails($request);
            return redirect()->to(url('/failed?payment_type=upay'));
        }

        if ($request->status === "expired") {
            $this->removeOrderDetails($request);
            return redirect()->to(url('/failed?payment_type=upay&status=expired'));
        }
    }
}

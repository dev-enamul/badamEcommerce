<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\CombinedOrder;
use Illuminate\Support\Carbon;
use Codeboxr\Upay\Facade\Payment;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\OrderUpdate;
use Notification;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Support\Facades\Session;
use Auth;

class AamarpayController extends Controller
{
    public function aamarpaySuccess(Request $request)
    {
        // return $request->all();

        $combinedOrder = CombinedOrder::where('code', $request->mer_txnid)->first();

            

            Order::where('combined_order_id', $combinedOrder->id)->update(['payment_status' => 'paid']);

            
            $order =  Order::where('combined_order_id', $combinedOrder->id)->where('user_id', $combinedOrder->user_id)->first();

            $itemIds = OrderDetail::where('order_id', $order->id)->pluck('product_id')->toArray();
        
            foreach($itemIds as $key => $item){
            Cart::where('user_id', $combinedOrder->user_id)->where('product_id', $item)->delete(); 
            }

            $user = User::find($combinedOrder->user_id); //Auth::user(); //auth('api')->user();           

            try {
                    Notification::send($user, new OrderPlacedNotification($combinedOrder));
                } catch (\Exception $e) {
            }

        return redirect()->to(url('/order-confirmed?orderCode=' . $request->mer_txnid));
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PaymentPaypalController extends Controller
{

    public function paypalPayment(Request $request,$transaction_id){
        $order_id =  $request->Session()->get('order_id');

        if (Auth::user()){

            Order::where('id',$order_id)->update([
                'status' => $transaction_id ,
            ]);

            $alert = array(
                'alert-type' => "success",
                'message' => "order done wait Delivery",
            );
            return  redirect()->route('thank_you')->with($alert);

        }elseif(Session::has('order_id')){

            Order::where('id',$order_id)->update([
                'status' => $transaction_id ,
            ]);

            $alert = array(
                'alert-type' => "success",
                'message' => "order done wait Delivery",
            );
            return  redirect()->route('thank_you')->with($alert);

        }


    }
}

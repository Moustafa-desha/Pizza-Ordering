<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DeliveryController extends Controller
{

   /*** for user ***/

    public function thankYou(){

         $order_id = Session()->get('order_id');
        if(Auth::user()){
            $orders =  Order::where('user_id', Auth::id())->get();
            return view('web.thank_you',compact('orders'));


        }elseif ( Session::has('order_id')){

            return view('web.thank_you',compact('order_id'));

        }elseif ( !Session::has('order_id')){
            return redirect('cart');
        }

    } // END METHOD

    public function deliveryStatus($id){
        $delivery = Order::where('id',$id)->select('delivery')->first();

        return view('web.delivery_status',compact('delivery'));
    } // END METHOD

    /*** End  user ***/


    public function orderReady($id)
    {
        Order::where('id',$id)->update(['delivery'=>1]);

        $notificat = array(
            'message' => 'Payment Accepted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('showNewOrder')->with($notificat);
    }//END METHOD


    public function adminProgressDelivery($id)
    {
        Order::where('id',$id)->update(['delivery'=>2]);

        $notificat = array(
            'message' => 'Order Send To Delivery',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notificat);
    }//END METHOD

    public function adminDoneDelivery($id)
    {
        /***** 1- another way to calculate quantity use anyone u like ******/
        $orderDetailId = DB::table('order_details')
            ->join('products','order_details.product_id','products.id')
            ->where('order_id',$id)
            ->update(['products.quantity'=> DB::raw('products.quantity-' . 'order_details.product_quantity')]);


        /***** 2- another way to calculate quantity use anyone u like ******/
//      $orderDetailId = DB::table('order_details')->where('order_id',$request->id)->get();
//      foreach ($orderDetailId as $row){
//          DB::table('products')->where('id',$row->product_id)
//              ->update(['quantity' => DB::raw('quantity-'.$row->quantity)]);
//      }


        Order::where('id',$id)->update(['delivery'=>3]);

        $notificat = array(
            'message' => 'Delivery Done',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notificat);
    }//END METHOD


    public function cancelOrder($id)
    {
        Order::where('id',$id)->update(['delivery'=>4]);

        $notificat = array(
            'message' => 'Order Cancelled',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notificat);
    }//END METHOD
}

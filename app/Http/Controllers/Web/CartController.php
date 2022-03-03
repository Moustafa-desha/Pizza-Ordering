<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{

    public function Cart()
    {

//        session()->flush();
//       dd(Session::get('cart'));

        if (Session::has('cart')){
            $subtotal = 0 ;
            foreach(Session::get('cart') as $id=>$product){
                $subtotal += $product['product_price'] * $product['quantity'];
            }
            Session()->put('subtotal',$subtotal);

        }


        if (Auth::user()){

            $cart = Cart::where('user_id',Auth::user()->id)->get();

            $subtotal = 0;
            foreach($cart as $product){
                $subtotal += $product->quantity * $product->product_price;

            }

            return view('cart.cart',compact('cart','subtotal'));
        }

        return view('cart.cart');
    }


    public function addToCart(Request $request,$id)
    {

        $product = Product::where('id', $id)->first();

        if (Auth::user()){

            if ($product->sale_price == null){
                $carModel = new Cart();
                $carModel['user_id'] = Auth::user()->id;
                $carModel['product_id'] = $product->id;
                $carModel['product_name'] = $product->product_name;
                $carModel['image'] = $product->image;
                $carModel['quantity'] = 1;
                $carModel['product_price'] = $product->product_price;
                $carModel->save();

                return response::json(['success' => 'Successfully Added to Cart']);

            }else{
                $carModel = new Cart();
                $carModel['user_id'] = Auth::user()->id;
                $carModel['product_id'] = $product->id;
                $carModel['product_name'] = $product->product_name;
                $carModel['image'] = $product->image;
                $carModel['quantity'] = 1;
                $carModel['product_price'] = $product->sale_price;
                $carModel->save();
                return response::json(['success' => 'Successfully Added to Cart']);

            }
        }else{

             $cart = $request->session()->get('cart');

                if ($product->sale_price == null) {
                    $cart[$id] = [
                        'product_id' => $product->id,
                        'product_name' => $product->product_name,
                        'image' => $product->image,
                        'quantity' => 1,
                        'product_price' => $product->product_price,

                    ];
                    $request->Session()->put('cart', $cart);
                    return response::json(['success' => 'Successfully Added to Cart']);

                } else {
                    $cart[$id] = [
                        'product_id' => $product->id,
                        'product_name' => $product->product_name,
                        'image' => $product->image,
                        'quantity' => 1,
                        'product_price' => $product->sale_price,
                    ];
                    Session()->put('cart', $cart);
                    return response::json(['success' => 'Successfully Added to Cart']);

                }

        }


    } //END METHOD


    public function deleteFromCart(Request $request , $id){


        if (Session::has('cart')){
            $cart = Session::pull('cart');
            unset($cart[$id]);
            Session::put('cart', $cart);

        }elseif (Auth::user()){

            Cart::where('product_id',$id)->delete();
           }

        $alert = array(
            'message' => 'item Removed !',
            'alert-type' => 'warning',
        );
        return redirect('cart')->with($alert);
    } // END METHOD


    public function editCartQuantity(Request $request , $id)
    {

        if (Session::has('cart')){

            $product_quantity = $request->quantity;

            if ($request->has('decrease_quantity')){
                $product_quantity = $product_quantity - 1;

            }elseif ($request->has('increase_quantity')){
                $product_quantity = $product_quantity + 1;

            }else{}

            if ($product_quantity <= 0 ){

                $alert = array(
                    'alert-type' => 'error',
                    'message' => 'can\'t be null '
                );
                return redirect()->back()->with($alert);
            }

            $cart = Session::pull('cart');

            if (array_key_exists($id,$cart)){
                $cart[$id]['quantity'] = $product_quantity ;

                Session::put('cart',$cart);
            }


        }elseif (Auth::user()){

           $cart = Cart::where('product_id',$id)->first();

            $product_quantity = $request->quantity;

            if ($request->has('decrease_quantity')){
                $product_quantity = $product_quantity - 1;
            }elseif ($request->has('increase_quantity')){
                $product_quantity = $product_quantity + 1;

            }else{}

                if ($product_quantity <= 0 ){

                    $alert = array(
                        'alert-type' => 'error',
                        'message' => 'can\'t be null '
                    );
                    return redirect()->back()->with($alert);
                }


                $cart->update([
                    'quantity' => $product_quantity,
                ]);

        }

        $alert = array(
            'alert-type' => 'success',
            'message' => 'quantity updated'
        );

        return redirect()->back()->with($alert);
    } // END METHOD


    public function checkOut(){

        if (Auth::user()){

            $cart = Cart::where('user_id',Auth::user()->id)->get();

            $subtotal = 0;
            foreach($cart as $product){
                $subtotal += $product->quantity * $product->product_price;

            }

            return view('web.checkout',compact('cart','subtotal'));
        }

        return view('web.checkout');
    } // END METHOD



    public function confirmCheckOut(Request $request){


        if ($request->payment == "cash"){

                $validator = Validator::make($request->all(),[
                    'name' => 'required|min:3|max:255',
                    'email' => 'required|email|max:255',
                    'phone' => 'required|max:255',
                    'city' => 'required|max:255',
                    'address' => 'required|max:255',
                ]);
                    if ($validator->fails()){
                        return redirect()->back()->withErrors($validator)->withInput($request->all());
                    }
            if (Session::has('cart')){
                $cart = Session::get('cart');

                $data = array();
                $data['cost'] = Session::get('subtotal');
                $data['user_name'] = $request->name;
                $data['user_email'] = $request->email;
                $data['status'] = 'Pay Cash';
                $data['city'] = $request->city;
                $data['address'] = $request->address;
                $data['phone'] = $request->phone;
                $data['date'] = date('Y-m-d h:i:s');

                     $order_id = DB::table('orders')->insertGetId($data);

                        foreach ($cart as $id => $product){
//                            $product = $cart[$id];

                            DB::table('order_items')->insert([
                                'product_id' => $product['product_id'],
                                'order_id' => $order_id ,
                                'product_name' => $product['product_name'],
                                'product_price' => $product['product_price'],
                                'product_image' => $product['image'],
                                'product_quantity' => $product['quantity'],
                                'order_date' => $data['date'],
                            ]);

                            $alert = array(
                                'alert-type' => "success",
                                'message' => "order done wait Delivery",
                            );
                        }

                        //save order_id to show for gust to can track his order

                            Session::push('order_id',$order_id);




                        Session::forget('cart');
                return  redirect()->route('delivery_details')->with($alert);


            }elseif (Auth::user()){

                $cart = Cart::where('user_id',Auth::user()->id)->get();

                    $subtotal = 0;
                    foreach ($cart as  $product){
                        $subtotal += $product->product_price * $product->quantity;
                    }

                $data = array();
                $data['user_id'] = Auth::id();
                $data['cost'] = $subtotal;
                $data['user_name'] = $request->name;
                $data['user_email'] = $request->email;
                $data['status'] = 'Pay Cash';
                $data['city'] = $request->city;
                $data['address'] = $request->address;
                $data['phone'] = $request->phone;
                $data['date'] = date('Y-m-d h:i:s');

                $order_id = DB::table('orders')->insertGetId($data);

                foreach ($cart as  $product){

                    DB::table('order_items')->insert([
                        'product_id' => $product->product_id,
                        'order_id' => $order_id ,
                        'product_name' => $product->product_name,
                        'product_price' => $product->product_price,
                        'product_image' => $product->image,
                        'product_quantity' => $product->quantity,
                        'order_date' => $data['date'],
                    ]);

                    $alert = array(
                        'alert-type' => "success",
                        'message' => "order done wait Delivery",
                    );
                }

                Cart::where('user_id',Auth::user()->id)->delete();
                return  redirect()->route('delivery_details')->with($alert);
            }

            /**  PayPal  **/
        }elseif ($request->payment == "paypal"){

            if (Session::has('cart')){
                $cart = Session::get('cart');

                $data = array();
                $data['cost'] = Session::get('subtotal');
                $data['user_name'] = $request->name;
                $data['user_email'] = $request->email;
                $data['status'] = "Paypal";
                $data['city'] = $request->city;
                $data['address'] = $request->address;
                $data['phone'] = $request->phone;
                $data['date'] = date('Y-m-d h:i:s');

                $order_id = DB::table('orders')->insertGetId($data);

                foreach ($cart as $id => $product){
//                            $product = $cart[$id];

                    DB::table('order_items')->insert([
                        'product_id' => $product['product_id'],
                        'order_id' => $order_id ,
                        'product_name' => $product['product_name'],
                        'product_price' => $product['product_price'],
                        'product_image' => $product['image'],
                        'product_quantity' => $product['quantity'],
                        'order_date' => $data['date'],
                    ]);

                    $alert = array(
                        'alert-type' => "success",
                        'message' => "order done wait Delivery",
                    );
                }

                //save order_id to show for gust to can track his order
                Session::put('order_id',$order_id);


                Session::forget('cart');
                return  view('web.paypal_pay')->with($alert);


            }elseif (Auth::user()){

                $cart = Cart::where('user_id',Auth::user()->id)->get();

                $subtotal = 0;
                foreach ($cart as  $product){
                    $subtotal += $product->product_price * $product->quantity;
                }

                $data = array();
                $data['user_id'] = Auth::id();
                $data['cost'] = $subtotal;
                $data['user_name'] = $request->name;
                $data['user_email'] = $request->email;
                $data['status'] = "Paypal";
                $data['city'] = $request->city;
                $data['address'] = $request->address;
                $data['phone'] = $request->phone;
                $data['date'] = date('Y-m-d h:i:s');

                $order_id = DB::table('orders')->insertGetId($data);

                foreach ($cart as  $product){

                    DB::table('order_items')->insert([
                        'product_id' => $product->product_id,
                        'order_id' => $order_id ,
                        'product_name' => $product->product_name,
                        'product_price' => $product->product_price,
                        'product_image' => $product->image,
                        'product_quantity' => $product->quantity,
                        'order_date' => $data['date'],
                    ]);

                    $alert = array(
                        'alert-type' => "success",
                        'message' => "order done wait Delivery",
                    );
                }

                //save order_id to show for gust to can track his order
                Session::put('order_id',$order_id);

                Cart::where('user_id',Auth::user()->id)->delete();
                return   view('web.paypal_pay')->with($alert);
            }
        }

    } // END METHOD






}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function Cart()
    {
//        session()->forget('cart');
//       dd( session()->get('cart'));
        if (Auth::user()){
        $cart = Cart::where('user_id',Auth::user()->id)->get();
            return view('cart.cart',compact('cart'));
        }

        return view('cart.cart');
    }


    public function addToCart(Request $request,$id)
    {

        $product = Product::where('id', $id)->first();

             $cart = $request->session()->get('cart');

                if ($product->sale_price == null) {
                    $cart[$id] = [
                        'product_id' => $product->id,
                        'product_name' => $product->product_name,
                        'image' => $product->image,
                        'quantity' => 1,
                        'product_price' => $product->product_price
                    ];
                    $request->Session()->put('cart', $cart);
                    return response::json(['success' => 'Successfully Added to Cart']);

                } else {
                    $cart[$id] = [
                        'product_id' => $product->id,
                        'product_name' => $product->product_name,
                        'image' => $product->image,
                        'quantity' => 1,
                        'product_price' => $product->sale_price
                    ];
                    Session()->put('cart', $cart);
                    return response::json(['success' => 'Successfully Added to Cart']);

                }
                return response::json(['error' => 'product already in Cart']);

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
    }





}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function Cart()
    {
//        session()->forget('cart');
        if(Session::has('cart')){
            $subtotal = 0;
        foreach(Session::get('cart') as $id=>$product){
            $subtotal = $subtotal += $product['product_price'];
        }
}
        $cart = Cart::all();
        return view('cart.cart',compact('cart','subtotal'));
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

    }



}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function formRegister(){
        return view('auth.register');
    } // End Method


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            'phone' => 'required',
            'password' => 'required', 'string', 'min:8', 'confirmed',
        ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

        $user = new User();
        $user['name'] = $request->name;
        $user['email'] = $request->email;
        $user['phone'] = $request->phone;
        $user['password'] = Hash::make($request->password);
        $user->save();

        Auth::logout();

        $alert = array(
            'message' => 'login to your new account',
            'alert-type' => 'success',
        );
        return redirect()->route('login')->with($alert);

    } // End Method


    public function userLogin(){

        return view('auth.login');

    } // End Method

    public function userStore(Request $request)
    {

        if (Auth::guard()->attempt(['email'=>$request->email , 'password'=>$request->password])){


            if (Session::has('cart')){
                   foreach (Session::get('cart') as $id => $cart){

                    $carModel = new Cart();
                    $carModel['user_id'] = Auth::user()->id;
                    $carModel['product_id'] = $cart['product_id'];
                    $carModel['product_name'] = $cart['product_name'];
                    $carModel['image'] = $cart['image'];
                    $carModel['quantity'] = $cart['quantity'];
                    $carModel['product_price'] = $cart['product_price'];
                    $carModel->save();
                    Session::forget('cart');
                   }
            }


            $alert = array(
                'message' => 'welcome Back ^-^',
                'alert-type' => 'success',
            );
            return redirect()->route('home')->with($alert);
        }
        return redirect()->back();
    } // End Method

    public function userLogout(){

        Auth::logout();

        $alert = array(
            'message' => 'login again',
            'alert-type' => 'success',
        );
        return redirect()->route('login')->with($alert);
    }
}

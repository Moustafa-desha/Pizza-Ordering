<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function loginForm() {

        return view('admin.auth.login');

    } // End Method

    public function loginStore(Request $request){

        $request->validate([
            'email' => 'required|string|exists:admins,email',
            'password' => 'required|string|min:5|max:30',
        ]);

        $admin = $request->only('email','password');

        if (Auth::guard('admin')->attempt($admin)){
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back();
    } // End Method


    public function adminLogout(){

        Auth::guard()->logout();

        $alert = array(
            'message' => 'login again',
            'type' => 'warning',
        );
        return redirect()->route('admin.login')->with($alert);
    }

    public function dashboard(){

        return view('admin.dashboard');
    }

}

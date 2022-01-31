<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//       $products = DB::table('products')->get();
       $products = Product::all();
        return view('index',compact('products'));
    } //End Method



    public function veiwProduct(Request $request ,$id)
    {

        $productDetalis = Product::where('id',$id)->get();
        return view('products.single_product',compact('productDetalis'));
    } //End Method

}

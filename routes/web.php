<?php


use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => 'user', 'middleware' => 'guest:web'], function () {

    Route::get('register', [UserController::class, 'formRegister'])->name('register');
    Route::POST('store/register', [UserController::class, 'create'])->name('userRegister');

    Route::get('login',[UserController::class,'userLogin'])->name('login');
    Route::POST('store/login',[UserController::class,'userStore'])->name('storeLogin');
});
Route::group(['prefix'=>'user'], function () {
Route::get('logout',[UserController::class,'userLogout'])->name('logout');

});


Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('view/product/{id}', [HomeController::class, 'veiwProduct']);

        /******* Cart ********/
Route::get('cart', [CartController::class, 'Cart']);
Route::get('add/cart/{id}', [CartController::class, 'addToCart']);




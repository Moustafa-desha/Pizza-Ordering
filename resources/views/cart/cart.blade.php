@extends('layouts.main')

@section('content')


    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="container">


            <section class="cart container mt-2 my-3 py-5">
                <div class="container mt-2">
                    <h4>Your Cart</h4>
                </div>

                <table class="pt-5">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>

                    @if(Session::has('cart'))
                        @foreach(Session::get('cart') as $id=>$product)
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <img style="width: 75px; height: 75px" src="{{asset('images/'.$product['image'])}}">
                                        <div>
                                            <h5>{{ $product['product_name'] }}</h5>
                                            <small><span>$</span>{{$product['product_price']}}</small>
                                                <br>
                                                <form>
                                                    <button type="submit" name="remove_btn" class="btn-sm btn-danger" value="remove">
                                                   Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <form>
                                            <input type="submit" value="-" class="edit-btn" name="decrease_product_quantity_btn">
                                            <input type="text" name="quantity" value="{{$product['quantity']}}" readonly>

                                            <input type="submit" value="+" class="edit-btn" name="increase_product_quantity_btn">
                                        </form>
                                    </td>
                                    <td>
                                        <span class="product-price">${{ $product['quantity'] * $product['product_price']}}</span>
                                    </td>
                                </tr>
                            @endforeach
                        @elseif(Auth::user())

                            @foreach($cart as $product)
                                <tr>
                                    <td>
                                        <div class="product-info">
                                            <img style="width: 75px; height: 75px" src="{{asset('images/'.$product->image)}}">
                                            <div>
                                                <h5>{{ $product->product_name }}</h5>
                                                <small><span>$</span>{{$product->product_price}}</small>
                                                <br>
                                                <form>
                                                    <button type="submit" name="remove_btn" class="btn-sm btn-danger" value="remove">
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <form>
                                            <input type="submit" value="-" class="edit-btn" name="decrease_product_quantity_btn">
                                            <input type="text" name="quantity" value="{{$product->quantity}}" readonly>

                                            <input type="submit" value="+" class="edit-btn" name="increase_product_quantity_btn">
                                        </form>
                                    </td>
                                    <td>
                                        <span class="product-price">${{ $product->quantity * $product->product_price}}</span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>

                    <div class="cart-total">
                        <table>
                            @if(Session::has('cart'))
                                <tr>
                                    <td>Total</td>
                                    <td>$ {{$subtotal}}</td>
                                </tr>

                            @elseif(Auth::user())
                                <tr>
                                    <td>Total</td>
                                    <td>${{$cart->sum('product_price')}}</td>
                                </tr>
                            @endif
                        </table>
                    </div>



                    <div class="checkout-container">

                        <form>
                            <input type="submit" class="btn checkout-btn" value="Checkout" name="">
                        </form>

                    </div>


                </section>


            </div>
        </div>
        <!-- Cart End -->




    @endsection

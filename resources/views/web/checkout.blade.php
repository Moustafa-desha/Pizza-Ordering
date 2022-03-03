@extends('layouts.main')

@section('content')


    <!-- Checkout Start -->
    <div class="container-fluid pt-2">
        <div class="container">


            <!-- Checkout -->
            <section class="my-2 py-2 checkout">
                <div class="container text-center mt-1 pt-5">
                    <h2>Check Out</h2>
                    <hr class="mx-auto">
                </div>

                <div class="mx-auto container">
                    <form id="checkout-form" action="{{ route('confirm_checkOut') }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="form-group checkout-small-element">
                            <label for="">Name</label>
                            <input type="text" class="form-control" id="checkout-name" name="name" placeholder="name" required>
                        </div>

                        <div class="form-group checkout-small-element">
                            <label for="">Email</label>
                            <input type="email" class="form-control" id="checkout-email" name="email" placeholder="email address" required>
                        </div>

                        <div class="form-group checkout-small-element">
                            <label for="">Phone</label>
                            <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="phone number" required>
                        </div>

                        <div class="form-group checkout-small-element">
                            <label for="">City</label>
                            <input type="text" class="form-control" id="checkout-city" name="city" placeholder="city" required>
                        </div>

                        <div class="form-group checkout-large-element">
                            <label for="">Address</label>
                            <input type="text" class="form-control" id="checkout-address" name="address" placeholder="address" required>
                        </div>
                                <style>
                                    li {
                                        list-style-type: none;
                                    }
                                </style>
                        <div class="form-group checkout-small-element"><h5> Choose Payment Method</h5>
                            <ul>
                                <div class="row px-2">
                                    <li class="mr-5"><input id="paypal" type="radio" name="payment" value="paypal"><label for="paypal"><img src="{{ asset('images/paypal.png') }}" title='PayPal' style="width: 80px; height:50px"> </label> </li>
                                    <li class="mr-5"><input id="delivery" type="radio" name="payment" value="cash"><label for="delivery"><img src="{{ asset('images/delivery.png') }}" title='Cash'  alt="Cash" style="width: 60px; height:50px"> </label> </li>
                                </div>
                            </ul>
                        </div>

                        <div class="form-group checkout-btn-container">
                            @if(Session::has('cart'))

                            <p>Total amount : $ {{Session::get('subtotal')}}</p>
                            <input type="submit" class="btn" id="checkout-btn" name="checkout_btn" value="Checkout">

                            @elseif(Auth::user())

                                <p>Total amount : $ {{$subtotal}}</p>
                                <input type="submit" class="btn" id="checkout-btn" name="checkout_btn" value="Checkout">
                            @endif
                        </div>

                    </form>
                </div>
            </section>



        </div>
    </div>
    <!-- Cart End -->






@endsection

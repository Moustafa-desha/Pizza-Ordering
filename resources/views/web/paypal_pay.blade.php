@extends('layouts.main')

@section('content')

    <section class="container mt-2 my-3 py-5" style="margin: 50px auto">
        <div class="container mt-2 text-center">

            <!-- Set up a container element for the button -->
            <div id="paypal-button-container"></div>


        </div>
    </section>

    <body>
    <!-- Include the PayPal JavaScript SDK; replace "test" with your own sandbox Business account app client ID -->
    <script src="https://www.paypal.com/sdk/js?client-id=AVI_GBOauOlLoghPnbfBB-AxqbMWaoZgl6lWG5jzRz6AMw7wZqox7nDXgjw9XXCWeCGsSgfjeyejBsRx&currency=USD"></script>



    <script>
        paypal.Buttons({

            // Sets up the transaction when a payment button is clicked
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: @if(Session::has('subtotal'))
                                         {{Session::get('subtotal')}}
                                    @elseif(Auth::user())
                                         {{$subtotal}}
                                @endif
                            // Can reference variables or functions. Example: `value: document.getElementById('...').value`
                        }
                    }]
                });
            },

            // Finalize the transaction after payer approval
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    // Successful capture! For dev/demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                    //هنا نحوله بعد ما يتم الدفع لاضافه الاوردر ف الداتا بيز
                    window.location.href = "/paypal/payment/"+transaction.id;


                    // When ready to go live, remove the alert and show a success message within this page. For example:
                    // var element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '';
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                });
            }
        }).render('#paypal-button-container');

    </script>
    </body>

@endsection

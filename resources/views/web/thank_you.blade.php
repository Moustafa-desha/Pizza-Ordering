@extends('layouts.main')

@section('content')


    <div class="container mt-2 my-3 py-5" style="margin: 50px auto">
    <div class="container mt-2 text-center">
    <h3 style="color: yellow">please keep this Order Number for more information and track your order</h3>

        @if(Auth::user())
            @foreach($orders as $order )
                <h4 style="color: orangered"> Your Order Number : <span>( {{ $order->id }} )</span>
                <a class="btn btn-primary" href="{{URL('delivery/status/'.$order->id)}}">Track</a>
                </h4>
            @endforeach

{{--        @elseif(Session::has('order_id'))--}}
{{--            @foreach(Session::get('order_id') as  $id => $order_id)--}}
            @else
                <h4 style="color: orangered"> Your Order Number : <span>( {{ $order_id }} )</span>
                    <a class="btn btn-primary" href="{{URL('delivery/status/'.$order_id)}}">Track -></a>
                </h4>
{{--            @endforeach--}}
        @endif

    </div>
    </div>


@endsection

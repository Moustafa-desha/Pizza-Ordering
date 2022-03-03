@extends('layouts.main')

@section('content')

    <div class="container mt-2 my-3 py-5" style="margin: 50px auto">
        <div class="container mt-2 text-center">

    @if($delivery->delivery == 0)
        <div class="col-lg-8" style="margin: 75px">
            <div class="progress">
                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 25%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <div style="margin: 75px">
            <h4><strong>Status :</strong> your order under review </h4>
        </div>

    @elseif($delivery->delivery == 1)

        <div class="col-lg-8" style="margin: 75px">
            <div class="progress">
                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <div style="margin: 75px">
            <h4><strong>Status :</strong> Order ready to send for delivery </h4>
        </div>

    @elseif($delivery->delivery == 2)

        <div class="col-lg-8" style="margin: 75px">
            <div class="progress">
                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 75%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <div style="margin: 75px">
            <h4 style="color: yellow "><strong>Status :</strong> In Road For Delivery </h4>
        </div>

    @elseif($delivery->delivery == 3)

        <div class="col-lg-8" style="margin: 75px">
            <div class="progress">
                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 100%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <div style="margin: 100px">
            <h4 style="color: green"><strong>Status :</strong> Delivery Success</h4>
        </div>

    @elseif($delivery->delivery == 4)

        <div class="col-lg-8" style="margin: 75px">
            <div class="progress">
                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <div style="margin: 100px">
            <h4 style="color: red"><strong>Status :</strong> Order Cancelled</h4>
        </div>

    @endif

        </div>
    </div>

@endsection

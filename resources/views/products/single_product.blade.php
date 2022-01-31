@extends('layouts.main')

@section('content')
<style>
    * {
        box-sizing: border-box;

    }

    /* Position the image container (needed to position the left and right arrows) */
    .container {
        position: relative;
    }


    /* Hide the images by default */
    .mySlides {
        display: none;
    }

    /* Add a pointer when hovering over the thumbnail images */
    .cursor {
        cursor: pointer;
    }

    /* Next & previous buttons */
    .prev,
    .next {
        cursor: pointer;
        position: absolute;
        top: 40%;
        width: auto;
        padding: 16px;
        margin-top: -50px;
        color: white;
        font-weight: bold;
        font-size: 20px;
        border-radius: 0 3px 3px 0;
        user-select: none;
        -webkit-user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
        right: 0;
        border-radius:  0 5px 5px 0 ;
    }
    .prev {
        left: 0;
        border-radius: 5px 0 0 5px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover,
    .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    /* Number text (1/3 etc) */
    .numbertext {
        color: #f2f2f2;
        font-size: 12px;
        padding: 8px 12px;
        position: absolute;
        top: 0;
    }

    /* Container for image text */
    .caption-container {
        text-align: center;
        background-color: #222;
        padding: 2px 16px;
        color: white;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    /* Six columns side by side */
    .column {
        float: left;
        width: 16.66%;
        display: inline-block;
    }

    /* Add a transparency effect for thumnbail images */
    .demo {
        opacity: 0.6;
    }

    .active,
    .demo:hover {
        opacity: 1;
    }
    @media screen and (max-width: 500px) {

        .column {
            width: 60%;
        }
    }

</style>

<section class="ftco-menu">
<div class="container-fluid">
<div class="row d-md-flex">

    <div class="col-lg-12 ftco-animate p-md-6">

        <div class="col-lg-12 d-flex align-items-center">

            <div class="tab-content ftco-animate mx-auto" id="v-pills-tabContent">

                <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-1-tab">
                    <div class="row">
                    @foreach($productDetalis as $data)

                        <div class="col-md-12 text-center" style="margin-top: 10px">
                            <div class="menu-wrap">

                            {{--              this slideShow i add alone to this pag and fixed media                   --}}

                            <!-- Container for the image gallery -->
                                <div class="container">

                                    <!-- Full-width images with number text -->
                                    <div class="mySlides">
                                        <div class="numbertext">1 / 3</div>
                                        <img src="{{asset('images/'.$data->image)}}" style="width:520px; height: 400px">
                                    </div>

                                    <div class="mySlides">
                                        <div class="numbertext">2 / 3</div>
                                        <img src="{{asset('images/'.$data->image1)}}" style="width:520px; height: 400px">
                                    </div>

                                    <div class="mySlides">
                                        <div class="numbertext">3 / 3</div>
                                        <img src="{{asset('images/'.$data->image2)}}" style="width:520px; height: 400px">
                                    </div>


                                    <!-- Next and previous buttons -->
                                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                    <a class="next" onclick="plusSlides(1)">&#10095;</a>

                                    <!-- Image text -->
                                    <div class="caption-container">

                                    </div>

                                    <!-- Thumbnail images -->
                                    <div class="row" style="justify-content: center;">
                                        <div class="column" style=" margin: 25px;">
                                            <img class="demo cursor" src="{{asset('images/'.$data->image)}}" style="width:150px; height: 120px" onclick="currentSlide(1)" >
                                        </div>
                                        <div class="column" style=" margin: 25px;">
                                            <img class="demo cursor" src="{{asset('images/'.$data->image1)}}" style="width:150px; height: 120px" onclick="currentSlide(2)" >
                                        </div>
                                        <div class="column" style=" margin: 25px;">
                                            <img class="demo cursor" src="{{asset('images/'.$data->image2)}}" style="width:150px; height: 120px" onclick="currentSlide(3)" >
                                        </div>

                                    </div>
                                </div>


                            {{--                                --}}

{{--                                <a href="#" class="menu-img img mb-5" style="background-image: url( {{asset('images/'.$data->image)}} );"></a>--}}
                                <div class="text" style="margin: 5px">
                                    <h3><a href="#">{{$data->product_name}}</a></h3>
                                    <p style="width: 750px">{{$data->product_desc}}</p>
                                    <p class="price"><span>${{$data->sale_price}}</span></p>
                                    <p><a href="#" class="btn btn-white btn-outline-white">Add to cart <i class="fas fa-cart-plus"></i></a></p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

</section>

<script>

    var slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
        captionText.innerHTML = dots[slideIndex-1].alt;
    }


    </script>
@endsection

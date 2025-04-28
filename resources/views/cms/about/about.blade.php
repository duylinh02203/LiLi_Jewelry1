@extends('cms.layouts.app')
@section('content')
<section class="overflow-hidden">
    <div class="container">
        <div class="row g-5">
            <div class="col-xl-5 offset-xl-1">
                <div class="row g-3">
                    <div class="col-md-6">
                        <img src="assets/images/inner-page/review-image/6.jpg" class="img-fluid rounded-3 about-image" alt="">
                    </div>
                    <div class="col-md-6">
                        <img src="assets/images/inner-page/review-image/7.jpg" class="img-fluid rounded-3 about-image" alt="">
                    </div>
                    <div class="col-12 ratio_40">
                        <div class="bg-size" style="background-image: url(&quot;assets/images/inner-page/review-image/8.jpg&quot;); background-size: cover; background-position: center center; background-repeat: no-repeat; display: block;">
                            <img src="assets/images/inner-page/review-image/8.jpg" class="img-fluid rounded-3 team-image bg-img" alt="" style="display: none;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="about-details">
                    <div>
                        <h2>WHO WE ARE</h2>
                        <h3>largest Online fashion destination</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam, culpa! Asperiores labore
                            amet nemo ullam odit atque adipisci, hic, aliquid animi fugiat praesentium quidem.
                            Perspiciatis, expedita!</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam, culpa!
                            Asperiores labore
                            amet nemo ullam odit atque adipisci, hic, aliquid animi fugiat praesentium quidem.
                            Perspiciatis, expedita!</p>
                        <button onclick="location.href = 'shop.php';" type="button" class="btn btn-solid-default">Shop Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
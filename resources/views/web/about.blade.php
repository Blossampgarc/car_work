@extends('web.layouts.main')
@section('content')
<!-- Header End -->
<section class="banner-sec">
    <div class="banner-img">
        <img src="{{asset('web/images/inrbanner.png')}}" />
        <div class="banner-info">
            <h5>ABOUT Us</h5>
        </div>
    </div>
</section>
<section class="aboutus-sec">
    <div class="container">
        <div class="about-us">
            <h5>WAHT WE DO</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit Nulla rutrum nunc eu maximus suscipit Praesent erat augue et.</p>
        </div>
        <div class="row row-1">
            <div class="col-md-6">
                <div class="about-img img-1">
                    <img src="{{asset('web/images/about1.png')}}" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="about-info">
                    <p class="info-1">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum nunc eu maximus suscipit. Praesent erat augue, molestie ac nisi et, mollis pulvinar massa. Integer convallis gravida est, sed commodo magna. Duis
                        rutrum tellus sed nisi maximus, sit amet elementum nulla tempor.
                    </p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum nunc eu maximus suscipit. Praesent erat augue, molestie ac nisi et, mollis pulvinar massa.</p>
                </div>
            </div>
        </div>
        <div class="row row-2">
            <div class="col-md-6">
                <div class="about-img">
                    <img src="{{asset('web/images/about2.png')}}" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="about-img img-3">
                    <img src="{{asset('web/images/about3.png')}}" />
                </div>
            </div>
        </div>
        <div class="row row-2">
            <div class="col-md-6">
                <div class="about-info last-info">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum nunc eu maximus suscipit. Praesent erat augue, molestie ac nisi et, mollis pulvinar massa. Integer convallis gravida est, sed commodo magna. Duis
                        rutrum tellus sed nisi maximus, sit amet elementum nulla tempor.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="about-img img-4">
                    <img src="{{asset('web/images/about4.png')}}" />
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
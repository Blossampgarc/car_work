@extends('web.layouts.main') @section('content')
<!-- Header End -->
<?php
$contact = App\Models\config::where('is_active',1)->where('type','contactnumber')->first();
$email = App\Models\config::where('is_active',1)->where('type','emailaddress')->first();
$address = App\Models\config::where('is_active',1)->where('type','address')->first();
?>
<section class="banner-sec">
    <div class="banner-img">
        <img src="{{asset('web/images/inrbanner.png')}}" />
        <div class="banner-info">
            <h5>Contact Us</h5>
        </div>
    </div>
</section>
<section class="contactus-sec">
    <div class="container">
        <div class="intouch">
            <h5>Get in Touch</h5>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="contact-form">
                    <form method="post" action="{{route('contact_submit')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="user-inputt">
                                    <input type="text" name="first_name"  placeholder="Your First name" required/>
                                    <div class="user-img">
                                        <img src="{{asset('web/images/user.png')}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="user-inputt">
                                    <input type="text" name="last_name" placeholder="Your Last name" required/>
                                    <div class="user-img">
                                        <img src="{{asset('web/images/user.png')}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="user-inputt">
                                    <input type="text" name="email" placeholder="Your Email address" required/>
                                    <div class="user-img">
                                        <img src="{{asset('web/images/phone.png')}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="user-inputt">
                                    <textarea name="comment" placeholder="Comment" required></textarea>
                                    <div class="user-img">
                                        <img src="{{asset('web/images/user.png')}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="user-btnn">
                                    <button>Send Message</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="time-mainblk">
                    <div class="time-main">
                        <a href="#">
                            <div class="time-img">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </div>
                            <div class="time-info">
                                <h6>Address:</h6>
                                <p>{{$address->value}}</p>
                            </div>
                        </a>
                    </div>
                    <div class="time-main">
                        <a href="tel:7609602176">
                            <div class="time-img phonee">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="time-info">
                                <h6>Phone</h6>
                                <p>{{$contact->value}}</p>
                            </div>
                        </a>
                    </div>
                    <div class="time-main">
                        <a href="mailto:funracing@sbcglobal.net">
                            <div class="time-img maill">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </div>
                            <div class="time-info">
                                <h6>Email At</h6>
                                <p>{{$email->value}}</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

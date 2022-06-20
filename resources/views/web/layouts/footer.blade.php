<?php
use App\Models\accessories;
$accessories = accessories::where('is_active',1)->where('is_deleted',0)->get();
 ?>


<div class="container">
    <div class="need-help">
        <p>Need help? Call our award-winning support team 24/7 at +1.800.000.8809</p>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="subscribe">
                <h5>SUBSCRIBE TO OUR NEWSLETTER</h5>
                <p>Get the latest updates on new products and upcoming sales</p>
                <div class="subscribe-form">
                    <form>
                        <div class="user-input">
                            <input type="text" placeholder="Enter your E-mail" />
                        </div>
                        <div class="user-btn">
                            <a href="#"> <button>Subscribe</button> </a>
                        </div>
                    </form>
                </div>
                <div class="social-icons">
                    <a href="#"> <i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="shop">
                <h5>Shop</h5>
                <ul>
                    @foreach($accessories as $val)
                    <li>
                        <a href="{{route('category_list',Crypt::encrypt($val->id))}}">{{$val->name}}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-2">
            <div class="information">
                <h5>Information</h5>
                <ul>
                    <li><a href="{{route('about')}}">About Us</a></li>
                    <li><a href="{{route('contact')}}">Contact Us</a></li>
                    <li><a href="{{route('brand')}}">Brands</a></li>
                    <li><a href="#">Flash Deals</a></li>
                    <li><a href="#">Demo</a></li>
                    <li><a href="#">Theme FAQ</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="contact">
                <h5>Contact</h5>
                <div class="contact-mainn">
                    <div class="contact-img">
                        <img src="{{asset('web/images/contact1.png')}}" />
                    </div>
                    <div class="contact-info">
                        <p>7300-7398 ABC Rd,XYZZ, NY 11209</p>
                    </div>
                </div>
                <div class="contact-mainn">
                    <a href="tel:76096021767609602176">
                        <div class="contact-img">
                            <img src="{{asset('web/images/contact2.png')}}" />
                        </div>
                        <div class="contact-info">
                            <p>+ 760 960 2176 + 760 960 2176</p>
                        </div>
                    </a>
                </div>
                <div class="contact-mainn">
                    <a href="mailto:funracing@sbcglobal.net">
                        <div class="contact-img">
                            <img src="{{asset('web/images/contact3.png')}}" />
                        </div>
                        <div class="contact-info">
                            <p>funracing@sbcglobal.net</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row payment-row">
        <div class="col-md-6">
            <div class="payment-infoo">
                {{--<p>
                    dolor sit amet, consectetuer adipiscing elit Aenean commodo ligula eget dolor. Aenean massa.L.orem ipsum dolor sit ame lorem ipsum dolor sit amet, consectetuer adipiscing elit Aenean commodo ligula eget dolor.Aenean
                    massa lorem ipsum dolor sit amet.
                </p>--}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="payment-img">
                <a href="#"><img src="{{asset('web/images/payment.png')}}" /></a>
            </div>
        </div>
    </div>
</div>
<div class="copyright-blk">
    <div class="container">
        <p>© 2021 smartautoparts. All Rights Reserved. Powered by BigCommerce.</p>
        <p>BigCommerce Themes & Templates by ThemeVale.com</p>
    </div>
</div>

<!-- Begin: Top Row -->
<?php
use App\Models\accessories;
use App\Models\config;
$accessories = accessories::get_accessories();
$email = config::get_email();
$contact = config::get_contact();
$count = 0;
if (Session::has('cart')) {
    $cart = Session::get('cart');
    if ($cart != []) {
        foreach ($cart as $key => $value) {
            $count++;
        }
    }
}
        
?>
<div class="top-row">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="contact-main">
                    <div class="phone">
                        <a href="tel:{{$contact->value}}"><i class="fa fa-phone" aria-hidden="true"></i>{{$contact->value}}</a>
                    </div>
                    <div class="mail">
                        <a href="mailto:{{$email->value}}"><i class="fa fa-envelope" aria-hidden="true"></i>{{$email->value}}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shipping">
                    <p>Same Day Shipping</p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="gifts-certificate">
                    <a href="#">Need Help?</a>
                    <a href="#">Blog</a>
                    <a href="#">Gift Certificates</a>
                    <a href="#">Compare(0)</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Top Row -->
<!-- Begin: Bottom Row -->
<div class="bottom-row">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="logo">
                    <?php $logo = App\Models\logo::orderBy('id','desc')->first(); ?>
                    <a href="{{route('welcome')}}"><img src="{{asset($logo->image)}}" /></a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="more-options">
                    <ul>
                        <li><a href="{{route('about')}}">About</a></li>
                        <li><a href="{{route('brand')}}">Brands</a></li>
                        <li><a href="{{route('search')}}">Search</a></li>
                        <li><a href="{{route('contact')}}">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="user-options">
                    @guest
                    <a href="{{route('account')}}">
                        <div class="option-main">
                            <div class="option-img">
                                <img src="{{asset('web/images/option3.png')}}" />
                            </div>
                            <div class="option-info">
                                <p>Login</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{route('account')}}">
                        <div class="option-main">
                            <div class="option-img">
                                <img src="{{asset('web/images/option2.png')}}" />
                            </div>
                            <div class="option-info">
                                <p>Register</p>
                            </div>
                        </div>
                    </a>
                    @endguest @auth
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="">
                            @csrf
                        </form>
                        <div class="option-main">
                            <div class="option-img">
                                <i class="fa fa-sign-out"></i>
                            </div>
                            <div class="option-info">
                                <p>Logout</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{route('user_profile')}}">
                        <div class="option-main">
                            <div class="option-img">
                                <i class="fa fa-tachometer"></i>
                            </div>
                            <div class="option-info">
                                <p>Dashboard</p>
                            </div>
                        </div>
                    </a>
                    @endauth
                    <a href="#">
                        <div class="option-main">
                            <div class="option-img">
                                <img src="{{asset('web/images/option3.png')}}" />
                            </div>
                            <div class="option-info">
                                <p>WishList</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{route('cart')}}">
                        <div class="option-main">
                            <div class="option-img">
                                <img src="{{asset('web/images/option1.png')}}" />
                            </div>
                            <div class="option-info">
                                <p>Cart</p>
                            </div>
                            <div class="tag">
                                <span>{{$count}}</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Bottom Row -->
<div class="last-row">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-md navbar-light">
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav">
                            @foreach($accessories as $val)
                            <a href="{{route('category_list',Crypt::encrypt($val->id))}}" class="nav-item nav-link active">{{$val->name}}</a>
                            @endforeach
                            <a href="{{route('product')}}" class="nav-item nav-link help">Help!</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>

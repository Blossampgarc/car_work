@extends('shop.layouts.main')
@section('content')
<!-- Header End -->
<section class="shop">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="shop-all shop-prod">
                    <span>
                        <img src="{{asset('web/img/shopall1.jpg')}}" />
                    </span>
                    <div class="shop-all-cont">
                        <h4>SHOP ALL</h4>
                        <a class="res-btn" href="{{route('shopall','shopall')}}">Click Here</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="shirts shop-prod">
                            <span>
                                <img src="{{asset('web/img/Apparel.png')}}" />
                            </span>
                            <div class="shop-content">
                                <h4>SHIRTS</h4>
                                <a class="res-btn" href="{{route('shopall','shirt')}}">Click Here</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="shirts shop-prod">
                            <span>
                                <img src="{{asset('web/img/Screen-Shot-2020-09-10-at-1.13.59-PM.png')}}" />
                            </span>
                            <div class="shop-content">
                                <h4>HATS</h4>
                                <a class="res-btn" href="{{route('shopall','hat')}}">Click Here</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="shirts shop-prod">
                            <span>
                                <img src="{{asset('web/img/outer.jpg')}}" />
                            </span>
                            <div class="shop-content">
                                <h4>OUTERWEAR</h4>
                                <a class="res-btn" href="{{route('shopall','outerwear')}}">Click Here</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="shirts shop-prod">
                            <span>
                                <img src="{{asset('web/img/Screen-Shot-2020-09-10-at-1.33.19-PM.png')}}" />
                            </span>
                            <div class="shop-content">
                                <h4>BOTTOMS</h4>
                                <a class="res-btn" href="#">Click Here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="analysis shop-prod">
                    <span>
                        <img src="{{asset('web/img/shopall2.jpg')}}" />
                    </span>
                    <div class="shop-all-cont">
                        <h4>ONLINE ANALYSIS</h4>
                        <a class="res-btn" href="{{route('shopall','onlinelesson')}}">Click Here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="shop-seller">
    <div class="container">
        <div class="shop-best-heading">
            <h2>BEST SELLERS</h2>
        </div>
        {{--
        <div class="shop-anker">
            <a class="res-btn" href="#">$0.00<i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
        </div>
        <div class="shop-sort">
            <select id="cars">
                <option value="volvo">Volvo</option>
                <option value="saab">Saab</option>
                <option value="vw">VW</option>
                <option value="audi" selected>Audi</option>
            </select>
        </div>
        --}}
        <div class="row">
            @foreach ($product as $prdct)
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset($prdct->picture)}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>{{$prdct->name}}</h3>
                        <p>{{$prdct->tagprice}}</p>
                        <a class="res-btn" href="{{route('product_details',$prdct->id)}}">Select option</a>
                    </div>
                </div>
            </div>
            @endforeach
        <!-- 
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/1.jpg')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/2.jpg')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/3.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/4.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/5.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/6.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/7.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/8.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/9.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/10.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/11.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/12.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/13.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/14.jpg')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/15.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/16.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/17.jpg')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/18.jpg')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/19.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/20.jpg')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/21.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/22.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/23.jpg')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="shop-pro-all">
                    <div class="shop-product">
                        <img src="{{asset('web/img/24.png')}}" />
                    </div>
                    <div class="shop-product-cont">
                        <h3>BB Mens Fleece Sweatshirt</h3>
                        <p>$32.99</p>
                        <a class="res-btn" href="#">Select option</a>
                    </div>
                </div>
            </div>
         -->
             
         </div>
    </div>
</section>
@endsection

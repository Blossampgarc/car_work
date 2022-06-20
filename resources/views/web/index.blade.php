@extends('web.layouts.main')
@section('content')

<!-- Slider Start -->
<div id="demo" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <!-- <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul> -->
    <!-- The slideshow -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{asset('web/images/hero-img.jpg')}}" alt="" />
            <div class="car-clas">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bnr-heading">
                                <h1>SMART AUTO PARTS</h1>
                                <p>Pellentesque meget milancelos de tinciduntion loremous an comopolis</p>
                                <a href="{{route('product')}}" class="shop-btn">SHOP NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('web.layouts.inner-search')
        </div>
    </div>
    <!-- Left and right controls -->
    <!--   <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a> -->
</div>
<!-- Slider End -->
@include('web.layouts.accessory-list')
<section class="custom-product">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="prod-blk">
                    <img src="{{asset('web/images/custom-img01.png')}}" />
                    <div class="custom-txt">
                        <h2>HEAD LIGHTS</h2>
                        <a href="{{route('product')}}" class="shop-btn">SHOP NOW</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="prod-blk">
                    <img src="{{asset('web/images/custom-img02.png')}}" />
                    <div class="custom-txt">
                        <h2>WHEELS AND TIRES</h2>
                        <a href="{{route('product')}}" class="shop-btn">SHOP NOW</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="prod-blk">
                    <img src="{{asset('web/images/custom-img03.png')}}" />
                    <div class="custom-txt">
                        <h2>BODY KITS</h2>
                        <a href="{{route('product')}}" class="shop-btn">SHOP NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="sale-products">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('web.layouts.sidebar-search')
                <div class="flash-sale">
                    <h2>NEW</h2>
                    <h3>RELEASES</h3>
                    <p>Lorem ipsum dolor sit amet consectetur.</p>
                    <img src="{{asset('web/images/vehicle-logo-img.png')}}" alt="" />
                    <a href="{{route('product')}}">shop the body kik</a>
                </div>
            </div>
            @include('web.layouts.flash-sale')
        </div>
    </div>
</section>
<section class="category-tabs">
    <div class="container">
        <div class="cate-heading">
            <h1>Top Categories</h1>
        </div>
        <div class="row">
            <div class="tab">
                @foreach($accessories as $key => $accessory)
                <button class="tablinks {{  $key === 0 ? 'active' : '' }}" onclick="openCity(event, '{{$accessory->slug}}')">{{$accessory->name}}</button>
                @endforeach
            </div>
            @foreach($accessories as $i => $access)
            <div class="col-md-12">
            <div id="{{$access->slug}}" class="tabcontent {{  $i === 0 ? 'tab-blk' : '' }}">
                <div class="row">
                    <?php $category = App\Models\category::where('is_active',1)->where('is_deleted',0)->where('accessories_id',$access->id)->where('is_top',1)->get();
                    ?>
                    @if(!$category->isEmpty())
                    @foreach($category as $cat)
                    <div class="col-md-3">
                        <div class="tab-img">
                            <img src="{{asset($cat->image)}}" alt="" />
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star-half-o" aria-hidden="true"></i></li>
                            </ul>
                            <a href="{{route('subcategory_list',Crypt::encrypt($cat->id))}}">{{$cat->name}}</a>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <img src="{{asset('web/images/coming-soon.jpg')}}" class="coming-soon" alt="" />
                    @endif
                </div>
                
            </div>
            </div>
            @endforeach
        </div>
        <div class="cate-btn">
            <a href="#" class="shop-btn">LOAD MORE</a>
        </div>
    </div>
</section>
@include('web.layouts.ads')
<section class="categ-tabs-prod">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="prod-tab" data-toggle="tab" href="#prod" role="tab" aria-controls="prod">NEW PRODUCTS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="seller-tab" data-toggle="tab" href="#seller" role="tab" aria-controls="seller">BEST SELLERS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="feature-tab" data-toggle="tab" href="#feature" role="tab" aria-controls="feature">FEATURED PRODUCTS</a>
            </li>
        </ul>
        <div class="tab-content" id="">
            <div class="tab-pane fade show active" id="prod" role="tabpanel" aria-labelledby="prod-tab">
                    @if(!$new_product->isEmpty())
                <div class="prod-slider">
                    @foreach($new_product as $key => $pro)
                    <div class="prod-slides">
                        <div class="shop-blk">
                            <img src="{{asset($pro->image)}}" alt="" />
                            <h3>{{$pro->model}}</h3>
                            <h4>$23.90 <span> $19.12</span></h4>
                            <a href="#" class="cart-btn">Add to cart</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                    @else
                    <img src="{{asset('web/images/coming-soon.jpg')}}" class="coming-soon" alt="" />
                    @endif
                    
                    <!-- <div class="prod-slides">
                        <div class="shop-blk">
                            <div class="sale-txt">
                                <h3>Sale</h3>
                                <h2>Custom Lable</h2>
                            </div>
                            <img src="{{asset('web/images/prod-img02.png')}}" alt="" />
                            <h3>Common Good</h3>
                            <p>Lorem ipsum dolor sit amet consecte tur adipiscing elit.</p>
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <h4>$23.90 <span> $19.12</span></h4>
                            <a href="#" class="cart-btn">Add to cart</a>
                        </div>
                    </div>
                    <div class="prod-slides">
                        <div class="shop-blk">
                            <div class="sale-txt">
                                <h3>Sale</h3>
                                <h2>Custom Lable</h2>
                            </div>
                            <img src="{{asset('web/images/prod-img03.png')}}" alt="" />
                            <h3>Common Good</h3>
                            <p>Lorem ipsum dolor sit amet consecte tur adipiscing elit.</p>
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <h4>$23.90 <span> $19.12</span></h4>
                            <a href="#" class="cart-btn">Add to cart</a>
                        </div>
                    </div>
                    <div class="prod-slides">
                        <div class="shop-blk">
                            <div class="sale-txt">
                                <h3>Sale</h3>
                                <h2>Custom Lable</h2>
                            </div>
                            <img src="{{asset('web/images/prod-img02.png')}}" alt="" />
                            <h3>Common Good</h3>
                            <p>Lorem ipsum dolor sit amet consecte tur adipiscing elit.</p>
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <h4>$23.90 <span> $19.12</span></h4>
                            <a href="#" class="cart-btn">Add to cart</a>
                        </div>
                    </div>
                    <div class="prod-slides">
                        <div class="shop-blk">
                            <div class="sale-txt">
                                <h3>Sale</h3>
                                <h2>Custom Lable</h2>
                            </div>
                            <img src="{{asset('web/images/prod-img02.png')}}" alt="" />
                            <h3>Common Good</h3>
                            <p>Lorem ipsum dolor sit amet consecte tur adipiscing elit.</p>
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <h4>$23.90 <span> $19.12</span></h4>
                            <a href="#" class="cart-btn">Add to cart</a>
                        </div>
                    </div>
                    <div class="prod-slides">
                        <div class="shop-blk">
                            <div class="sale-txt">
                                <h3>Sale</h3>
                                <h2>Custom Lable</h2>
                            </div>
                            <img src="{{asset('web/images/prod-img02.png')}}" alt="" />
                            <h3>Common Good</h3>
                            <p>Lorem ipsum dolor sit amet consecte tur adipiscing elit.</p>
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <h4>$23.90 <span> $19.12</span></h4>
                            <a href="#" class="cart-btn">Add to cart</a>
                        </div>
                    </div> -->
            </div>
            <div class="tab-pane fade show" id="seller" role="tabpanel" aria-labelledby="seller-tab">
                    @if(!$best_seller->isEmpty())
                <div class="prod-slider">
                    @foreach($best_seller as $best)
                    <div class="prod-slides">
                        <div class="shop-blk">
                            <img src="{{asset($best->image)}}" alt="" />
                            <h3>{{$best->model}}</h3>
                            <?php $company = App\Models\company::where('is_active',1)->where('is_deleted',0)->where('id',$best->company_id)->first(); ?>
                            <p>{{$company->name}}</p>
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <h4>${{$best->gt_price}} <!-- <span> $19.12</span> --></h4>
                            <a href="{{route('detail',Crypt::encrypt($best->id))}}" class="cart-btn">View Details</a>
                        </div>
                    </div>
                    @endforeach
                <!-- 
                    <div class="prod-slides slick-slide">
                        <div class="shop-blk">
                            <div class="sale-txt">
                                <h3>Sale</h3>
                                <h2>Custom Lable</h2>
                            </div>
                            <img src="{{asset('web/images/prod-img02.png')}}" alt="" />
                            <h3>Common Good</h3>
                            <p>Lorem ipsum dolor sit amet consecte tur adipiscing elit.</p>
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <h4>$23.90 <span> $19.12</span></h4>
                            <a href="#" class="cart-btn">Add to cart</a>
                        </div>
                    </div>
                    <div class="prod-slides slick-slide">
                        <div class="shop-blk">
                            <div class="sale-txt">
                                <h3>Sale</h3>
                                <h2>Custom Lable</h2>
                            </div>
                            <img src="{{asset('web/images/prod-img03.png')}}" alt="" />
                            <h3>Common Good</h3>
                            <p>Lorem ipsum dolor sit amet consecte tur adipiscing elit.</p>
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <h4>$23.90 <span> $19.12</span></h4>
                            <a href="#" class="cart-btn">Add to cart</a>
                        </div>
                    </div>
                    <div class="prod-slides slick-slide">
                        <div class="shop-blk">
                            <div class="sale-txt">
                                <h3>Sale</h3>
                                <h2>Custom Lable</h2>
                            </div>
                            <img src="{{asset('web/images/prod-img02.png')}}" alt="" />
                            <h3>Common Good</h3>
                            <p>Lorem ipsum dolor sit amet consecte tur adipiscing elit.</p>
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <h4>$23.90 <span> $19.12</span></h4>
                            <a href="#" class="cart-btn">Add to cart</a>
                        </div>
                    </div>
                    <div class="prod-slides slick-slide">
                        <div class="shop-blk">
                            <div class="sale-txt">
                                <h3>Sale</h3>
                                <h2>Custom Lable</h2>
                            </div>
                            <img src="{{asset('web/images/prod-img02.png')}}" alt="" />
                            <h3>Common Good</h3>
                            <p>Lorem ipsum dolor sit amet consecte tur adipiscing elit.</p>
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <h4>$23.90 <span> $19.12</span></h4>
                            <a href="#" class="cart-btn">Add to cart</a>
                        </div>
                    </div>
                    <div class="prod-slides slick-slide">
                        <div class="shop-blk">
                            <div class="sale-txt">
                                <h3>Sale</h3>
                                <h2>Custom Lable</h2>
                            </div>
                            <img src="{{asset('web/images/prod-img02.png')}}" alt="" />
                            <h3>Common Good</h3>
                            <p>Lorem ipsum dolor sit amet consecte tur adipiscing elit.</p>
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <h4>$23.90 <span> $19.12</span></h4>
                            <a href="#" class="cart-btn">Add to cart</a>
                        </div>
                    </div>
                    
                 -->
                     
                 </div>
                    @else
                    <img src="{{asset('web/images/coming-soon.jpg')}}" class="coming-soon" alt="" />
                    @endif
            </div>
            <div class="tab-pane fade show" id="feature" role="tabpanel" aria-labelledby="feature-tab">
                    @if(!$featured->isEmpty())
                <div class="prod-slider">
                    @foreach($featured as $fitr)
                    <div class="prod-slides">
                        <div class="shop-blk">
                            <img src="{{asset($fitr->image)}}" alt="" />
                            <h3>{{$fitr->model}}</h3>
                            <?php $company = App\Models\company::where('is_active',1)->where('is_deleted',0)->where('id',$fitr->company_id)->first(); ?>
                            <p>{{$company->name}}</p>
                            <ul class="star-icons">
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                            </ul>
                            <h4>{{$fitr->gt_price}} <!-- <span> $19.12</span> --></h4>
                            <a href="{{route('detail',Crypt::encrypt($fitr->id))}}" class="cart-btn">View Details</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                    @else
                    <img src="{{asset('web/images/coming-soon.jpg')}}" class="coming-soon" alt="" />
                    @endif
            </div>
        </div>
    </div>
</section>
<section class="testimonial-sec">
    <div class="container">
        <div class="review-heading">
            <h1>Customer Reviews</h1>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="testimonial-slider">
                    <div class="testiml-slides">
                        <img src="{{asset('web/images/quote-img.png')}}" alt="" />
                        <img src="{{asset('web/images/coming-soon.jpg')}}" class="coming-soon" alt="" />
                        <!-- <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.
                        </p> -->
                        <!-- <h4>John Doe</h4>
                        <h5>Ceo, Lorem lipsum</h5> -->
                    </div>
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="testimonial-img">
                    <!--  <img src="{{asset('web/images/car-model-img.png')}}" alt=""> -->
                </div>
            </div>
        </div>
    </div>
</section>
<section class="shipping-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="free-shipping">
                    <span><img src="{{asset('web/images/icon-img11.png')}}" alt="" /></span>
                    <div class="shipng-txt">
                        <h3>WORLDWIDE FREE SHIPPING</h3>
                        {{--<p>Dinterdum pretium an dapboe dan mauris lorem de condimentu</p>--}}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="free-shipping">
                    <span><img src="{{asset('web/images/icon-img12.png')}}" alt="" /></span>
                    <div class="shipng-txt">
                        <h3>SECURE SHOPPING</h3>
                        {{--<p>Dinterdum pretium an dapboe dan mauris lorem de condimentu</p>--}}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="free-shipping">
                    <span><img src="{{asset('web/images/icon-img13.png')}}" alt="" /></span>
                    <div class="shipng-txt">
                        <h3>30-DAY FREE RETURNS</h3>
                        {{--<p>Dinterdum pretium an dapboe dan mauris lorem de condimentu</p>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')

@endsection
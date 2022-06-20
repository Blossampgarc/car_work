@extends('web.layouts.main') @section('content')
<?php
$minimum_range = 0;
$maximum_range = 5000;
?>
<!-- Header End -->
<section class="banner-sec">
    <div id="demo" class="carousel slide" data-ride="carousel">
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
                                    <a href="#" class="shop-btn">SHOP NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('web.layouts.inner-search')
            </div>
        </div>
    </div>
</section>
@include('web.layouts.accessory-list')
<section class="product-sec">
            <div class="container">
                <div class="product-blk">
                    @if(!$years->isEmpty())
                    @foreach($years as $key => $value)
                    <?php $company = App\Models\company::where('is_active',1)->where('id',$value->company_id)->first(); ?>
                    <div class="row product-row"> 
                        <div class="col-md-9">
                            <div class="product-main">
                                <div class="product-imgg">
                                    <img src="{{asset('web/images/product1.png')}}" />
                                </div>
                                <div class="product-info">
                                    <h6>{{$company->name}}</h6>
                                    <h5>{{$value->model}}</h5>
                                    <p><span>Floor Mats</span></p>
                                    <div class="vechile-rating">
                                        <ul>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><span class="span-1">765</span></li>
                                            <li><a href="#">Vehcle Specific</a></li>
                                            <li><span>=161257</span></li>
                                        </ul>
                                    </div>
                                    <!-- <p class="info">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.Risus commodo viverra maecenas
                                        accumsan lacus vel
                                    </p> -->
                                    <div class="product-color">
                                        <a href="#" class="color-1"></a>
                                        <a href="#" class="color-2"></a>
                                        <a href="#" class="color-3"></a>
                                        <p>+10</p>
                                    </div>
                                    <div class="availability">
                                        <p>Available</p>
                                        <p>Varies</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="starting-price">
                                <p>from <span>${{$value->gt_price}}</span></p>
                                <a href="{{route('detail',Crypt::encrypt($value->id))}}">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif

                    @if(!$makes->isEmpty())
                    @foreach($makes as $key => $value)
                    <?php $company = App\Models\company::where('is_active',1)->where('id',$value->company_id)->first(); ?>
                    <div class="row product-row"> 
                        <div class="col-md-9">
                            <div class="product-main">
                                <div class="product-imgg">
                                    <img src="{{asset('web/images/product1.png')}}" />
                                </div>
                                <div class="product-info">
                                    <h6>{{$company->name}}</h6>
                                    <h5>{{$value->model}}</h5>
                                    <p><span>Floor Mats</span></p>
                                    <div class="vechile-rating">
                                        <ul>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><span class="span-1">765</span></li>
                                            <li><a href="#">Vehcle Specific</a></li>
                                            <li><span>=161257</span></li>
                                        </ul>
                                    </div>
                                    <!-- <p class="info">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.Risus commodo viverra maecenas
                                        accumsan lacus vel
                                    </p> -->
                                    <div class="product-color">
                                        <a href="#" class="color-1"></a>
                                        <a href="#" class="color-2"></a>
                                        <a href="#" class="color-3"></a>
                                        <p>+10</p>
                                    </div>
                                    <div class="availability">
                                        <p>Available</p>
                                        <p>Varies</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="starting-price">
                                <p>from <span>${{$value->gt_price}}</span></p>
                                <a href="{{route('detail',Crypt::encrypt($value->id))}}">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif

                    @if(!$models->isEmpty())
                    @foreach($models as $key => $value)
                    <?php $company = App\Models\company::where('is_active',1)->where('id',$value->company_id)->first(); ?>
                    <div class="row product-row"> 
                        <div class="col-md-9">
                            <div class="product-main">
                                <div class="product-imgg">
                                    <img src="{{asset('web/images/product1.png')}}" />
                                </div>
                                <div class="product-info">
                                    <h6>{{$company->name}}</h6>
                                    <h5>{{$value->model}}</h5>
                                    <p><span>Floor Mats</span></p>
                                    <div class="vechile-rating">
                                        <ul>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><span class="span-1">765</span></li>
                                            <li><a href="#">Vehcle Specific</a></li>
                                            <li><span>=161257</span></li>
                                        </ul>
                                    </div>
                                    <!-- <p class="info">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.Risus commodo viverra maecenas
                                        accumsan lacus vel
                                    </p> -->
                                    <div class="product-color">
                                        <a href="#" class="color-1"></a>
                                        <a href="#" class="color-2"></a>
                                        <a href="#" class="color-3"></a>
                                        <p>+10</p>
                                    </div>
                                    <div class="availability">
                                        <p>Available</p>
                                        <p>Varies</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="starting-price">
                                <p>from <span>${{$value->gt_price}}</span></p>
                                <a href="{{route('detail',Crypt::encrypt($value->id))}}">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif

                    @if($years->isEmpty() && $makes->isEmpty() && $models->isEmpty())
                    <div class="alert-warning" style="margin: 70px; text-align: center; padding: 0.75rem 1.25rem; ">
                      <strong>No Record Found !</strong>
                    </div>
                    @endif

                </div>
                
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
@endsection

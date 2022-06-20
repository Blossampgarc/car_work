<?php
$product = App\Models\ads::where('is_active',1)->where('is_deleted',0)->get();
// $chunks = Helper::partition($product,2);

?>
<section class="more-products">
    <div class="container">
        <div class="more-heading">
            <h1>MORE PRODUCTS</h1>
        </div>
        <div class="row">
            @if(!$product->isEmpty())
                @if(count($product) === 1)
                    @foreach($product as $pro)
                    <div class="col-md-12">
                        <div class="more-imgs">
                            <img src="{{asset($pro->image)}}" alt="" />
                            <div class="more-prd-txt">
                                <h3>{{$pro->name}}</h3>
                                <p>{{$pro->desc}}</p>
                            </div>
                            <div class="more-prd-btn">
                                <a href="{{$pro->url}}" class="shop-btn">SHOP NOW</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @elseif(count($product) === 2)
                    @foreach($product as $pro)
                    <div class="col-md-6">
                        <div class="more-imgs">
                            <img src="{{asset($pro->image)}}" alt="" />
                            <div class="more-prd-txt">
                                <h3>{{$pro->name}}</h3>
                                <p>{{$pro->desc}}</p>
                            </div>
                            <div class="more-prd-btn">
                                <a href="{{$pro->url}}" class="shop-btn">SHOP NOW</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <?php $chunks = $product->chunk(2); ?>
                    @foreach($chunks as $key => $pro)
                        <div class="col-md-6">
                            @foreach($pro as $ad)
                                <div class="more-imgs">
                                    <img src="{{asset($ad->image)}}" alt="" />
                                    <div class="more-prd-txt">
                                        <h3>{{$ad->name}}</h3>
                                        <p>{{$ad->desc}}</p>
                                    </div>
                                    <div class="more-prd-btn">
                                        <a href="{{$ad->url}}" class="shop-btn">SHOP NOW</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            @else
                <div class="col-md-12">
                    <img src="{{asset('web/images/coming-soon.jpg')}}" class="coming-soon" alt="" />
                </div>
            @endif
        </div>
        <div class="browse-btn">
            <a href="{{route('product')}}">browse all PRODUCTS</a>
        </div>
    </div>
</section>
<?php
$product = App\Models\car_details::get_sale();
$count = 0;
?>
<div class="col-md-9">
    <div class="flash-sale-prod">
        <div class="container">
            <div class="top-heading">
                <div class="top-head1">
                    <h2>FLASH SALE</h2>
                </div>
                <div class="top-head2">
                    <ul>
                        <li>Hurry And Grab This Offers</li>
                        <li>|</li>
                        <li><a href="{{route('product')}}">VIEW ALL</a></li>
                    </ul>
                </div>
            </div>
            <div class="view-product">
                <div class="row">
                    @if(!$product->isEmpty())
                    @foreach($product as $key => $pro)
                    @php
                    $datetime2 = new DateTime(date("Y-m-d H:i:s"));
                    $sale = $pro->check_sale($datetime2,$pro->id);
                    
                    @endphp
                    @if ($sale)
                    @php
                    $price = ($pro->gt_price/100)*(100-$sale->dis_percentage);
                    $count++;
                    @endphp
                    <div class="col-md-4">
                        <div class="shop-blk">
                            <div class="sale-txt">
                                <h3>Sale</h3>
                            </div>
                            <img src="{{asset($pro->image)}}" alt="" />
                            <h3>{{$pro->model}}</h3>
                            <h4>${{$price}} <span>${{$pro->gt_price}}</span></h4>
                            <a href="{{route('detail',Crypt::encrypt($pro->id))}}" class="cart-btn">View Details</a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endif
                    @if($count == 0)
                    <img src="{{asset('web/images/coming-soon.jpg')}}" class="coming-soon" alt="" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

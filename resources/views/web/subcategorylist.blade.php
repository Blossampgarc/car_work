@extends('web.layouts.main')
@section('content')
<!-- Header End -->
@if($category->banner != "" && $category->banner != null)
    @php $path = $category->banner; @endphp
@else
    @php $path = "web/images/inrbanner.png"; @endphp
@endif
<section class="banner-sec">
    <div class="banner-img">
        <img src="{{asset($path)}}" />
        <div class="banner-info">
            <h5>{{$category->name}} Accessories</h5>
        </div>
    </div>
</section>

<section class="products-sec">
    <div class="container">
        <div class="row">
            @if($subcategory)
            @foreach($subcategory as $val)
            <div class="col-md-3">
                <?php 
                    //$car_details_count = App\Models\car_details::where('subcategory_id', $val->id)->count();
                    $car_details_count = $val->car_details_count($val->id);

                ?>
                <a href="{{ $car_details_count == 0 ? '#' : route('subcategory_products', Crypt::encrypt($val->id)) }}">
                    <div class="products-blk">
                        <span>({{$car_details_count}})</span>
                        <img src="{{asset($val->image)}}" />
                        <h5>{{$val->name}}</h5>
                        <p>{{$val->desc}}</p>
                    </div>
                </a>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>

@endsection
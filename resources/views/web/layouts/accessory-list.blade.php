<?php
use App\Models\accessories;
 $accessories = accessories::where('is_active',1)->where('is_deleted',0)->get();
?>
<section class="categories-sec">
    <div class="container">
    <div class="inner-sec">
    <div class="row">

        @foreach($accessories as $val)
        <div class="col-md-2">
            <a href="{{route('category_list',Crypt::encrypt($val->id))}}">
                <div class="prod-cate">
                    <img src="{{asset($val->image)}}" alt="" />
                    <span><h3>{{$val->name}}</h3></span>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
</div>
    
    
    <!-- <div class="prod-cate">
        <img src="{{asset('web/images/icon-img01.png')}}" alt="" />
        <span><h3>Brake Parts</h3></span>
    </div>
    <div class="prod-cate">
        <img src="{{asset('web/images/icon-img02.png')}}" alt="" />
        <span><h3>Brake Parts</h3></span>
    </div>
    <div class="prod-cate">
        <img src="{{asset('web/images/icon-img03.png')}}" alt="" />
        <span><h3>Brake Parts</h3></span>
    </div>
    <div class="prod-cate">
        <img src="{{asset('web/images/icon-img04.png')}}" alt="" />
        <span><h3>Brake Parts</h3></span>
    </div>
    <div class="prod-cate">
        <img src="{{asset('web/images/icon-img05.png')}}" alt="" />
        <span><h3>Brake Parts</h3></span>
    </div>
    <div class="prod-cate">
        <img src="{{asset('web/images/icon-img06.png')}}" alt="" />
        <span><h3>Brake Parts</h3></span>
    </div> -->
</section>
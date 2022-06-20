@extends('web.layouts.main') 
@section('content')
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
                <!-- <div class="car-cls">
                    <div class="banner-search">
                        <select>
                            <option>Year</option>
                            <option></option>
                        </select>
                    </div>
                    <div class="banner-search">
                        <select>
                            <option>Make</option>
                            <option></option>
                        </select>
                    </div>
                    <div class="banner-search">
                        <select>
                            <option>Model</option>
                            <option></option>
                        </select>
                    </div>
                    <div class="banner-search">
                        <form>
                            <input type="text" name="text" placeholder="Search By Parts# or Keyword" />
                            <button><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>
<section class="changevechile-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="change-info">
                    <h5><span>2020 Acura ILX</span>Accessories & Parts</h5>
                </div>
            </div>
            <div class="col-md-6">
                <div class="change-vechile">
                    <a href="#">Change Vechile</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="interior-sec">
    <div class="container">
        <h5>Lighting  Accessories</h5>
         @foreach($lighting_category->chunk(5) as  $chunk)
        <div class="interior-main">
             @foreach($chunk as $light)
              <?php
            $subcategoryCount = $light->subCategoryCount($light->id,$light->accessories_id);
                            
                            ?>
        <a href="{{ $subcategoryCount == 0 ? '#' : route('subcategory_list', Crypt::encrypt($light->id)) }}">
            <ul>
                <li>
                    <p><span>({{ $subcategoryCount}})</span></p>
                    <img src="{{asset($light->image)}}" />
                    <p>{{ $light->name }}</p>
                </li>
            </ul>
            </a>
              @endforeach    
        </div>
          @endforeach 
       
        <div class="exterior-blk">
            
            <div class="exterior-main">
                <h5>Wheels  And Tries Accessories</h5>
                @foreach($wheels_tries_category->chunk(5) as  $chunk_2)
                
                <div class="interior-main">
                  @foreach($chunk_2 as $val_2)
                    <?php
            $subcategoryCount = $val_2->subCategoryCount($val_2->id,$val_2->accessories_id);           
                  ?>
             <a href="{{ $subcategoryCount == 0 ? '#' : route('subcategory_list', Crypt::encrypt($val_2->id)) }}">
                    <ul>
                        <li>
                             <p><span>({{ $subcategoryCount}})</span></p>
                            <img src="{{asset($val_2->image)}}" />
                            <p>{{ $val_2->name }}</p>
                        </li>
                    </ul>
                    </a>
                    @endforeach 
                </div>
                
           @endforeach   
   

</section>
@endsection

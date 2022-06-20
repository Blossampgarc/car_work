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
        <h5>Interior Accessories</h5>
         @foreach($interior_category->chunk(5) as  $chunk)
        <div class="interior-main">
             @foreach($chunk as $val_1)
              <?php
            $subcategoryCount = $val_1->subCategoryCount($val_1->id,$val_1->accessories_id);
                            
                            ?>
        <a href="{{ $subcategoryCount == 0 ? '#' : route('subcategory_list', Crypt::encrypt($val_1->id)) }}">
            <ul>
                <li>
                    <p><span>({{ $subcategoryCount}})</span></p>
                    <img src="{{asset($val_1->image)}}" />
                    <p>{{ $val_1->name }}</p>
                </li>
            </ul>
            </a>
              @endforeach    
        </div>
          @endforeach 
       
        <div class="exterior-blk">
            
            <div class="exterior-main">
                <h5>Exterior Accessories</h5>
                @foreach($exteriror_category->chunk(5) as  $chunk_2)
                
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
    <div class="performance-main">
        <div class="container">
            <h5>Performance Parts</h5>

            @foreach($performance_parts_category->chunk(5) as  $chunk_3)

            <div class="interior-main">
             @foreach($chunk_3 as $val_3)
               <?php
            $subcategoryCount = $val_3->subCategoryCount($val_3->id,$val_3->accessories_id);           
                  ?>
                   <a href="{{ $subcategoryCount == 0 ? '#' : route('subcategory_list', Crypt::encrypt($val_3->id)) }}">
                <ul>
                    <li>
                         <p><span>({{ $subcategoryCount}})</span></p>
                        <img src="{{asset($val_3->image)}}" />
                        <p>{{ $val_3->name }}</p>
                    </li>
                    </a>
                </ul>
                  @endforeach   
           
            </div>
            @endforeach  
           
        </div>
    </div>
    <div class="load-more">
        <div class="container">
            <a href="{{route('search_more_category')}}" class="shop-btn">Read More</a>
         
          
        </div>
    </div>
</section>
@endsection

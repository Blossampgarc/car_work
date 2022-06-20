@extends('web.layouts.main') 
@section('content')
<?php
$minimum_range = 0;
$maximum_range = 6000;
$brand = App\Models\brand::where('is_active',1)->where('is_deleted',0)->orderBy('id', 'desc')->get();
$company = App\Models\company::where('is_active',1)->where('is_deleted',0)->orderBy('name', 'asc')->get();
$model = App\Models\car_details::where('is_active',1)->groupBy('model')->pluck('model');
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
                                    <a href="{{route('product')}}" class="shop-btn">SHOP NOW</a>
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
        <div class="row">
            <div class="col-md-3">
                <div class="product-selection">
                    <div class="productselection-inr">
                        {{--
                        <h5>-Model</h5>
                        <ul>
                            <li><a href="#">All-Weather Mats</a></li>
                            <li><a href="#">Carpet Mats</a></li>
                            <li><a href="#">Ruber Mats</a></li>
                            <li><a href="#">Logo Mats</a></li>
                            <li><a href="#">Monogrammend Mats</a></li>
                            <li><a href="#">Aluminum Mats</a></li>
                            <li><a href="#">Natural Fiber Mats</a></li>
                            <li><a href="#">Replacement Carpet</a></li>
                            <li><a href="#">Cargo Liners</a></li>
                            <li><a href="#">Floor Mats</a></li>
                        </ul>
                        --}}
                        </div>
                           <form id="myform" method="POST"> 
                         <div class="brand-blk">
                                    <h5>-Make</h5>
                                    {{--
                                    <div class="search-main">
                                        <input type="text" placeholder="Search" />
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </div>
                                        --}}
                                    <div class="inr-products">
                                        @if($company)
                                        @foreach($company as $key => $com)
                                        @if($key < 10)
                                        <label class="chckkbox">
                                            {{$com->name}}
                                            <input type="checkbox" class="FormClass" name="company[]" value="{{$com->id}}"/>
                                            <span class="checkmark"></span>
                                        </label>
                                        @endif
                                        @endforeach
                                        @endif
                                        
                                        <span id="dots"></span>
                                        <span id="more">
                                            @if($company)
                                            @foreach($company as $key => $com)
                                            @if($key >= 10)
                                            <label class="chckkbox">
                                                {{$com->name}}
                                                <input type="checkbox" class="FormClass" name="company[]" value="{{$com->id}}"/>
                                                <span class="checkmark"></span>
                                            </label>
                                            @endif
                                            @endforeach
                                            @endif
                                        </span>
                                        
                                    </div>
                                
                                    <div class="view-more">
                                        <a href="javascript:void(0)" onclick="myFunction()" id="myBtn"><i class="fa fa-plus-circle" aria-hidden="true"></i> View More</a>
                                        <!-- <button onclick="myFunction()" id="myBtn"><i class="fa fa-plus-circle" aria-hidden="true"></i>View More</button> -->
                                    </div>                                    
                                </div>   
                        <div class="type">
                        <div class="fitmentt">
                            {{--
                            <h5>-Fitment</h5>
                            <ul>
                                <li><a href="#">Vehicale Specific</a></li>
                                <li><a href="#">Universal Fit</a></li>
                            </ul>
                             --}}
                             
                            <div class="price">
                                <h5>Price</h5>
                                <!-- <div class="price-form">
                                    <form>
                                        <input type="text" placeholder="$Min" />
                                        <input type="text" placeholder="$Max" />
                                        <button>Go</button>
                                    </form>
                                </div> -->
                                 <!-- <div class="rangeslidr-blk">
                              <div class="rangeslider-inr">
                              </div>
                           </div> -->
         <div class="panel range-slide" style="max-height: 80px;margin: 7px 0;">
        <div class="row row-spc FormClass" style="padding-bottom: 10px;">
          <div class="col-md-3">
          <input type="text" name="minimum_range" id="minimum_range" class="form-control" value="<?php echo $minimum_range; ?>" />
        </div>
        <div class="col-md-6" style="padding: 12px 0 0;">
          <div id="price_range" class="FormClass"></div>
        </div>
        <div class="col-md-3">
          <input type="text" name="maximum_range" id="maximum_range" class="form-control" value="<?php echo $maximum_range; ?>" />
        </div> 
        </div>                                                             
        </div>
                                <!-- <div class="range-slider">
                                    <div class="slidecontainer">
                                        <input type="range" min="1" max="100" value="100" class="slider" id="myRange" />
                                    </div>
                                </div> -->

                                {{--<div class="product-rating">
                                    <h5>-Rating</h5>
                                    <div class="ratingg-mainn">
                                        <div class="chckbox">
                                            <label class="chckkbox">
                                                <input type="checkbox" />
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="ratingg-blk">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <p>4 and Up</p>
                                        </div>
                                    </div>
                                    <div class="ratingg-mainn">
                                        <div class="chckbox">
                                            <label class="chckkbox">
                                                <input type="checkbox" />
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="ratingg-blk ratingg-blk2">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <p>4 and Up</p>
                                        </div>
                                    </div>
                                    <div class="ratingg-mainn">
                                        <div class="chckbox">
                                            <label class="chckkbox">
                                                <input type="checkbox" />
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="ratingg-blk ratingg-blk3">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <p>4 and Up</p>
                                        </div>
                                    </div>
                                    <div class="verify-blk">
                                        <div class="chckbox">
                                            <label class="chckkbox">
                                                Not Yet Rated
                                                <input type="checkbox" />
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="rating-sliderblk">
                                        <div class="rating-sliderblkinr"></div>
                                    </div>
                                </div>--}}

                              
                                

                                <div class="brand-blk">
                                	 <input type="hidden" name="br_id" id="br_id" value="{{ $id == '' ? '-' : $id }}">
                                    <h5>-Brand</h5>
                                    {{--
                                    <div class="search-main">
                                        <input type="text" placeholder="Search" />
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </div>
                                        --}}

                                    <div class="inr-products">


                                    	
                                        @if($brand)
                                        @foreach($brand as $vals)
                                        <label class="chckkbox">
                                            {{$vals->name}}
                                            <input type="checkbox" name="brand" value="{{$vals->id}}" class="brand-check-input" />
                                            <span class="checkmark"></span>
                                        </label>
                                        @endforeach
                                        <input type="hidden" id="brand_id" name="brand_id">
                                        @endif
                                        {{--
                                        <label class="chckkbox">
                                            Aries
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            AutoExec
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            Bully
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            Covercraft
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            Custom Acessories
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            Dee Zee
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            Designer Mat
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            Exactmats
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            FanMats
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            G3
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            Herrero & Sons
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            intro-Tech Automotive
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            K&H
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            Lioyd Mats
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            Newark Auto
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="chckkbox">
                                            Pilot
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                        
                                        <span id="dots"></span>
                                        <span id="more">
                                            <label class="chckkbox">
                                                PlastiColor
                                                <input type="checkbox" />
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="chckkbox">
                                                RBP
                                                <input type="checkbox" />
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="chckkbox">
                                                Rixxu
                                                <input type="checkbox" />
                                                <span class="checkmark"></span>
                                            </label>
                                        </span>
                                        --}}
                                    </div>
                                    {{--
                                    <div class="view-more">

                                        <button  type="button" onclick="myFunction()" id="myBtn"><i class="fa fa-plus-circle" aria-hidden="true"></i>View More</button>
                                    </div>
                                    --}}
                                    <div class="clear">
                                        <a href="javacript:void(0)" onclick='return uncheckAll()'>Clear All</a>
                                    </div>
                                </div>
                                </form>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="showitem-main">
                        <div class="show-item-1">
                            <span>Show items:</span>
                             
                        </div>
                        <div class="text-center">
                            <ul class="pagination">
                                {!! $products->links("pagination::bootstrap-4") !!}
                            </ul>
                        </div>
                        
                        {{--
                        <div class="show-item-1 show-item-2">
                            <a href="#">90</a>
                        </div>
                        <div class="show-item-1 show-item-3">
                            <a href="#">90</a>
                        </div>
                        --}}
                    </div>
                <div class="showitem-row">
                    <div class="sort-by">
                        <p>Sort</p>
                        <select>
                            <option>Recommended</option>
                            <option>UnRecommended</option>
                        </select>
                    </div>
                </div>

                <div class="product-blk">
                    <div id="ajax_response">
                        
                    </div>
                    @if(!$products->isEmpty())
                    @foreach($products as $key => $value)
                    <?php $company = App\Models\company::where('is_active',1)->where('id',$value->company_id)->first(); ?>
                    <div class="row product-row product-hide">
                        <div class="col-md-9">
                            <div class="product-main">
                                <div class="product-imgg">
                                    <img src="{{asset($value->image)}}" />
                                </div>
                                <div class="product-info">
                                    <h6>{{$company->name}}</h6>
                                    <h5>{{$value->model}}</h5>
                                    <p><span>{{$value->getsubcategory($value->subcategory_id)->name}}</span></p>
                                    
                                    {{-- <p><span>{{$value->getcategory($value->category_id)->name}}</span></p> --}}
                                    
                                    {{--
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
                                    
                                    <p class="info">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.Risus commodo viverra maecenas
                                        accumsan lacus vel
                                    </p>
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
                                    --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="starting-price">
                                <?php $price=number_format($value->gt_price, 2, '.', ','); ?>
                                <p>from <span>${{$price}}</span></p>
                                <a href="{{route('detail',Crypt::encrypt($value->id))}}">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <h2>No product</h2>
                    @endif

         
                    
                    
                    
                    {{--
                    <div class="row product-row">
                        <div class="col-md-9">
                            <div class="product-main">
                                <div class="product-imgg">
                                    <img src="{{asset('web/images/product1.png')}}" />
                                </div>
                                <div class="product-info">
                                    <h6>Lorem</h6>
                                    <h5>Aliquam elit purus</h5>
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
                                    <p class="info">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.Risus commodo viverra maecenas
                                        accumsan lacus vel
                                    </p>
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
                                <p>from<span>$54.90</span></p>
                                <a href="">View Details</a>
                            </div>
                        </div>
                    </div>
                    --}}
                </div>
                
            </div>
        </div>
    </div>
</section>
<style>
#minimum_range{
background-color: #ebebeb;
}#maximum_range{
background-color: #ebebeb;
}
.range-slide .row > div {
    padding: 0 11px;
    font-size: 12px;
}

.range-slide .row > div input {
    padding: 10px 0;
    font-size: 12px;
    text-align: center;
}
</style>
@endsection
@section('js')
<script>
	$('.brand-check-input').change(function (){
       var favorite = [];
            $.each($("input[name='brand']:checked"), function(){
                favorite.push($(this).val());
                  $('#brand_id').val(favorite.join(", "));
       
     var id= $("#brand_id").val();
      $.ajax({
      url: "{{route('brand_products_show')}}",
      type: "GET",
      data: {
      _token: "{{csrf_token()}}",
      id: id,
      },
      dataType:'json',
        success: function (data) {
            $(".product-hide").hide();
            $(".showitem-main").hide();
            $("#ajax_response").html(data.body);
        },
    });
      });
    });

    
   



 




$(".FormClass").click(function (e) {
    // console.log("here")
    submitForm();
});
function submitForm() {
    var dataString = $("#myform").serialize();
    var minimum_range = $("input[name='minimum_range']").val();
    var maximum_range = $("input[name='maximum_range']").val();
    var temp = "";

    $("input[name='company[]']:checked").each(function (i, e) {
        temp += $(e).val() + ",";
    });
    temp = temp.slice(0, -1);
    console.log(temp)
    var checked = "";
    $.ajax({
        type: "POST",
        url: "{{route('post_ajax_call')}}",
        data: { company: temp, _token: "{{csrf_token()}}", minimum_range: minimum_range, maximum_range: maximum_range },
        dataType: "json",
        success: function (data) {
            console.log(data);
            $(".product-hide").hide();
            $(".showitem-main").hide();
            $("#ajax_response").html(data.body);
        },
    });
    return false;
}
function uncheckAll() {
    document.querySelectorAll('input[type="checkbox"]').forEach((el) => (el.checked = false));

    $("#ajax_response").hide();
    $(".product-hide").show();
}

</script>
<script>
  $(document).ready(function(){  
  $( "#price_range" ).slider({
    range: true,
    min: 0,
    max: 5000,
    values: [ <?php echo $minimum_range; ?>, <?php echo $maximum_range; ?> ],
    slide:function(event, ui){
      $("#minimum_range").val(ui.values[0]);
      $("#maximum_range").val(ui.values[1]);
    }
  });
});  
</script>


@endsection

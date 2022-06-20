@extends('web.layouts.main') @section('content')
<!-- Header End -->
<section class="banner-sec">
    <div class="banner-img">
        <img src="{{asset('web/images/inrbanner.png')}}" />
        <div class="banner-info">
            <h5>Product Detail</h5>
        </div>
    </div>
</section>
@if($product)
<section class="product-sec">
    <div class="container">

        <div class="row">
            <div class="col-md-6">
                <div class="product-img">
                    <img src="{{asset($product->image)}}" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-info">
                    <?php $company = $product->get_company($product->company_id); ?>
                    <h5>{{$company->name}}<sup><i class="fa fa-registered" aria-hidden="true"></i></sup> -
                        {{$product->model}}</h5>
                    <div class="jstars"
                        data-value="{{ $product->ratings_average == 0 ? 0.5 : $product->ratings_average }}"
                        data-total-stars="5"
                        data-color="#deb217"data-empty-color="#ccc"
                        data-size="30px">
                    </div>

                    <div class="review-main">
                        {{--
                        <div class="rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                        --}}
                        <div class="review">
                            <ul>

                                <!-- <li>765 reviews</li> -->
                                <!-- <li>1 Q&A</li>
                                <li>Item # 161257</li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="starting">
                        <p><span>Price: ${{$product->gt_price}} {{$product->gtr_price !== null ? " -
                                $".$product->gtr_price : ($product->gts_price !== null ? " - $".$product->gts_price :
                                "") }}</span></p>
                    </div>
                    {{--
                    <div class="manufacture">
                        <p>Manufactured - Ship in 2 to 4 days</p>
                    </div>
                    --}}
                    <div class="deleivry">
                        <!-- <div class="deleivry-main">
                            <div class="deleivry-img">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </div>
                            <div class="deleivry-info">
                                <p>Deliver to</p>
                                <p>united states <a href="#">Change</a></p>
                            </div>
                        </div> -->
                        <div class="deleivry-main">
                            <div class="deleivry-img">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                            </div>
                            <div class="deleivry-info">
                                <h5>{{$product->from_year}} {{$product->to_year !== null ? " - ".$product->to_year : ""
                                    }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="notes">
                        <!-- <p>Notes:</p> -->
                        <?php 

                        if (isset($product->note) && $product->note != '' && $product->note !== null) {
                            $check_note = @unserialize($product->note);
                            if ($check_note !== false) {
                                $noteArray = unserialize($product->note);
                                $note_data = '<h6>Notes:</h6><ul>';
                                foreach ($noteArray as $j => $v) {
                                    $note = $product->get_note($v);
                                    $note_data .= '<li>'.$note->note.'</li> ';
                                }
                                $note_data .= '</ul>';
                            } else{
                                $note = $product->get_note($product->note);
                                $note_data = '<h6>Notes:</h6><ul> <li> '.$note->note.'</li> </ul>';
                            }
                        } else{
                            $note_data ='';
                        }
                        echo $note_data;
                        ?>
                        <!-- <a href="#">View Product Options</a> -->
                    </div>
                    <div class="caliper">
                        <div class="row rh">
                            <div class="col-md-12">
                                @if($product->drilled_no !== null || $product->type1_no !== null || $product->type3_no
                                !== null || $product->type5_no !== null)
                                <h6>Part Number</h6>
                                @endif
                                <div class="piston-caliper">
                                    <ul>
                                        @if($product->drilled_no !== null)
                                        <li>
                                            <p><span>Drilled:</span> {{$product->drilled_no}}</p>
                                        </li>
                                        @endif
                                        @if($product->type1_no !== null)
                                        <li>
                                            <p><span>Type-1:</span> {{$product->type1_no}}</p>
                                        </li>
                                        @endif
                                        @if($product->type3_no !== null)
                                        <li>
                                            <p><span>Type-3:</span> {{$product->type3_no}}</p>
                                        </li>
                                        @endif
                                        @if($product->type5_no !== null)
                                        <li>
                                            <p><span>Type-5:</span> {{$product->type5_no}}</p>
                                        </li>
                                        @endif
                                    </ul>
                                </div>

                            </div>
                            <div class="col-md-12">
                                @if($product->pistons_caliper !== null)
                                <div class="piston-caliper">
                                    <p><span>Pistons Caliper:</span> {{$product->pistons_caliper}}</p>
                                </div>
                                @endif
                                @if($product->finish_caliper !== null)
                                <div class="piston-caliper">

                                    <?php 

                                    if (isset($product->finish_caliper) && $product->finish_caliper != '' && $product->finish_caliper !== null) {
                                        $check = @unserialize($product->finish_caliper);
                                        if ($check !== false) {
                                            $array = unserialize($product->finish_caliper);
                                            $data = '<p><span>Finish Caliper:</span></p><ul>';
                                            foreach ($array as $key => $value) {
                                                $data .= '<li>'.$value.'</li> ';
                                            }
                                            $data .= '</ul>';
                                        } else{
                                            $data = '<p><span>Finish Caliper:</span></p><ul> <li> '.$product->finish_caliper.'</li> </ul>';
                                        }
                                    } else{
                                        $data ='';
                                    }
                                    echo $data;
                                    ?>
                                </div>
                                @endif
                                @if($product->disc_size_type !== null)
                                <div class="piston-caliper">
                                    <p><span>Disc Size and Type:</span> </p>
                                    <p>{{$product->disc_size_type}}</p>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                    <form id="save_cart" method="POST" action="{{route('save_cart')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                        <div class="product-btn">
                            <div class="row rh">
                                <div class="col-md-12 three-col">
                                    <div class="row">
                                        @if(isset($product->gt_price))
                                        <div class="col-md-4">
                                            <h6>GT Price:</h6>
                                            <input type="radio" id="gt_price" required name="price" class="price_var"
                                                value="{{$product->gt_price}}">
                                            <label class="price_var" for="gt_price">${{$product->gt_price}}</label>
                                        </div>
                                        @endif
                                        @if(isset($product->gts_price))
                                        <div class="col-md-4">
                                            <h6>GTS Price:</h6>
                                            <input type="radio" id="gts_price" required name="price" class="price_var"
                                                value="{{$product->gts_price}}">
                                            <label class="price_var" for="gts_price">${{$product->gts_price}}</label>
                                        </div>
                                        @endif
                                        @if(isset($product->gtr_price))
                                        <div class="col-md-4">
                                            <h6>GTR Price:</h6>
                                            <input type="radio" id="gtr_price" required name="price" class="price_var"
                                                value="{{$product->gtr_price}}">
                                            <label class="price_var" for="gtr_price">${{$product->gtr_price}}</label>
                                        </div>
                                        @endif
                                    </div>




                                    <!-- <label for="quantity">Quantity:</label>
                                        <input type="number" id="quantity" name="quantity" min="1" value="1"> -->
                                    <!-- <div class="product-bttn">
                                        <a href="{{route('cart')}}">View Cart</a>
                                    </div> -->
                                </div>
                                <div class="col-md-6 qty-input">
                                    <label for="quantity">
                                        <h6>Quantity:</h6>
                                    </label>
                                    <input type="number" id="quantity" name="quantity" min="1" value="1">
                                </div>
                                <div class="col-md-6">

                                    <div class="product-bttn">
                                        <button href="#" id="add_to_cart" class="cartt">Add To Cart</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="wishlist">
                        <a href="#"><i class="fa fa-heart" aria-hidden="true"></i>Add to wish List</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row rhhh">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="client-main">
                    <div class="client-img">
                        <img src="{{asset('web/images/client.png')}}" />
                    </div>
                    <div class="client-info">
                        <p>Have a Question? Ask a Specialist</p>
                        <p><a href="#">1234-4568-87</a>Live Chat</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row price-row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="row pricerinr-row">
                    <div class="col-md-6">
                        <div class="price-main">
                            <div class="price-img">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                            </div>
                            <div class="price-info">
                                <p>Low Prices</p>
                                <p>Price match gurantee</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="price-main">
                            <div class="price-img">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </div>
                            <div class="price-info">
                                <p>Guranteed Fitment</p>
                                <p>Always the correct part</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="price-main">
                            <div class="price-img">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="price-info">
                                <p>In-House Expert</p>
                                <p>We know our product</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="price-main">
                            <div class="price-img">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="price-info">
                                <p>Superior Selection</p>
                                <p>Extensive Product Catalog</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row review-roww">

            {{-- <div class="col-md-7">
                <div class="review">
                    <h5>Reviews(0)</h5>
                    <p>
                        Coming Soon
                    </p>
                    <div class="row review-row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="reeview-btn">
                                <a href="#">Write a Review</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="rating-info">
                    <p>{{$company->name}}<sup><i class="fa fa-registered" aria-hidden="true"></i></sup> -
                        {{$product->model}}</p>
                    <div class="row ratingg-row">
                        <div class="col-md-6">
                            <div class="ratingg">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="rating-count">
                                <p>4.8/5</p>
                            </div>
                        </div>
                    </div>
                    <div class="inrmain-rating">
                        <div class="row inrrating-row">
                            <div class="col-md-6">
                                <div class="progress-bar1"></div>
                                <div class="progress-bar2"></div>
                                <div class="progress-bar3"></div>
                                <div class="progress-bar4"></div>
                                <div class="progress-bar5"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="rating1">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                                <div class="rating1 ratings2">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                                <div class="rating1 ratings3">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                                <div class="rating1 ratings4">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                                <div class="rating1 ratings5">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="my-review-form">

                <h3>Write a product review</h3>

                <span>Your Rating<br></span>


                <form method="POST" action="{{route('ratingSubmit')}}">

                    @csrf

                    <input type="hidden" name="product_id" value="{{$product->id}}">

                    {{-- <fieldset class="rate">

                        <input type="radio" id="star1" name="rating_star" value="1">

                        <label class="full" for="star1" title="Worst"></label>

                        <input type="radio" id="star2" name="rating_star" value="2">

                        <label class="full" for="star2" title="Bad"></label>

                        <input type="radio" id="star3" name="rating_star" value="3">

                        <label class="full" for="star3" title="Neutural"></label>

                        <input type="radio" id="star4" name="rating_star" value="4">

                        <label class="full" for="star4" title="Good"></label>

                        <input type="radio" id="star5" name="rating_star" value="5">

                        <label class="full" for="star5" title="Excellent"></label>

                    </fieldset> --}}

                    {{-- <div class="clearfix"></div> --}}


                    <div class="rate"></div>

                    <div class="form-group">

                        <input placeholder="Name" type="text" class="form-control" name="rating_name" value="{{old('rating_name')}}">

                    </div>

                    <div class="form-group">

                        <input placeholder="Email" type="email" class="form-control" name="rating_email" value="{{old('rating_email')}}">

                    </div>

                    <div class="form-group">

                        <textarea cols="30" rows="10" placeholder="Write Review" class="form-control" name="rating_content">{{old('rating_content')}}</textarea>

                    </div>

                    <div class="form-group text-right">

                        <button type="submit" class="btn btn-dark">Post Review</button>

                    </div>

                </form>

            </div>

        </div>



    </div>

</section>

@endif

@if($rating)

<section class="detail-revw">

    <div class="container">

        <div class="detail-revw-ttl">

            <h4>Product Reviews</h4>

        </div>

        <div class="det-scrl">

            @foreach ($rating as $val)

            <div class="det-rev-blk ">

                <?php $avatar_img=strtoupper($val->rating_name[0]).'.svg';?>

                <img src="{{asset('images/icons/avatars/'.$avatar_img)}}" alt="" style=" width: 100px;">

                <div class="det-scnd-bkl">

                    <h4>{{$val->rating_name}} - {{date("d M y H:i" ,strtotime($val->created_at))}}</h4>

                    <p>{{$val->rating_content}}</p>

                    <div class="jstars" data-value="{{ $val->rating_star == 0 ? 0.5 :$val->rating_star }}"
                        data-total-stars="5" data-color="#deb217" data-empty-color="#ccc" data-size="30px">
                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>

@endif

<section class="item-sec">
    <div class="container">
        <h5>Recently viewed Item</h5>
        <div class="itemslider-blk">
            

            @if ($product_recently)

            @foreach ($product_recently as $value)
            <?php $company = $value->get_company($value->company_id); ?>
                <div class="itemslider-main">
                    <div class="item-main">
                        
                        <div class="item-img">
                            <img src="{{asset($value->image)}}" />
                        </div>

                        <div class="item-info">
                            <p>{{ $company->name }}<sup><i class="fa fa-registered" aria-hidden="true"></i></sup></p>
                            <p><span>{{$value->model}}</span></p>
                            <div class="jstars"
                                data-value="{{ $value->ratings_average == 0 ? 0.5 : $value->ratings_average }}"
                                data-total-stars="5"
                                data-color="#deb217"data-empty-color="#ccc"
                                data-size="30px">
                            </div>
                            
                            <div class="price">
                                <p><span>Price: ${{$value->gt_price}} {{$value->gtr_price !== null ? " - $".$value->gtr_price : ($value->gts_price !== null ? " - $".$value->gts_price : "") }}</span></p>
                            </div>
                        </div>

                        <div>
                            <a class="view_details_button" target="_blank" href="{{route('detail',Crypt::encrypt($value->id))}}">View Details</a>
                        </div>

                    </div>
                    
                </div>
                
            @endforeach
                
            @endif
            
            {{-- <div class="itemslider-main">
                <div class="item-main">
                    <div class="item-img">
                        <img src="{{asset('web/images/item1.png')}}" />
                    </div>
                    <div class="item-info">
                        <p>3D MAXpider®</p>
                        <p><span>KAGU Floor Liners</span></p>
                        <div class="item-rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <p>0</p>
                        </div>
                        <div class="select-color">
                            <p></p>
                            <p class="black"></p>
                        </div>
                        <div class="price">
                            <p>$90.99 - $154.96</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="itemslider-main">
                <div class="item-main">
                    <div class="item-img">
                        <img src="{{asset('web/images/item1.png')}}" />
                    </div>
                    <div class="item-info">
                        <p>3D MAXpider®</p>
                        <p><span>KAGU Floor Liners</span></p>
                        <div class="item-rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <p>0</p>
                        </div>
                        <div class="select-color">
                            <p></p>
                            <p class="black"></p>
                        </div>
                        <div class="price">
                            <p>$90.99 - $154.96</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="itemslider-main">
                <div class="item-main">
                    <div class="item-img">
                        <img src="{{asset('web/images/item1.png')}}" />
                    </div>
                    <div class="item-info">
                        <p>3D MAXpider®</p>
                        <p><span>KAGU Floor Liners</span></p>
                        <div class="item-rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <p>0</p>
                        </div>
                        <div class="select-color">
                            <p></p>
                            <p class="black"></p>
                        </div>
                        <div class="price">
                            <p>$90.99 - $154.96</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="itemslider-main">
                <div class="item-main">
                    <div class="item-img">
                        <img src="{{asset('web/images/item1.png')}}" />
                    </div>
                    <div class="item-info">
                        <p>3D MAXpider®</p>
                        <p><span>KAGU Floor Liners</span></p>
                        <div class="item-rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <p>0</p>
                        </div>
                        <div class="select-color">
                            <p></p>
                            <p class="black"></p>
                        </div>
                        <div class="price">
                            <p>$90.99 - $154.96</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="itemslider-main">
                <div class="item-main">
                    <div class="item-img">
                        <img src="{{asset('web/images/item1.png')}}" />
                    </div>
                    <div class="item-info">
                        <p>3D MAXpider®</p>
                        <p><span>KAGU Floor Liners</span></p>
                        <div class="item-rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <p>0</p>
                        </div>
                        <div class="select-color">
                            <p></p>
                            <p class="black"></p>
                        </div>
                        <div class="price">
                            <p>$90.99 - $154.96</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="itemslider-main">
                <div class="item-main">
                    <div class="item-img">
                        <img src="{{asset('web/images/item1.png')}}" />
                    </div>
                    <div class="item-info">
                        <p>3D MAXpider®</p>
                        <p><span>KAGU Floor Liners</span></p>
                        <div class="item-rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <p>0</p>
                        </div>
                        <div class="select-color">
                            <p></p>
                            <p class="black"></p>
                        </div>
                        <div class="price">
                            <p>$90.99 - $154.96</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="itemslider-main">
                <div class="item-main">
                    <div class="item-img">
                        <img src="{{asset('web/images/item1.png')}}" />
                    </div>
                    <div class="item-info">
                        <p>3D MAXpider®</p>
                        <p><span>KAGU Floor Liners</span></p>
                        <div class="item-rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <p>0</p>
                        </div>
                        <div class="select-color">
                            <p></p>
                            <p class="black"></p>
                        </div>
                        <div class="price">
                            <p>$90.99 - $154.96</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="itemslider-main">
                <div class="item-main">
                    <div class="item-img">
                        <img src="{{asset('web/images/item1.png')}}" />
                    </div>
                    <div class="item-info">
                        <p>3D MAXpider®</p>
                        <p><span>KAGU Floor Liners</span></p>
                        <div class="item-rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <p>0</p>
                        </div>
                        <div class="select-color">
                            <p></p>
                            <p class="black"></p>
                        </div>
                        <div class="price">
                            <p>$90.99 - $154.96</p>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
</section>
@endsection
@section('js')
<script type="text/javascript">
// $("#add_to_cart").click(function (e) {
//     $("#save_cart").submit();
// })

    $('.rate').addRating({
        fieldName : 'rating_star',
        fieldId : 'rating_star',
    });

</script>
@endsection
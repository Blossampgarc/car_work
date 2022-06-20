@extends('shop.layouts.main')
@section('content')
<!-- Header End -->
<!-- breadcrumb  -->
<div class="cart-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul>
                    <li><a href="{{route('welcome')}}">Home /</a></li>
                    <li><a href="#">Apparel /</a></li>
                    <li><a href="#">Men /</a></li>
                    <li><a href="#" class="active">{{$product->name}}</a></li>
                    <li><a href="{{route('get_cart')}}" class="">View Cart</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End  -->
<!-- main-container  -->
<div class="our-cart-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="laptop-slider">
                    <div class="items">
                        <img src="{{asset($product->picture)}}" />
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h1 id="pricediv">{{$product->name}}</h1>
                <p id="price">${{$product->tagprice}}</p>
                <div class="add-to-cart">
                    <form class="" id="" method="POST" enctype="multipart/form-data" action="{{route('save_cart')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" />
                        <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}" />
                        <input type="number" min="1" max="{{$product->stock}}" value="1" name="qty" id="qty" />
                        <span>
                            <button type="button" id="cart_submit" class="btn add-cart">Add to cart</button>
                        </span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="desc-tab">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"> Description</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                {!!$product->desc!!}
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript">
    $("#cart_submit").click(function(){
        var product_id = $("#product_id").val();
        var qty = $("#qty").val();
        console.log(product_id);
        console.log(qty);
        $.ajax({
            type: 'post',
            dataType : 'json',
            url: "{{route('save_cart')}}",        
            data: {product_id:product_id, qty:qty, _token: '{{csrf_token()}}'},
            success: function (response) {
                if (response.status == 0) {
                    toastr.error(response.message);
                }else{
                    location.reload();
                    toastr.success(response.message);
                }
            }
        });
    })
    {{--
    $(document).ready(function () {
        var total = "{{count($var)}}";
        var product_id = "{{$product->id}}";
        console.log(product_id);
        var type = [];
        var onchange = 0
        $(".change").change(function(){
            if($(this).find(":selected").val() != ""){ 
                type[onchange] = $(this).find(":selected").val();
                onchange++;
            }
            if(total  == onchange){
                console.log(type);
                $.ajax({
                    type : 'POST',
                    dataType : 'JSON',
                    url: "{{route('pricing')}}",
                    data: {product_id:product_id, type:type, _token:"{{csrf_token()}}"},
                    success: function (response) {
                        if (response.status == 1) {
                            $("#price").remove();
                            alert(response.message);
                            // $(response.message).insertAfter("#pricediv");
                        }
                    }
                });
            } 
        })

        // product id..
        // size..
        // colour..
        // productid+colour value = product list id
        // product list id->price
        // $('#categoryid').bind('change', function() {
        //     var value = $('#categoryid :selected').val();
        //     $.ajax({
        //         type : 'POST',
        //         dataType : 'JSON',
        //         url: "{{route('variation')}}",
        //         data: {id:value, _token:"{{csrf_token()}}"},
        //         success: function (response) {
        //             if (response.status == 1) {
        //                 $("#varlist").remove();
        //                 $("#repeted").append(response.message);
        //             }
        //         }
        //     });
        // });
    });
    --}}
</script>
@endsection 

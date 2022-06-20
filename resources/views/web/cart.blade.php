@extends('web.layouts.main') @section('content')
<section class="Inner_content Cart_sec">
    <div class="container">
        <div class="login-title">
            <h3>Cart</h3>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-9 wow fadeInLeft" data-wow-delay="1s">
                <div class="carttable">
                    <div class="table-responsive">
                        <div class="ex"></div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Product</th>
                                    <th>Item Price</th>
                                    <th class="text-center">QTY</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form action="{{route('update_cart')}}" method="POST" id="update_cart">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                @php
                                $price = 0;
                                @endphp
                                @if($cart !== [])
                                @foreach($cart as $val)

                                @php
                                $product = App\Models\car_details::get_product($val['product_id']);
                                $company = $product->get_company($product->company_id);
                                $price = $price + ($val['price']*$val['quantity']);
                                @endphp
                                <tr>
                                    <td>
                                        <ul class="list-inline list-unstyled cart-list">
                                            <li>
                                                <div class="cartimage"><img alt="" class="img-responsive" src="{{asset($product->image)}}" /></div>
                                            </li>
                                            <li>
                                                <h4>{{$company->name}}</h4>
                                                <h4>{{$product->model}}</h4>
                                                <div class="clearfix"></div>
                                                <ul class="edit">
                                                    <!-- <li>
                                                        <a href="#">Edit</a>
                                                    </li> -->
                                                    <li>
                                                        <a class="remove_cart" data-product_id="{{$val['product_id']}}" data-price="{{$val['price']}}">Remove</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <br />
                                        <br />
                                        ${{$val['price']}}
                                    </td>
                                    <td class="counter">
                                        <div class="qty">
                                            <span class="minus bg-dark">-</span>
                                            <input type="number" name="quantity[]" class="count" value="{{$val['quantity']}}">

                                            <input type="hidden" name="product_id[]" value="{{$val['product_id']}}">
                                            <input type="hidden" name="price[]" value="{{$val['price']}}">
                                            <span class="plus bg-dark">+</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <br />
                                        <br />
                                        ${{($val['price'])*($val['quantity'])}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button class="btnStyle update" id="update">Update Bag</button>
                <a class="btnStyle con-shop" href="{{route('product')}}">Continue Shopping</a>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-md-6 sub-total-sec">
                    <ul class="list-group">
                        <!-- <li class="list-group-item">Subtotal <a class="pull-right" href="#">$ 99.00</a></li> -->
                        <li class="list-group-item">Total <a class="pull-right" href="#">${{$price}}</a></li>
                    </ul>
                    <a class="btnStyle con-chk" href="{{route('checkout')}}">Continue To Checkout</a>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="shipping">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="right_box">
                                <h5>NEED HELP ?</h5>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <a class="call" href="#">123 456 7890</a>
                                <p>Lorem Ipsum is simply</p>
                            </div>
                            <div class="right_box">
                                <div class="title-sec">
                                    <h5>SECURE SHOPPING</h5>
                                    <img alt="" class="img-responsive" src="{{asset('web/images/paypal.png')}}" />
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script type="text/javascript">
    $(".plus").click(function(){
        var element = $(this).closest(".qty").find(".count");
        element.val(parseInt(element.val()) + 1 )
        // $('.count').val(parseInt($('.count').val()) + 1 );
        
    });
    $(".minus").click(function(){
        var element = $(this).closest(".qty").find(".count");
        element.val(parseInt(element.val()) - 1 )
        // $('.count').val(parseInt($('.count').val()) - 1 );
        if (element.val() == 0) {
            element.val(1);
        }
    });
    $(".remove_cart").click(function(){
        var product_id = $(this).data("product_id")
        var price = $(this).data("price")
        console.log(product_id,price)
        $.ajax({
            type: 'post',
            dataType : 'json',
            url: "{{route('remove_cart')}}",
            data: {product_id:product_id, price:price, _token: '{{csrf_token()}}'},
            success: function (response) {
                if (response.status == 0) {
                    toastr.error(response.message);
                }else{
                    toastr.warning(response.message);
                    location.reload();
                }
            }
        });
    })
    $("#update").click(function(){
        // console.log("here");
        $("#update_cart").submit();
    })
</script>

@endsection

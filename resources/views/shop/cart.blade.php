@extends('shop.layouts.main')
@section('content')
<!-- Header End -->
<section class="view-cart">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="cart-vi">
                    <table>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                        <form class="" id="" method="POST" enctype="multipart/form-data" action="{{route('save_cart')}}">
                        @foreach ($cart_arr as $cart)
                        <tr class="cart_table">
                            <td>
                                <button id="" class="fa fa-times remove_cart" aria-hidden="true" data-product_id = "{{$cart['product_id']}}">
                                    <!-- <i class="fa fa-times" aria-hidden="true"></i> -->
                                </button>
                            </td>
                            <td>
                                <a href="#"><img src="{{asset($cart['image'])}}" /></a>
                            </td>
                            <td><a href="#">{{$cart['name']}}</a></td>
                            <td>${{$cart['price']}}</td>
                            <td>
                                <input type="hidden" name="product_id[]" class="product_id" value="{{$cart['product_id']}}" />
                                <input type="number" min="1" max="{{$cart['stock']}}" value="{{$cart['qty']}}" name="qty[]" class="qty" />
                            </td>
                            <td>${{$cart['subtotal']}}</td>
                        </tr>
                        @endforeach
                        </form>
                    </table>
                    <div class="cart-coupon">
                        <!-- <input type="text" name="" /> <a class="coupon res-btn" href="#">Apply Coupon</a> -->
                        <a class="update res-btn" id="update_cart" href="#">Update Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="cart-totals">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="ct">
                    <div class="ct-heading">
                        <h3>Cart totals</h3>
                    </div>
                    <table>
                        <tr>
                            <td>Subtotal</td>
                            <td>${{$cost}}</td>
                        </tr>
                        <tr>
                            <td>Tax</td>
                            <td>$0.00</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>${{$cost}}</td>
                        </tr>
                    </table>
                    <div class="proceed">
                        <a class="res-btn" href="{{route('checkout')}}">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-pagination">
    @include('web.layouts.products')
</section>
@endsection
@section('js')
<script type="text/javascript">
    $(".remove_cart").click(function(){
        var product_id = $(this).data("product_id");
        $.ajax({
            type: 'post',
            dataType : 'json',
            url: "{{route('remove_cart')}}",        
            data: {product_id:product_id, _token: '{{csrf_token()}}'},
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
    $("#update_cart").click(function(){
        var product_id = $("input[name='product_id[]']").map(function(){return $(this).val();}).get();
        var qty = $("input[name='qty[]']").map(function(){return $(this).val();}).get();
        console.log(product_id);
        console.log(qty);
        $.ajax({
            type: 'post',
            dataType : 'json',
            url: "{{route('update_cart')}}",        
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
</script>
@endsection

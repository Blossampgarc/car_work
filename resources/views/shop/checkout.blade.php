@extends('shop.layouts.main')
@section('content')
<!-- Header End -->
<section class="checkout-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="returning-customer">
                    <p><i class="fa fa-window-maximize" aria-hidden="true"></i>Returning customer?<a href="#">Click here to login</a></p>
                </div>
                <div class="have-coupon">
                    <p><i class="fa fa-window-maximize" aria-hidden="true"></i>Have a coupon?<a href="#">Click here to enter your code</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="addform">
    <div class="container-fluid">
        <form  class="" id="register_customer" method="POST" enctype="multipart/form-data" action="{{route('register_customer')}}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="add-heading">
                        <h3>Billing details</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="add-fname">
                                <label>First name *</label>
                                <input type="text" name="fname" id="fname" value="{{ old('fname') }}" required="required" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="add-lname">
                                <label>Last name *</label>
                                <input type="text" name="lname" id="lname" value="{{ old('lname') }}" required="required" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="add-company">
                                <label>Company name (optional)</label>
                                <input type="text" value="{{ old('companyname') }}" name="companyname"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="add-country">
                                <label>Country / Region *</label>
                                <select name="country" id="cars" required="required" required>
                                    <option selected="true" disabled="disabled">Select Country/Region</option>
                                    @foreach ($country as $cnt)
                                    {{ $id = $cnt->id }}
                                    <option value="{{$cnt->id}}" {{ old('country') == $id ? 'selected' : ' ' }}>{{$cnt->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="add-address">
                                <label>Street address *</label>
                                <input type="text" value="{{ old('address') }}" name="address" placeholder="House number and street name" required="required" required/>
                                <input type="text" value="{{ old('otheraddress') }}" name="otheraddress" placeholder="Apartment, suite, unit, etc. (optional)" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="town">
                                <label>Town / City *</label>
                                <input type="text" name="city" value="{{ old('city') }}" required="required" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="state">
                                <label>State / County *</label>
                                <input type="text" name="state" value="{{ old('state') }}" required="required" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="postal">
                                <label>Postcode / ZIP *</label>
                                <input type="text" name="zip" value="{{ old('zip') }}" required="required" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="phone">
                                <label>Phone *</label>
                                <input type="phone" name="phone" value="{{ old('phone') }}" requ
                                ired="required" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="email">
                                <label>Email address *</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required="required" required/>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="account-user">
                                <label>Account username *</label>
                                <input type="text" name="accountusername" value="{{ old('accountusername') }}" placeholder="Username" required="required" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="password">
                                <label>Create account password *</label>
                                <input type="password" name="password" class="validate @error('password') is-invalid @enderror" placeholder="Password" required="required" required/>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="add-ship-address">
                        <h3><input type="checkbox" id="checkbox" value="{{ old('ship_check') }}" name="ship_check"/>Ship to a different address?</h3>
                    </div>
                    <div id="ship_address">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="add-fname">
                                    <label>First name *</label>
                                    <input type="text" name="ship_fname" value="{{ old('ship_fname') }}" required="required" required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="add-lname">
                                    <label>Last name *</label>
                                    <input type="text" name="ship_lname" value="{{ old('ship_lname') }}" required="required" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="add-company">
                                    <label>Company name (optional)</label>
                                    <input type="text" value="{{ old('ship_company') }}" name="ship_company" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="add-country">
                                    <label>Country / Region *</label>
                                    <select name="ship_country" id="cars">
                                        <option selected="true" disabled="disabled">Select Country/Region</option>
                                        @foreach ($country as $cnt)
                                        {{ $id = $cnt->id }}
                                        <option value="{{$cnt->id}}" {{ old('country') == $id ? 'selected' : ' ' }}>{{$cnt->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="add-address">
                                    <label>Street address *</label>
                                    <input type="text" value="{{ old('ship_address') }}" name="ship_address" placeholder="House number and street name" required="required" required/>
                                    <input type="text" value="{{ old('ship_otheraddress') }}" name="ship_otheraddress" placeholder="Apartment, suite, unit, etc. (optional)" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="town">
                                    <label>Town / City *</label>
                                    <input type="text" value="{{ old('ship_city') }}" name="ship_city" required="required" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="state">
                                    <label>State / County *</label>
                                    <input type="text" value="{{ old('ship_state') }}" name="ship_state" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="postal">
                                    <label>Postcode / ZIP *</label>
                                    <input type="text" value="{{ old('ship_zip') }}" name="ship_zip" required="required" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="phone">
                                    <label>Phone (optional)</label>
                                    <input type="phone" value="{{ old('ship_phone') }}" name="ship_phone" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="other-note">
                                    <label>Order notes (optional)</label>
                                    <textarea value="{{ old('ship_othernotes') }}" name="ship_othernotes"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="your-order">
                <div class="container-fluid">
                    <div class="row">
                        <div class="add-table">
                            <h3>Your order</h3>
                            <table>
                                <tr>
                                    <th>Product</th>
                                    <th>Subtotal</th>
                                </tr>
                                <tr>
                                    <td>BB Mens TriBlend T-Shirt - Premium Heather, Large × 2</td>
                                    <td>$45.98</td>
                                </tr>
                                <tr>
                                    <td>Subtotal</td>
                                    <td>$45.98</td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>$50.98</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button class="checkout">Checkout</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <!-- <section class="online-card">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="paypal">
                                <input type="radio" id="paypal" class="order" name="order"  value="paypal"
                                /><span>PayPal <img src="{{asset('web/img/card.jpg')}}" /><a href="#">What is PayPal?</a></span>
                            </div>
                            <div class="paypal-content">
                                <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-stripe"><input type="radio" id="credit_card"  class="order checkout-class" name="order" value="credit_card" /><span>Credit Card (Stripe)</span></div>
                            <div class="fill-card" id="cardcheckout_form">
                                <h5>Pay with your credit card via Stripe.</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="cnic-num">
                                            <label>Card Number *</label>
                                            <input type="text" name="cardnumber" placeholder="1234 1234 1234 1234" /><span><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="expiry-date">
                                            <label>Expiry Date *</label>
                                            <input type="text" name="expirydate" placeholder="MM/YY" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-code">
                                            <label>Card Code (CVC) *</label>
                                            <input type="text" name="card-code" placeholder="CVC" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="privacy">
                                <p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="#">privacy policy</a> .</p>
                            </div>
                        </div>
                        <div class="col-md-4 cardcheckout_button">
                            <button class="checkout">Place Order</button>
                        </div>
                        <div class="col-md-4 paypalcheckout_button">
                            <button class="checkout">Proceed to PayPal</button>
                        </div>
                    </div>
                </div>
            </section> -->
        </form>
        <section class="product-pagination">
            @include('web.layouts.products')
        </section>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript">
    $(function(ready){
        var element = $("#ship_address").html();
        $("#ship_address").remove();
        $("#checkbox").change(function() {
            if(this.checked) {
                $("<div id='ship_address'>"+element+"</div>").insertAfter(".add-ship-address")
                console.log("checked");
            } else{
                $("#ship_address").remove();
            }
        });



        // $("#paypal").prop("checked", true);
        // var cardform = $("#cardcheckout_form").html();
        // var cardbutton = $(".cardcheckout_button").html();
        // var paypalbutton = $(".paypalcheckout_button").html();
        // $("#cardcheckout_form").remove();
        // $(".cardcheckout_button").remove();

        // $(document).on('change','.order',function(){
        //     if($('#credit_card').is(':checked')) {
        //         $(".paypalcheckout_button").remove();
        //         $("<div class='col-md-4 cardcheckout_button'>"+cardbutton+"</div>").insertAfter(".privacy");
        //         $("<div class='fill-card' id='cardcheckout_form'>"+cardform+"</div>").insertAfter(".card-stripe");
        //     } else {
        //         $("#cardcheckout_form").remove();
        //         $(".cardcheckout_button").remove();
        //         $("<div class='col-md-4 paypalcheckout_button'>"+paypalbutton+"</div>").insertAfter(".privacy");
        //     }
        // })
        
    })
</script>
@endsection
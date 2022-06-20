@extends('web.layouts.main')
@section('content')
<!-- Header End -->
<section class="banner-sec">
    <div class="banner-img">
        <img src="{{asset('web/images/inrbanner.png')}}" />
        <div class="banner-info">
            <h5>ACCOUNT</h5>
        </div>
    </div>
</section>
<section class="account-sec">
    <div class="container">
        <div class="row">
            <div class="form-blk">
                <div class="col-md-6">
                    <div class="login-form">
                        <form method="POST" action="{{route('login')}}" autocomplete="off">
                            @csrf
                            <h5>Log In</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="login-input">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                                        @error('email')
                                          <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="login-input">
                                        <input type="password" class="form-control validate @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="Password"  name="password" required autocomplete="current-password"/>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="login-btn">
                                        <button>log In</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="login-info">
                                        <p>Lorem Ipsum is simply dummy text of the more then theprinting and typesetting industry.</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="login-form login-formm">
                        <form>
                            <h5>Sign Up</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="login-input">
                                        <input type="text" placeholder="Email Adrress" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="login-input">
                                        <input type="text" placeholder="Password" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="login-input">
                                        <input type="text" placeholder="Renter Password" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="login-btn">
                                        <button>log In</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
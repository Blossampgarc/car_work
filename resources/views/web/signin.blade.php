@extends('web.layouts.main')
@section('content')
<section class="login-sec">
    <div class="container">
        <div class="user-login">
            <div class="login-head">
                <h4>Log In To Your Account</h4>
            </div>
            <div class="login-form">
                <form method="POST" action="{{route('login')}}" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                        @error('email')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control validate @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="Password"  name="password" required autocomplete="current-password"/>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="user-button">
                        <button>Log In</button>
                    </div>
                </form>
                <div class="row rhhh">
                    <div class="col-md-6">
                        <div class="forget-pass">
                            <a href="{{route('microsoft_signin')}}">Sign in using Microsoft</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="forget-pass">
                            <a href="#">Forget Password</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="account">
                            <a href="#">Don't Have an Account?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{332321258945251}',
      cookie     : true,
      xfbml      : true,
      version    : '{api-version}'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
@endsection
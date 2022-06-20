@extends('layouts.main')
@section('content')    
<main>
            <div class="container-fluid site-width">
                <!-- START: Breadcrumbs-->
                <div class="row ">
                    <div class="col-12  align-self-center">
                        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                            <div class="w-sm-100 mr-auto"><span class="h4 my-auto">Update Password</span></div>

                            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                <li class="breadcrumb-item">User</li>
                                <li class="breadcrumb-item active"><a href="#">Profile</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- END: Breadcrumbs-->

                <!-- START: Card Data-->
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="position-relative">
                            <div class="background-image-maker py-5"></div>
                            <div class="holder-image">
                                <img src="{{asset('images/portfolio13.jpg')}}" alt="" class="img-fluid d-none">
                            </div>
                            <div class="position-relative px-3 py-5">
                                <div class="media d-md-flex d-block">
                                    @if($user->profile_pic != "")
                                    @php $path = $user->profile_pic; @endphp
                                    @else
                                    @php $path = "images/no-img.png"; @endphp
                                    @endif
                                    <img src="{{asset($path)}}" width="100" alt="{{$user->name}}" class="img-fluid rounded-circle" id="blah">
                                    <div class="media-body z-index-1">
                                        <div class="pl-4">
                                            <h1 class="display-4 text-uppercase text-white mb-0">{{$user->name}}</h1>
                                            <h6 class="text-uppercase text-white mb-0">Created at: {{$user->created_at->diffForHumans()}}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                            @if ($message = Session::get('success'))
                                            <div class="alert alert-success alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @endif
                                            <form class="needs-validation" novalidate method="POST" action="{{route('user_passwordupdate')}}" enctype="multipart/form-data" id="form-image-upload">
                                            @csrf
                                                <div class="form-row">
                                                    <div class="col-md-2 mb-3" ></div>
                                                    <div class="col-md-8 mb-3" >
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label for="old_password">Old Password</label>
                                                                <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password" value="" required>
                                                                <div class="valid-feedback">
                                                                    Looks good!
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="new_password">New Password</label>
                                                                <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" value="" required>
                                                                <div class="valid-feedback">
                                                                    Looks good!
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="confirm_password">Confirm Password</label>
                                                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" value="" required>
                                                                <div class="valid-feedback">
                                                                    Looks good!
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-primary" type="submit">Submit form</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                
                <div class="row mt-3"></div>
                <!-- END: Card DATA-->
            </div>
</main>
@endsection

@section('css')
<style type="text/css">
    
</style>
@endsection

@section('js')
<script>

    $('document').ready(function(){
        $('#blah').click(function(){ 
            $('#upload-img').trigger('click'); 
        });    
    });
    
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
          $('#blah').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }
    $("#upload-img").change(function() {
      $("#heading_upload").hide();
      readURL(this);
    });
    
    $("#upload-img").change(function(e) {
        var val = $(this).val();
        if (val.match(/(?:gif|jpg|png|bmp)$/)) {
            if (confirm('Do you really want to change your profile image?')) {
                $("#form-image-upload").submit();
            } else {
                alert('No image has been updated');
            }
        }
    });
    
    
</script>
@endsection
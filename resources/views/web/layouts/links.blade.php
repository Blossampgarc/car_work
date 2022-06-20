

<?php $logo = App\Models\logo::where('is_active',1)->orderBy('id','desc')->first(); ?>
@if($logo)
@php $path = $logo->image; @endphp
@else
@php $path = "web/images/logo.png"; @endphp
@endif

<link rel="icon" type="image/x-icon" href="{{asset($path)}}">

<link rel="icon" href="#" />
<link rel="stylesheet" href="{{asset('web/css/custom.css')}}">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> --}}
<link rel="stylesheet" href="{{asset('web/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('web/css/slick.css')}}">
<link rel="stylesheet" href="{{asset('web/css/slick-theme.css')}}">
<link rel="stylesheet" href="{{asset('web/css/fancybox.min.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@yield('link')

	


<?php $logo = App\Models\logo::where('is_active',1)->orderBy('id','desc')->first(); ?>
@if($logo)
@php $path = $logo->image; @endphp
@else
@php $path = "web/images/logo.png"; @endphp
@endif




<link rel="icon" type="image/x-icon" href="{{asset($path)}}">
<!-- <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" /> -->
<link rel="stylesheet" href="{{asset('vendors/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('vendors/jquery-ui/jquery-ui.min.css')}}">
<link rel="stylesheet" href="{{asset('vendors/jquery-ui/jquery-ui.theme.min.css')}}">
@auth
<link rel="stylesheet" href="{{asset('vendors/simple-line-icons/css/simple-line-icons.css')}}">        
<link rel="stylesheet" href="{{asset('vendors/flags-icon/css/flag-icon.min.css')}}">         
<link rel="stylesheet" href="{{asset('vendors/cryptofont/cryptofont.css')}}">         
<!-- END Template CSS-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- START: Page CSS-->
<link rel="stylesheet"  href="{{asset('vendors/chartjs/Chart.min.css')}}">
<!-- END: Page CSS-->

<!-- START: Page CSS-->   
<link rel="stylesheet" href="{{asset('vendors/morris/morris.css')}}"> 
<link rel="stylesheet" href="{{asset('vendors/weather-icons/css/pe-icon-set-weather.min.css')}}"> 
<link rel="stylesheet" href="{{asset('vendors/chartjs/Chart.min.css')}}"> 
<link rel="stylesheet" href="{{asset('vendors/starrr/starrr.css')}}"> 
<link rel="stylesheet" href="{{asset('vendors/fontawesome/css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('vendors/ionicons/css/ionicons.min.css')}}"> 
<link rel="stylesheet" href="{{asset('vendors/jquery-jvectormap/jquery-jvectormap-2.0.3.css')}}">

<link rel="stylesheet" href="{{asset('vendors/jsgrid/jsgrid.min.css')}}" />
<link rel="stylesheet" href="{{asset('vendors/jsgrid/jsgrid-theme.css')}}" />

@if(Auth::user()->role_id == 1)
  @if(!Session::has('project_id'))
  <!-- <style type="text/css">
    .main-body{
      filter: blur(6px);
      overflow: hidden;
    }
  </style> -->
  @endif
@endif

@endauth
<!-- END: Page CSS-->
<link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- START: Custom CSS-->
<link rel="stylesheet" href="{{asset('css/main.css')}}">



@yield('link')
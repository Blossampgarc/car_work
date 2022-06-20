@extends('layouts.main') 
@section('content')
 <main>
            <div class="container-fluid site-width">
                <!-- START: Breadcrumbs-->
                <div class="row">
                    <div class="col-12  align-self-center">
                        <div class="sub-header mt-3 py-3 px-md-0 align-self-center d-sm-flex w-100 rounded">
                            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Dashboard</h4> <p>Welcome to admin panel</p>
                               <!--  <a href="#" class="btn btn-primary">Get Started <i class="fas fa-arrow-right"></i></a>  -->
                            </div>
                            <div class="card border-bottom-0 mt-3 mt-sm-0">                            
                                <div class="card-content border-bottom border-primary border-w-5">
                                    <div class="card-body p-4">
                                        <span class="mb-0 font-w-600 text-primary">Income balance</span><br>
                                        <p class="mb-0 font-w-500 tx-s-12">${{number_format($balance , 2)}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Breadcrumbs-->             
            </div>
        </main>
@endsection
@section('css') 
@endsection 
@section('js') 
<script></script>
@endsection
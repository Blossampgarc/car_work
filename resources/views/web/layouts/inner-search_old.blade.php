<?php
use App\Models\company;
use App\Models\car_details;
$years = car_details::where('is_active',1)->groupBy('from_year')->pluck('from_year');
$company = company::where('is_active',1)->where('is_deleted',0)->orderBy('name', 'asc')->get();
$models = car_details::where('is_active',1)->groupBy('model')->pluck('model');
?>
<div class="car-cls">
    <form action="{{route('search_detail')}}" method="GET">
        <div class="banner-search">
            <select class="custom-select" id="year_datalist" name="year">
           </select>
        </div>
        <div class="banner-search">
            <select class="custom-select" id="make_datalist" name="make">
           </select>
        </div>
        <div class="banner-search">
            <input type="text" list="model_datalist" id="search_job" autofocus name="model" placeholder="Model" />
            <datalist id="model_datalist">
            </datalist>
        </div>
        <div class="banner-search">
            <div class="form-filter">
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </form>
        <div class="banner-search">
            <div class="form">
                <form action="{{route('search_text')}}" method="GET">
                    <input type="text" name="text"  placeholder="Search By Parts# or Keyword" />
                    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
                </div>
            </div>
        </div>
    
</div>
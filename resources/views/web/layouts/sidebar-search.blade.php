<?php
use App\Models\car_details;
$years = car_details::where('is_active',1)->groupBy('from_year')->pluck('from_year');
?>
<div class="side-options">
    <div class="select-vehicle">
        <h3>SELECT YOUR VEHICLE</h3>
        <p>Dinterdum pretium an dapboe dan mauris condimentus.</p>
        <form action="{{route('search_detail')}}" method="GET">
            <input type="text" list="year-side" id="year-search-side" autofocus name="year" placeholder="Year" />
            <datalist id="year-side">
                @foreach($years as $year)
                <option value="{{$year}}">
                </option>
                @endforeach
            </datalist>


            <input type="text" list="make-side" id="make-search-side" autofocus name="make" placeholder="Make" />
            <datalist id="make-side">
            </datalist>


            <input type="text" list="model-side" id="searcha-job-side" autofocus name="model" placeholder="Model" />
            <datalist id="model-side">
            </datalist>
            <!-- <input type="text" name="" placeholder="Select level 1..." />
            <input type="text" name="" placeholder="Select level 1..." />
            <input type="text" name="" placeholder="Select level 1..." /> -->
            <button type="submit">BROWSE</button>
            <a href="#"><i class="fa fa-refresh" aria-hidden="true"></i>Reset</a>
        </form>
    </div>
</div>
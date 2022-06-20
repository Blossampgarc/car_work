<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\new_feeds;

class ApiFeedsController extends Controller
{
    public function forex_trackr()
    {
    	// Cron job code start
		$cSession = curl_init();
		curl_setopt($cSession,CURLOPT_URL,"https://fcsapi.com/api-v3/forex/latest?symbol=EUR/USD,USD/JPY,GBP/CHF&access_key=i8vE45NMdeQzWnF4V0iF");
		curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($cSession,CURLOPT_HEADER, false);
		$result=curl_exec($cSession);
		curl_close($cSession);
		$output = json_decode($result ,1);
		
		// Cron job code end

		if ($output['status'] && $output['code'] == 200) {
			$new_feeds_update = new_feeds::where("is_active" , 1)->where("is_deleted" , 0)->update([
				'is_active' => '0',
				'is_deleted' => '1'
			]);
			$new_feeds = new_feeds::create(['resp_data' => serialize($output)]);
			echo "New Feeds uploaded";
		}
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_detail extends Model
{
    protected $primaryKey = 'id';
  	protected $table = 'order_detail';
    protected $guarded = [];
    
    public function get_product($id){
    	return car_details::where('is_active',1)->where('is_deleted',0)->where('id',$id)->first();
    }
}
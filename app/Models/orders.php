<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $primaryKey = 'id';
  	protected $table = 'orders';
    protected $guarded = [];


    public function get_order($id){
    	return orders::where('is_active',1)->where('is_deleted',0)->where('id',$id)->first();
    }
    public function get_order_details($id){
    	return order_detail::where('is_active',1)->where('is_deleted',0)->where('order_id',$id)->get();
    }
    public function get_user($id)
    {
    	return User::where('is_active',1)->where('is_deleted',0)->where('id',$id)->first();
    }
    public function get_product($id)
    {
    	return car_details::where('is_active',1)->where('is_deleted',0)->where('id',$id)->first();
    }
}
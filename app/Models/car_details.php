<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class car_details extends Model
{
  protected $primaryKey = 'id';
  protected $table = 'car_details';
  protected $guarded = [];

  public function get_company($id)
  {
    return company::where('is_active', 1)->where('id', $id)->first();
  }

  public function get_note($id)
  {
    return note::where('is_active', 1)->where('is_deleted', 0)->where('note_no', $id)->orderBy('id', 'desc')->first();
  }

  public function get_product($id)
  {
    return car_details::where('is_active', 1)->where('is_deleted', 0)->where('id', $id)->first();
  }

  public function get_sale()
  {
    return car_details::where('is_active', 1)->where('is_deleted', 0)->where('is_sale', 1)->get();
  }

  public function check_sale($datetime2, $id)
  {
    return car_sale::where('is_active', 1)->where('product_id', $id)->where('start_date', '<=', $datetime2)->where('end_date', '>=', $datetime2)->first();
  }

  public function getsubcategory($id)
  {
    return subcategory::where('is_active', 1)->where('id', $id)->first();
  }

  public function getcategory($id)
  {
    return category::where('is_active', 1)->where('id', $id)->first();
  }
  
}

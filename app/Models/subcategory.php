<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{
    protected $primaryKey = 'id';
  	protected $table = 'subcategory';
    protected $guarded = [];


    public function car_details_count($id)
    {
      return car_details::where('is_active', 1)->where('is_deleted', 0)->where('subcategory_id', $id)->count();
    }

}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $primaryKey = 'id';
  	protected $table = 'category';
    protected $guarded = [];


    public function subCategoryCount($id,$accessories_id)
    {
      return subcategory::where('is_active', 1)->where('is_deleted', 0)->where('category_id', $id)->where('accessories_id', $accessories_id)->count();
    }

}
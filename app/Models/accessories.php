<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accessories extends Model
{
    protected $primaryKey = 'id';
  	protected $table = 'accessories';
    protected $guarded = [];

    public function get_accessories(){
    	return accessories::where('is_active',1)->where('is_deleted',0)->get();
    }
}
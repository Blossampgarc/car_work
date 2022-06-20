<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class config extends Model
{
 	protected $primaryKey = 'id';
  	protected $table = 'config';
    protected $guarded = [];  

    public function get_email(){
    	return config::where('is_active',1)->where('type','emailaddress')->first();
    }
    public function get_contact(){
    	return config::where('is_active',1)->where('type','contactnumber')->first();
    }
}

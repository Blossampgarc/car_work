<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ads extends Model
{
    protected $primaryKey = 'id';
  	protected $table = 'ads';
    protected $guarded = [];
}
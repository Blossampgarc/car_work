<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Bulk extends Model
{
    protected $table = 'bulk';
    protected $fillable = [
        'name', 'email',
    ];
}
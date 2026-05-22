<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
     use SoftDeletes;
     
    protected $table = "children";
    protected $fillable = [
        'lead_id',
        'name',
        'gender',
        'birth_date'
    ];
}

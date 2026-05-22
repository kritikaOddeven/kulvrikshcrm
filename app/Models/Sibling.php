<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Sibling extends Model
{

     use SoftDeletes;

    protected $fillable = ['lead_id',
        'belongs_to',
        'relation',
        'name',
        'birth_date',
        'death_date',
    ];
}

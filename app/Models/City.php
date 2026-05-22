<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'state_id',
    ];

    public $timestamps = false; 

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function talukas()
    {
        return $this->hasMany(Taluka::class, 'city_id', 'id');
    }
    
}

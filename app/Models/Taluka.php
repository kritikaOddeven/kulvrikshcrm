<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taluka extends Model
{
    protected $fillable = [
        'name',
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class, 'taluka_id', 'id');
    }
    
}

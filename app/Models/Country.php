<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'phonecode',
    ];
    public $timestamps = false;

    public function states()
{
    return $this->hasMany(State::class, 'country_id', 'id');
}

}

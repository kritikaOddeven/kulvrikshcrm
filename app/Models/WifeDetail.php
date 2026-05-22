<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class WifeDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'lead_id',
        'first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'marriage_date',
        'death_date',
        'phone',
        'phonecode',
        'email',
        'country',
        'state',
        'district',
        'city',
        'taluka',
        'village',
        'address',
    ];

    public function countries()
    {
        return $this->hasOne(Country::class, 'id', 'country');
    }

    public function states()
    {
        return $this->hasOne(State::class, 'id', 'state');
    }

    public function cities()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

     public function districts()
    {
        return $this->hasOne(District::class, 'id', 'district');
    }
    public function talukas()
    {
        return $this->hasOne(Taluka::class, 'id', 'taluka');
    }
    public function villages()
    {
        return $this->hasOne(Village::class, 'id', 'village');
    }

}

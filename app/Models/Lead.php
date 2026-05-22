<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    protected $fillable = ['first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'marriage_date',
        'phone',
        'phonecode',
        'alternate_mobile_number',
        'email',
        'country',
        'state',
        'district',
        'city',
        'taluka',
        'village',
        'notes',
        'added_by',
        'is_lead_to_client',
        'lead_ancestor_notes',
        'wife_ancestor_notes',
        'original_language',
        'translated_language',
    ];

    public function scopeExcludeLeadClients($query)
    {
        return $query->where('is_lead_to_client', false);
    }

    public function scopeIsClient($query)
    {
        return $query->where('is_lead_to_client', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function wifeDetail()
    {
        return $this->hasOne(WifeDetail::class, 'lead_id');
    }

    public function siblings()
    {
        return $this->hasMany(Sibling::class, 'lead_id');
    }

    public function families()
    {
        return $this->hasMany(Family::class, 'lead_id');
    }

    public function children()
    {
        return $this->hasMany(Children::class, 'lead_id');
    }

    public function lineages()
    {
        return $this->hasOne(Lineages::class, 'lead_id');
    }

    public function leadNote()
    {
        return $this->hasMany(LeadNote::class, 'lead_id');
    }

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

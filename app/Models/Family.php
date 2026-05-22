<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
     use SoftDeletes;
     
    protected $fillable = ['lead_id',
        'belongs_to',
        'relation',
        'name',
        'birth_date',
        'marriage_date',
        'death_date',
        'ancestor_notes'];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
}

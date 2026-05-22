<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearcherReport extends Model
{
    protected $fillable = [
        'client_id',
        'top_tagline',
        'name',
        'lineage',
        'caste',
        'subspecies',
        'surname',
        'credit',
        'gotra',
        'pravar',
        'vedas',
        'upaveda',
        'branch',
        'peak',
        'formula',
        'gotra_devi',
        'ishta_devi',
        'ishtadev',
        'kuldevi',
        'kuldevata',
        'supportive_mother',
        'river',
        'ancestor_shrine',
        'tirth_purohit',
        'original_location',
        'kuldevi_dash',
        'patriarchy',
        'image',
        'kul_tagline',
        'title',
        'description',
        'history_title',
        'history_description',
        'translated_language',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}

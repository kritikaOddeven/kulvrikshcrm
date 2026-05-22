<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Lineages extends Model
{
     use SoftDeletes;
     
    protected $fillable = ['lead_id',
        'belongs_to',
        'lineage',
        'caste',
        'sub_caste',
        'surname',
        'gotra',
        'kuldevi',
        'kuldevta',
        'primary_clan',
        'sub_clan',
        'khap',
        'rulership',
        'spiritual_seat',
        'ancestral_village',
        'note'];
}

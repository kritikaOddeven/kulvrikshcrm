<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadAttachment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'lead_id',
        'note_id',
        'attachment',
        'type',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function note()
    {
        return $this->belongsTo(LeadNote::class, 'note_id');
    }
} 
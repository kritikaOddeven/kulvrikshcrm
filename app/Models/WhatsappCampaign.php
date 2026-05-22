<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsappCampaign extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'template_id',
        'start_date',
        'start_time',
        'selected_phones',
        'total_person',
        'status',
    ];

    protected $casts = [
        'selected_phones' => 'array',
        'start_date' => 'date',
        'start_time' => 'datetime:H:i:s',
    ];

    public function template()
    {
        return $this->belongsTo(WhatsappTemplate::class, 'template_id');
    }

    public function messageLogs()
    {
        return $this->hasMany(CampaignWhatsappLog::class, 'campaign_id');
    }
} 
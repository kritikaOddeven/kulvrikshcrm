<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignWhatsappLog extends Model
{
    protected $fillable = [
        'campaign_id',
        'phone',
        'person_name',
        'person_type',
        'relation',
        'message_content',
        'status',
        'sent_at',
        'error_message',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function campaign()
    {
        return $this->belongsTo(WhatsappCampaign::class, 'campaign_id');
    }
} 
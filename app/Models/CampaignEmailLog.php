<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignEmailLog extends Model
{
    protected $fillable = [
        'campaign_id',
        'email',
        'client_id',
        'person_name',
        'person_type',
        'relation',
        'name',
        'status',
        'error_message',
        'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime'
    ];

    public function campaign()
    {
        return $this->belongsTo(MailCampaign::class, 'campaign_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
} 
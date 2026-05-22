<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailCampaign extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'template_id',
        'start_date',
        'start_time',
        'selected_emails',
        'total_person',
        'status',
        'campaign_type',
    ];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }

    public function emailLogs()
    {
        return $this->hasMany(CampaignEmailLog::class, 'campaign_id');
    }
}

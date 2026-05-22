<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsappTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'template_name',
        'template_api_name',
        'template_type',
        'message_text',
        'template_footer',
    ];

    public function campaigns()
    {
        return $this->hasMany(WhatsappCampaign::class, 'template_id');
    }
} 
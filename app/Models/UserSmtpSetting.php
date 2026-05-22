<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSmtpSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name',
        'is_active'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'port' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getProviderConfigs()
    {
        return [
            'gmail' => [
                'name' => 'Gmail',
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'encryption' => 'tls',
                'instructions' => 'Use Gmail address and App Password'
            ],
            'outlook' => [
                'name' => 'Outlook/Hotmail',
                'host' => 'smtp-mail.outlook.com',
                'port' => 587,
                'encryption' => 'tls',
                'instructions' => 'Use Outlook email and password'
            ],
            // 'zoho' => [
            //     'name' => 'Zoho Mail',
            //     'host' => 'smtp.zoho.com',
            //     'port' => 587,
            //     'encryption' => 'tls',
            //     'instructions' => 'Use Zoho email and password'
            // ],
            'yahoo' => [
                'name' => 'Yahoo Mail',
                'host' => 'smtp.mail.yahoo.com',
                'port' => 587,
                'encryption' => 'tls',
                'instructions' => 'Use Yahoo email and App Password'
            ]
        ];
    }
}

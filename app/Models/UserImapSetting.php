<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImapSetting extends Model
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
                'host' => 'imap.gmail.com',
                'port' => 993,
                'encryption' => 'ssl',
                'instructions' => 'Use Gmail address and App Password. Enable IMAP in Gmail settings.'
            ],
            'outlook' => [
                'name' => 'Outlook/Hotmail',
                'host' => 'outlook.office365.com',
                'port' => 993,
                'encryption' => 'ssl',
                'instructions' => 'Use Outlook email and password. Enable IMAP in Outlook settings.'
            ],
            // 'zoho' => [
            //     'name' => 'Zoho Mail',
            //     'host' => 'imap.zoho.com',
            //     'port' => 993,
            //     'encryption' => 'ssl',
            //     'instructions' => 'Use Zoho email and password.'
            // ],
            'yahoo' => [
                'name' => 'Yahoo Mail',
                'host' => 'imap.mail.yahoo.com',
                'port' => 993,
                'encryption' => 'ssl',
                'instructions' => 'Use Yahoo email and App Password. Enable IMAP in Yahoo settings.'
            ],
            // 'custom' => [
            //     'name' => 'Custom IMAP',
            //     'host' => '',
            //     'port' => 993,
            //     'encryption' => 'ssl',
            //     'instructions' => 'Enter your custom IMAP server details.'
            // ]
        ];
    }

    public function getImapConfig()
    {
        return [
            'host' => $this->host,
            'port' => $this->port,
            'username' => $this->username,
            'password' => $this->password,
            'encryption' => $this->encryption,
        ];
    }
} 
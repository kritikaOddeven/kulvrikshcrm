<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's SMTP settings
     */
    public function smtpSetting()
    {
        return $this->hasOne(UserSmtpSetting::class);
    }

    /**
     * Get the user's IMAP settings
     */
    public function imapSetting()
    {
        return $this->hasOne(UserImapSetting::class);
    }

    /**
     * Get the user's email messages
     */
    public function emailMessages()
    {
        return $this->hasMany(EmailMessage::class);
    }

    /**
     * Check if user has SMTP configured
     */
    public function hasSmtpConfigured()
    {
        return $this->smtpSetting && $this->smtpSetting->is_active;
    }

    /**
     * Check if user has IMAP configured
     */
    public function hasImapConfigured()
    {
        return $this->imapSetting && $this->imapSetting->is_active;
    }

    /**
     * Get SMTP configuration for the user
     */
    public function getSmtpConfig()
    {
        if (!$this->hasSmtpConfigured()) {
            return null;
        }

        return [
            'host' => $this->smtpSetting->host,
            'port' => $this->smtpSetting->port,
            'username' => $this->smtpSetting->username,
            'password' => $this->smtpSetting->password,
            'encryption' => $this->smtpSetting->encryption,
            'from_address' => $this->smtpSetting->from_address,
            'from_name' => $this->smtpSetting->from_name,
        ];
    }

    /**
     * Get IMAP configuration for the user
     */
    public function getImapConfig()
    {
        if (!$this->hasImapConfigured()) {
            return null;
        }

        return $this->imapSetting->getImapConfig();
    }
}

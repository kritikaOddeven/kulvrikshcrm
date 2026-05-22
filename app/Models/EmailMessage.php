<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message_id',
        'folder',
        'from_email',
        'from_name',
        'to_email',
        'to_name',
        'cc',
        'bcc',
        'subject',
        'body',
        'body_plain',
        'body_html',
        'date_received',
        'is_read',
        'is_starred',
        'has_attachments',
        'attachments'
    ];

    protected $casts = [
        'date_received' => 'datetime',
        'is_read' => 'boolean',
        'is_starred' => 'boolean',
        'has_attachments' => 'boolean',
        'attachments' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeInFolder($query, $folder)
    {
        return $query->where('folder', strtoupper($folder));
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeStarred($query)
    {
        return $query->where('is_starred', true);
    }

    public function getFormattedDateAttribute()
    {
        return $this->date_received->format('d M Y H:i');
    }

    public function getShortSubjectAttribute()
    {
        return strlen($this->subject) > 50 ? substr($this->subject, 0, 50) . '...' : $this->subject;
    }

    public function getShortBodyAttribute()
    {
        $body = strip_tags($this->body_plain ?: $this->body);
        return strlen($body) > 100 ? substr($body, 0, 100) . '...' : $body;
    }
} 
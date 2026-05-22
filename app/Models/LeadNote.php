<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class LeadNote extends Model
{
    use SoftDeletes;
    protected $fillable = ['lead_id', 'added_by', 'content', 'original_content'];
    
    public function user()
    {
        return $this->hasOne(User::class,'id','added_by');
    }

    public function lead()
    {
        return $this->hasOne(Lead::class, 'id', 'lead_id');
    }

    public function attachments()
    {
        return $this->hasMany(LeadAttachment::class, 'note_id');
    }
}

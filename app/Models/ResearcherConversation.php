<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearcherConversation extends Model
{
    protected $fillable = ['added_by', 'type', 'client_id', 'content', 'original_content', 'attachment'];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

}

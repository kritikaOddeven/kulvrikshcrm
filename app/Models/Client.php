<?php
namespace App\Models;

use App\Models\Scopes\ResearchStatusScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\Models\ClientService;

class Client extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'kulvrisk_id',
        'lead_id',
        'researcher_ids',
        'agent_id',
        'project_ids',
        'sub_project_ids',
        'payment_mode',
        'start_date',
        'end_date',
        'image_path',
        'description',
        'research_status',
        'converted_agent_id',
    ];

    protected static function booted()
    {
        // Apply global scope
        static::addGlobalScope(new ResearchStatusScope());
        
        // Update research status when model is retrieved
        static::retrieved(function ($client) {
            ResearchStatusScope::updateResearchStatus($client);
        });
    }

    /**
     * Get the current research status, updating it if necessary
     */
    public function getCurrentResearchStatusAttribute()
    {
        ResearchStatusScope::updateResearchStatus($this);
        return $this->research_status;
    }



    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function report()
    {
        return $this->hasOne(ResearcherReport::class, 'client_id', 'id');
    }

    public function conversation()
    {
        return $this->hasMany(ResearcherConversation::class, 'client_id', 'id')->where('type', 'conversation');
    }

    public function researcherView()
    {
        return $this->hasMany(ResearcherConversation::class, 'client_id', 'id')->where('type', 'view');
    }
   
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    //mansi add
    public function clientServices()
    {
        return $this->hasMany(ClientService::class);
    }

}

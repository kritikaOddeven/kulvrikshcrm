<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillService extends Model
{
    protected $fillable = [
        'bill_id',
        'block_index',
        'project_id',
        'sub_project_id',
        'service_name',
        'description',
        'hsn',
        'quantity',
        'amount',
        'type',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'amount'   => 'decimal:2',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function subProject()
    {
        return $this->belongsTo(Project::class, 'sub_project_id');
    }
}

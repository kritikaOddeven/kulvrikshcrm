<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientService extends Model
{
    protected $fillable = [
        'client_id',
        'block_index',
        'project_id',
        'sub_project_id',
        'service_name',
        'description',
         'quantity', 
        'amount',   
        'type',
    ];
}
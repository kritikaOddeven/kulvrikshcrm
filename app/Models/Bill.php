<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'client_id',
        'project_ids',
        'sub_project_ids',
        'invoice_number',
        'status',
        'amount',
        'gst_number',
        'bank_account_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
    public function billServices()
    {
        return $this->hasMany(BillService::class);
    }

}

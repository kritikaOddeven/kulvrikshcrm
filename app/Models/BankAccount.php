<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'account_holder_name',
        'account_number',
        'ifsc_code',
        'swift_code',
        'upi_number',
        'opening_balance',
        'branch',
        'status',
        'user_id',
    ];
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'account_id');
    }
}
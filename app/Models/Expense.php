<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'account_id', 'category_id', 'subject', 'amount', 'description', 'date', 'payment_mode',
    ];
    
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'account_id');
    }

    public function expensesCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }
}

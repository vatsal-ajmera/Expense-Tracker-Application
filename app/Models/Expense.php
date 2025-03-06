<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'category_type_id',
        'text',
        'description',
        'amount',
        'expense_date',
        'attachment',
        'status',
        'created_at',
        'updated_at',
    ];

    const STATUS_PAID = 1;
    const STATUS_UNPAID = 2;
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_type_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public const ACCOUNT_TYPE_SAVINGS = '1';
    public const ACCOUNT_TYPE_CREDIT_CARD = '2';
    public const ACCOUNT_TYPE_DEBIT_CARD = '3';
    public const ACCOUNT_TYPE_WALLET = '4';

    public static function getAccountType()
    {  
        return [
            self::ACCOUNT_TYPE_SAVINGS => 'Savings Account',
            self::ACCOUNT_TYPE_CREDIT_CARD => 'Credit Card',
            self::ACCOUNT_TYPE_DEBIT_CARD => 'Debit Card',
            self::ACCOUNT_TYPE_WALLET => 'Wallet',
        ];
    }
}

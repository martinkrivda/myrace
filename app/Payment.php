<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $fillable = ['transactionId', 'date', 'amount', 'currency', 'accountId', 'bankCode', 'bankName', 'ks', 'vs', 'ss', 'message', 'autor', 'bic'];
    protected $table = 'payment';
    protected $primaryKey = 'payment_ID';
}

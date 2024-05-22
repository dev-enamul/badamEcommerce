<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'statusCode',
        'statusMessage',
        'paymentID',
        'payerReference',
        'customerMsisdn',
        'trxID',
        'amount',
        'transactionStatus',
        'paymentExecuteTime',
        'currency',
        'intent',
        'merchantInvoiceNumber',
    ];
}

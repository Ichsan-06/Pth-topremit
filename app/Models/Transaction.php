<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_id',
        'type', //local international
        'status',
        'receipt_id',
        'currency_id',
        'rate',
        'amount',
        'fee',
        'transaction_date',
        'notes'
    ];

    public static function boot()
    {
        parent::boot();

            self::creating(function($model){
            $model->reference_id = Str::uuid();
            $model->transaction_date = now();
        });
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

}

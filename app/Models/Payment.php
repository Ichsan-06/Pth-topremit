<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_type',
        'bank_name',
        'expired_at',
        'transaction_id',
        'status',
        'total_amount',
        'fee'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2', // Ubah 'your_decimal_attribute' menjadi atribut model Anda
    ];

    public static function boot()
    {
        parent::boot();

            self::creating(function($model){
            $model->expired_at = now()->addDay();
            $model->status = 'pending';
        });
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}

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
        'status',//incomplete,need_payment,in_progress,success,failed,canceled,expired
        'receipt_id',
        'user_id',
        'currency_id',
        'rate',
        'amount',
        'sub_amount',
        'fee',
        'transaction_date',
        'notes'
    ];

    public function scopeOrder($query,$request){
        if ($request->has('orderby') && $request->has('sort')) {
            return $query->orderby($request->orderby,$request->sort);
        }
    }

    public function scopeFilter($query,$request){
        if($request->has('key')){
            $query->where(function($sub) use($request) {

            });
        }

        if($request->has('status')){
            $query->where("status",$request->status);
        }
    }

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

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

}

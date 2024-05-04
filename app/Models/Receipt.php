<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'type',
        'account_name',
        'account_number'
    ];

    public function receiptDetails()
    {
        return $this->hasMany(ReceiptDetail::class);
    }

    protected $appends = [
        "type_display"
    ];

    public function getTypeDisplayAttribute($val){
        $result = $val;
        switch($this->type){
            case"local":
                $result = "Local";
            break;
            case"international":
                $result = "International";
            break;
        }
        return $result;
    }
}

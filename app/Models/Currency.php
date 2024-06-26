<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_name',
        'code',
        'rate',
    ];

    public function scopeOrder($query,$request){
        if ($request->has('orderby') && $request->has('sort')) {
            return $query->orderby($request->orderby,$request->sort);
        }
    }

    public function scopeFilter($query,$request){
        if($request->has('key')){
            $query->where(function($sub) use($request) {
                $sub->orWhere("country_name","like",'%'.$request->key.'%');
            });
        }
    }
}

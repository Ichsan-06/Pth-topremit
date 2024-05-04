<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'title','message',  'is_read',
    ];

    // Relasi dengan pengguna
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOrder($query,$request){
        if ($request->has('orderby') && $request->has('sort')) {
            return $query->orderby($request->orderby,$request->sort);
        }
    }

    public function scopeFilter($query,$request){
        if($request->has('key')){
            $query->where(function($sub) use($request) {
                $sub->orWhere("title","like",'%'.$request->key.'%');
            });
        }
    }
}

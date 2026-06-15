<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // 
    protected $fillable = [
        'name',
        'gender',
        'DOB',
        'phone',
        'avatar',
        'lang',
        'user_id'
    ];
   public function user()
{
    return $this->belongsTo(User::class);
}
public function ratings()
{
    return $this->hasMany(Rating::class);
}
}

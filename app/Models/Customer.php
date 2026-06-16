<?php

namespace App\Models;
use App\Models\BookRequest;
use App\Models\waitingList;
use App\Models\Bill;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
   public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

public function ratings(): HasMany
{
    return $this->hasMany(Rating::class);
}

public function bookRequests(): HasMany
{
    return $this->hasMany(BookRequest::class);
}

public function waitingList(): HasMany
{
    return $this->hasMany(waitingList::class);
}

public function bills(): HasMany
{
    return $this->hasMany(Bill::class);
}
}

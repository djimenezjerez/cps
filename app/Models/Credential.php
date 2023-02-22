<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $fillable = [
        'code',
        'year_start',
        'year_end',
        'user_id',
        'business_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function years()
    {
        return $this->hasMany(Year::class);
    }
}

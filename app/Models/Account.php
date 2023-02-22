<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'business_id',
        'name',
        'code',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

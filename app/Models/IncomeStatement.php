<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeStatement extends Model
{
    protected $fillable = [
        'year_id',
        'account_id',
        'subtotal',
    ];

    protected $casts = [
        'subtotal' => 'float',
    ];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}

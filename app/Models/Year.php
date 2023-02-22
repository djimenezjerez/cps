<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $fillable = [
        'credential_id',
        'name',
        'total_income_statement',
    ];

    protected $casts = [
        'total_income_statement' => 'float',
    ];

    public function credential()
    {
        return $this->belongsTo(Credential::class);
    }
}

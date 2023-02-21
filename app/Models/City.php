<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'code',
        'order',
    ];

    public $timestamps = false;

    public function employees()
    {
        return $this->hasMany(User::class);
    }
}

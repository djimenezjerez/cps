<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'ci',
        'ci_complement',
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function businessManager()
    {
        return $this->hasMany(Business::class, 'ceo_id', 'id');
    }

    public function businessContact()
    {
        return $this->hasMany(Business::class, 'contact_id', 'id');
    }
}

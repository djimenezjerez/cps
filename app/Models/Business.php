<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'name',
        'nit',
        'code',
        'address',
        'ceo_id',
        'contact_id',
    ];

    public function ceo()
    {
        return $this->belongsTo(Employee::class, 'ceo_id', 'id');
    }

    public function contact()
    {
        return $this->belongsTo(Employee::class, 'contact_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'logo',
        'description',
        'status',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}

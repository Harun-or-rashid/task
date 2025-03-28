<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'organization_id',
        'name',
        'description',
        'status'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function employees()
    {
        return $this->hasMany(User::class);
    }
public function users()
{
    return $this->hasMany(User::class);
}

}

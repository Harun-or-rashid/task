<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable =
    [
        'name',
        'email',
        'salary',
        'start_date',
        'team_id',
        'organization_id',
        'description',
        'status'
    ];

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function organization() {
        return $this->belongsTo(Organization::class,);
    }

    public function scopeFilterByStartDate($query, $date) {
        return $query->where('start_date', '>=', $date);
    }
}

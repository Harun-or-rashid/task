<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'employee_id',
        'manage_organization',
        'manage_team',
        'manage_employee',
        'manage_report',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}

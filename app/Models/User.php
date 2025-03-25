<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'team_id',
        'organization_id',
        'salary',
        'start_date',
        'description',
        'role',
        'status',
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
    public function permission()
    {
        return $this->hasOne(Permission::class);
    }
    public function hasPermission($permission)
{
    return $this->permission && $this->permission->$permission;
}


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

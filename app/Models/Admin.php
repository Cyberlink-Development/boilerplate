<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
class Admin extends Authenticatable
{
    use HasFactory, HasRoles;
    protected $guard_name = 'admin'; 

    protected $fillable = [
        'name',
        'p_id',
        'email',
        'email_verified_at',
        'password',
        'pin',
        'phone',
        'image'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }

    // public function role(){
    //     return $this->belongsTo(Role::class);
    // }
}
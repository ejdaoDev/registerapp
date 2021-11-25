<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Security\Role;

class User extends Authenticatable implements JWTSubject {

    use HasFactory,
        HasApiTokens,
        Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'role_id',
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    public function role() {
        return $this->hasOne(Role::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getJWTCustomClaims(): array {
        return [];
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

}

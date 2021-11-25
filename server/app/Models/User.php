<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Security\Role;


class User extends Authenticatable implements JWTSubject {

    use HasFactory,
        SoftDeletes,
        HasApiTokens,
        Notifiable;
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'active',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];
    protected $hidden = [
        'role_id',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'updated_by'
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

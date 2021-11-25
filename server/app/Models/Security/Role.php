<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model {

    protected $table = 'roles';
    public $timestamps = false;
    protected $fillable = [
        "name",
    ];
    
    public function users() {
        return $this->hasMany(User::class);
    }

}

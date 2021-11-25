<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $table = 'roles';
    public $timestamps = false;
    protected $fillable = [
        "name",
    ];

}

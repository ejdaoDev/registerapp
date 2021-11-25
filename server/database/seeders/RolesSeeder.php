<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Security\Role;

class RolesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (Role::select('roles.id')->where("name", "ADMIN")->count() == 0) {
            $role1['name'] = "ADMIN";
            Role::create($role1);
        }
        if (Role::select('roles.id')->where("name", "USER")->count() == 0) {
            $role2['name'] = "USER";
            Role::create($role2);
        }
    }

}

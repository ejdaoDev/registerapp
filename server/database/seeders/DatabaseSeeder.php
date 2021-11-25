<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Security\Role;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        $this->call(RolesSeeder::class);

        if (User::select('users.id')->where("email", "admin@hotmail.com")->count() == 0) {
            $user['name'] = "superuser";
            $user['email'] = "superuser@hotmail.com";
            $user['password'] = bcrypt("123");
            $user['active'] = true;
            $user['role_id'] = Role::select('roles.id')->where("name", "ADMIN")->first()->id;
            User::create($user);
            $id = User::select('users.id')->where("email", "superuser@hotmail.com")->first()->id;
            $superuser = User::findOrFail($id);
            $upd['created_by'] = $id;
            $upd['updated_by'] = $id;
            $superuser->update($upd);
        }

        User::factory(10)->create();
    }

}

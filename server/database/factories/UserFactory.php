<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory {

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'created_by' => 1,
            'updated_by' => 1,
            'role_id' => 2,
        ];
    }

    /*
     * Se espera que el usuario 1 siempre sea "superuser" y el rol 2 siempre
     * sea "USER", en caso de falla o llegar a requerirlo puede seleccionarlos 
     * atravez las siguientes consultas:
     * get user: User::select('users.id')->where("email", "superuser@hotmail.com")->first()->id
     * get role: Role::select('roles.id')->where("name", "USER")->first()->id
     */
}

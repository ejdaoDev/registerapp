<?php

namespace App\Http\Interactors\Security;

use App\Models\User;

class UserInteractor {

    public function getUsersWithAuth($id) {
        return User::select('users.*', 'roles.name as role')
                        ->join('roles', 'roles.id', 'users.role_id')
                        ->where('users.created_by', $id)
                        ->where('users.id', '!=', $id)->paginate(10);
    }

    public function getUsersWithoutAuth() {
        return User::select('users.*', 'roles.name as role')
                        ->join('roles', 'roles.id', 'users.role_id')->paginate(10);
    }

}

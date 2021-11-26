<?php

namespace App\Http\Repositories\Security;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Security\Role;
use Illuminate\Support\Facades\DB;
use App\Http\Repositories\Repository;

class UserRepository extends Repository {

    public function create(Request $request, $role, $active) {
        $user['role_id'] = $role;
        $user['name'] = $request->name;
        $user['email'] = $request->email;
        $user['password'] = bcrypt("123");
        $user['active'] = $active;
        $user['created_by'] = auth($this->guard)->id();
        $user['updated_by'] = auth($this->guard)->id();
        DB::beginTransaction();
        try {
            User::create($user);
            DB::commit();
            return true;
        } catch (\Exception $ex) {
            \Log::debug($ex);
            DB::rollBack();
            return false;
        }
    }

    public function update($user, $array) {
        DB::beginTransaction();
        try {
            $user->fill($array)->save();
            DB::commit();
            return true;
        } catch (\Exception $ex) {
            \Log::debug($ex);
            DB::rollBack();
            return false;
        }
    }

    public function register(Request $request, $superuser = null) {
        if (User::select('users.id')->where("email", 'superuser@hotmail.com')->count() > 0) {
            $superuser = User::select('users.id')->where("email", 'superuser@hotmail.com')->first()->id;
        }
        $user['role_id'] = Role::select('roles.id')->where("name", 'ADMIN')->first()->id;
        $user['name'] = $request->name;
        $user['email'] = $request->email;
        $user['password'] = bcrypt($request->password);
        $user['active'] = true;
        $user['created_by'] = $superuser;
        $user['updated_by'] = $superuser;
        DB::beginTransaction();
        try {
            User::create($user);
            DB::commit();
            return true;
        } catch (\Exception $ex) {
            \Log::debug($ex);
            DB::rollBack();
            return false;
        }
    }

}

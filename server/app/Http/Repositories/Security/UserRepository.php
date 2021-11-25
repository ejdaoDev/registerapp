<?php

namespace App\Http\Repositories\Security;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository {

    public function create(Request $request, $role, $active) {
        $user['role_id'] = $role;
        $user['name'] = $request->name;
        $user['email'] = $request->email;
        $user['password'] = bcrypt("123");
        $user['active'] = $active;
        $user['created_by'] = auth("api")->id();
        $user['updated_by'] = auth("api")->id();
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

}

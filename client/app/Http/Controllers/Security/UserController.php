<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller {

    public function get() {
        $users = User::select('users.*', 'roles.name as role')
                ->join('roles', 'roles.id', 'users.role_id')
                ->where('users.created_by', auth($this->guard)->id())
                ->where('users.id', '!=', auth($this->guard)->id())
                ->get();
        return response()->json([
                    'status' => "200",
                    'data' => ['user' => $users]]);
    }

}

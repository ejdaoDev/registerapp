<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Security\Role;
use App\Http\Repositories\Security\UserRepository;

class UserController extends Controller {

    public function get() {
        if (auth($this->guard)->id()) {
            $users = User::select('users.*', 'roles.name as role')
                    ->join('roles', 'roles.id', 'users.role_id')
                    ->where('users.created_by', auth($this->guard)->id())
                    ->where('users.id', '!=', auth($this->guard)->id())
                    ->get();
            return response()->json([
                        'status' => "200",
                        'data' => ['users' => $users]]);
        }
        $users = User::select('users.*', 'roles.name as role')
                    ->join('roles', 'roles.id', 'users.role_id')->get();
            return response()->json([
                        'status' => "200",
                        'data' => ['users' => $users]]);
        
    }

    public function create(Request $request) {
        if (User::where("email", $request->email)->count()) {
            return response()->json([
                        'status' => "204",
                        'data' => ['message' => 'this email already exist']]);
        }
        $role = Role::select('roles.id')->where("name", $request->role)->first()->id;
        $active = null;
        if ($request->role == 'ADMIN') {
            $active = true;
        }if ($request->role == 'USER') {
            $active = false;
        }
        if ($this->repository()->create($request, $role, $active)) {
            return response()->json([
                        'status' => "200",
                        'data' => ['message' => "user successfully created"]]);
        }
        return response()->json([
                    'status' => "204",
                    'data' => ['message' => "the user could not be created"]]);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $array = $request->all();
        if ($request->role == 'ADMIN') {
            $array["active"] = true;
        }
        if ($request->role == 'USER') {
            $array["active"] = false;
        }
        $array["role_id"] = Role::select('roles.id')->where("name", $request->role)->first()->id;

        if ($this->repository()->update($user, $array)) {
            return response()->json([
                        'status' => "200",
                        'data' => ['message' => "user successfully updated"]]);
        }
        return response()->json([
                    'status' => "204",
                    'data' => ['message' => "the user could not be updated, maybe the email already exist"]]);
    }

    public function delete($id) {
        //\Log::debug('eliminando usuario');
        User::findOrFail($id)->delete();
        return response()->json([
                    'status' => "200",
                    'data' => ['message' => "user successfully deleted"]]);
    }

    protected function repository() {
        $repository = new UserRepository();
        return $repository;
    }

}

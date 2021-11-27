<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Security\Role;
use App\Http\Repositories\Security\UserRepository;
use App\Http\Interactors\Security\UserInteractor;

class UserController extends Controller {

    public function index() {
        if (auth($this->guard)->id()) {
            $users = $this->interactor()->getUsersWithAuth(auth($this->guard)->id());
            return response()->json([
                        'status' => "200",
                        'data' => ['users' => $users]]);
        }
        $users = $this->interactor()->getUsersWithoutAuth();
        return response()->json([
                    'status' => "200",
                    'data' => ['users' => $users]]);
    }

    public function store(Request $request) {
        if (User::withTrashed()->where("email", $request->email)->count()) {
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
                    'status' => "500",
                    'data' => ['message' => "the user could not be created"]]);
    }

    public function getUser($id) {
        $user = User::select('users.*', 'roles.name as role')
                        ->join('roles', 'roles.id', 'users.role_id')
                        ->where('users.id', $id)->first();
        //\Log::debug($user);
        if ($user->count() > 0) {
            return response()->json([
                        'status' => "200",
                        'data' => ['user' => $user]]);
        }
        return response()->json([
                    'status' => "404",
                    'data' => ['message' => 'no found']]);
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

    public function destroy($id) {
        //\Log::debug('eliminando usuario');
        User::findOrFail($id)->delete();
        return response()->json([
                    'status' => "200",
                    'data' => ['message' => "user successfully deleted"]]);
    }

    public function hardDestroy($id) {
        //\Log::debug('eliminando usuario definitivamente');
        User::withTrashed()->where("id", $id)->forceDelete();
        return response()->json([
                    'status' => "200",
                    'data' => ['message' => "user successfully deleted"]]);
    }

    public function getDeletedUsers() {
        //$users = User::onlyTrashed()->where('created_by', auth($this->guard)->id())->get();
        $users = User::select('users.*', 'roles.name as role')
                        ->join('roles', 'roles.id', 'users.role_id')
                        ->where('users.created_by', auth($this->guard)->id())
                        ->where('users.id', '!=', auth($this->guard)->id())
                        ->onlyTrashed()->get();
        return response()->json([
                    'status' => "200",
                    'data' => ['users' => $users]]);
    }

    public function RestoreUser($id) {
        //\Log::debug('restaurando usuario');
        User::onlyTrashed()->findOrFail($id)->restore();
        return response()->json([
                    'status' => "200",
                    'data' => ['message' => "user successfully restored"]]);
    }

    public function RestoreAllUsers() {
        //\Log::debug('restaurando usuarios');
        User::query()->where('created_by', auth($this->guard)->id())->restore();
        return response()->json([
                    'status' => "200",
                    'data' => ['message' => "All users was successfully restored"]]);
    }

    protected function repository() {
        $repository = new UserRepository();
        return $repository;
    }

    protected function interactor() {
        $interactor = new UserInteractor();
        return $interactor;
    }

}

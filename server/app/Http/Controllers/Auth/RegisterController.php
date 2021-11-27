<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Repositories\Security\UserRepository;

class RegisterController extends Controller {

    public function register(Request $request) {
        if (User::withTrashed()->where("email", $request->email)->count()) {
            return response()->json([
                        'status' => "204",
                        'data' => ['message' => 'this email already exist']]);
        }
        if ($this->repository()->register($request)) {
            return response()->json([
                        'status' => "200",
                        'data' => ['message' => "user successfully created"]]);
        }
        return response()->json([
                    'status' => "500",
                    'data' => ['message' => "the user could not be created"]]);
    }

    protected function repository() {
        $repository = new UserRepository();
        return $repository;
    }

}

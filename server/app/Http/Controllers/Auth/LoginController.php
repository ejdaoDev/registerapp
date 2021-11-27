<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Services\Auth\ValidateUser;

class LoginController extends Controller {

    public function login(Request $request) {
        $credentials = $this->validator()->validate($request);
        if ($credentials == 401) {
            //\Log::debug('credenciales invalidas');
            return response()->json(['status' => "401",
                        'data' => ['mesage' => "invalid credentials"]]);
        }
        if ($credentials == 403) {
            return response()->json(['status' => "403",
                        'data' => ['mesage' => "user inhabilited"]]);
        }
        if (!$token = auth($this->guard)->attempt($credentials)) {
            //\Log::debug('credenciales invalidas');
            return response()->json(['status' => "401",
                        'data' => ['mesage' => "invalid credentials"]]);
        }
        //\Log::debug('logueado correctamente');
        return response()->json(['status' => "200", 'data' => ['token' => $token,
                        'user' => User::select('users.*', 'roles.name as role')
                                ->join('roles', 'roles.id', 'users.role_id')
                                ->where("users.id", auth($this->guard)->id())->first()
        ]]);
    }

    public function logout() {
        //\Log::debug('deslogueado correctamente');
        auth($this->guard)->logout();
        return response()->json([
                    'status' => "200",
                    'data' => [
                        'message' => "successfully logout"
        ]]);
    }

    public function refresh() {
        $token = $this->RespondWithToken(auth($this->guard)->refresh());
        return response()->json([
                    'status' => "200",
                    'data' => [
                        'token' => $token->original['access_token'],
        ]]);
    }

    protected function RespondWithToken($token) {
        return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth($this->guard)->factory()->getTTL() //6 hrs
        ]);
    }

    protected function validator() {
        $validator = new ValidateUser();
        return $validator;
    }

}

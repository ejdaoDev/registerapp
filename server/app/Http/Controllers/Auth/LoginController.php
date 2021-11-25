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
            return response()->json([
                        'status' => "401",
                        'data' => ['mesage' => "invalid credentials"]]);
        }
        if ($credentials == 403) {
            return response()->json([
                        'status' => "403",
                        'data' => ['mesage' => "user inhabilited"]]);
        }
        if (!$token = auth($this->guard)->attempt($credentials)) {
            return response()->json(['status' => "401",
                        'data' => ['mesage' => "invalid credentials"]]);
        }
        return response()->json(['data' => [
                        'status' => "200",
                        'type' => "200",
                        'token' => $token,
                        'user' => User::select('users.*', 'roles.name as role')
                        ->join('roles', 'roles.id','users.role_id')
                        ->where("users.id", auth($this->guard)->id())->get()
                    ]
                        ]
        );
    }

    //$this->guard)->id()

    public function logout() {
        auth($this->guard)->logout();
        return response()->json([
                    'data' => [
                        'status' => "200",
                        'type' => "success",
                        'detail_en' => "Successfully loged out",
                        'detail_es' => "Deslogueado correctamente"
                    ]
        ]);
    }

    public function refresh() {
        $token = $this->RespondWithToken(auth($this->guard)->refresh());
        return response()->json(['data' => ['status' => "200",
                        'type' => "200",
                        'token' => $token->original['access_token'],
                    ]
                        ]
        );
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

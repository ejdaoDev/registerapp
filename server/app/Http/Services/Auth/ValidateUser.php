<?php

namespace App\Http\Services\Auth;

use Illuminate\Http\Request;
use App\Models\User;

class ValidateUser {

    public function validate(Request $request) {
        if (!User::where('email', $request->email)->count()) {
            return 401; //email not exist
        }
        $user = User::select("email", "active")->where('email', $request->email)->first();
        $credentials = $request->only('email', 'password');
        if ($user["active"] == false) {
            return 403; //user inhabilited       
        } else {
            return $credentials;
        }
    }

}

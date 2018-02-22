<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sangria\IMAPAuth;

class LoginController extends Controller
{
    public function userAuthenticate(Request $request)
    {
        if ($request->session()->has('user_id')) {
            return response('Already Logged In', 200);
        }

        $username = $request->input('username');
        $password = $request->input('password');

        if (!isset($username) || !isset($password)) {
            return response('Pass Proper Params', 400);
        }

        else if(IMAPAuth::tauth($username, $password))
        {
            $request->session()->put('user_id',$username);
            return response('Logged In', 200);
        }
        
        else
        {
            $request->session()->flush();       
            return response('Invalid Credentials', 401);
        }
    }

    public function checkUserAuthenticate(Request $request)
    {
        $login_status = $request->session()->has('user_id');
        return response(isset($login_status), 200);
    }

    public function userLogout(Request $request)
    {
        $request->session()->flush();
        return response('Logged Out', 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sangria\IMAPAuth;
use DB;

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
            $is_admin = DB::table('admin')
                ->where('username', $username)
                ->first();

            $request->session()->put('is_admin',$is_admin);            
            $request->session()->put('user_id',$username);

            $response->message = 'Logged In';
            $response->is_admin = $is_admin;
            $json_response = json_encode($response);

            return response($response, 200);
        }
        
        else
        {
            $request->session()->flush();       
            return response('Invalid Credentials', 403);
        }
    }

    public function checkUserAuthenticate(Request $request)
    {
        if ($request->session()->has('user_id')) {
            $response->username = $request->session()->get('user_id');
            $response->is_admin = $request->session()->get('is_admin');
            $json_response = json_encode($response);

            return response($json_response, 200);
        }
        else {
            return response('Not Logged In', 403);
        }
    }

    public function userLogout(Request $request)
    {
        $request->session()->flush();
        return response('Logged Out', 200);
    }
}

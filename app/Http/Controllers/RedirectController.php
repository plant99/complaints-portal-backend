<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function LoginRedirect(Request $request) {
        if($request->session()->has('user_id')) {
            return redirect('/dashboard');
        }
        else {
            return view('login');
        }
    }

    public function DashboardRedirect(Request $request) {
        if ($request->session()->has('user_id')) {
            if ($request->session()->get('is_admin')) {
                return view('dashboardAdmin');
            }
            else {
                return view('dashboard');
            }

        }
        else {
            return redirect('/login');
        }
    }

    public function TicketRedirect(Request $request) {
        if ($request->session()->has('user_id')) {
            return view('complaint');
        }
        else {
            return redirect('/login');
        }
    }
}

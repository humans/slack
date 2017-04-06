<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function create()
    {
        return view('login.create');
    }

    public function store(Request $request)
    {
        if (! $auth = Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('logic.create');
        }

        return redirect('/');
    }
}
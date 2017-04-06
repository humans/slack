<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(Request $request)
    {
        User::create($request->only('name', 'email', 'password'));

        return redirect()->route('login.create');
    }
}
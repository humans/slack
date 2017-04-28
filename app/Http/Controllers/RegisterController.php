<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Display the registration form.
     *
     * @param  Team  $team
     * @return \Illuminate\View\View
     */
    public function create(Team $team)
    {
        return view('register.create')->withTeam($team);
    }

    /**
     * Display the registration form.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Team $team)
    {
        $team->addUser($request->only('name', 'username', 'email', 'password'));

        return redirect()->route('login.create', $team);
    }
}
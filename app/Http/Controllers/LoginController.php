<?php

namespace App\Http\Controllers;

use Auth;
use App\Team;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @param  Team  $team
     * @return \Illuminate\View\View
     */
    public function create(Team $team)
    {
        return view('login.create')->withTeam($team);
    }

    /**
     * Log the user in.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Team $team)
    {
        $credentials = $this->credentials($request, $team);

        if (! Auth::attempt($credentials, $remeber = true)) {
            return redirect()->back();
        }

        return redirect()->route('home', $team);
    }

    /**
     * Return the credentials from the request.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @return array
     */
    private function credentials(Request $request, Team $team)
    {
        return ['team_id' => $team->id] + $request->only('email', 'password');
    }
}
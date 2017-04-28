<?php

namespace App\Http\Controllers\Api;

use App\Team;
use Illuminate\Http\Request;

class CurrentUserController extends Controller
{
    /**
     * Return the current user details.
     *
     * @param  Request  $request
     * @param  Team  $team
     * @return User
     */
    public function __invoke(Request $request, Team $team)
    {
        return $request->user()->load('settings');
    }
}
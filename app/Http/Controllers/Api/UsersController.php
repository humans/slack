<?php

namespace App\Http\Controllers\Api;

use App\Team;

class UsersController extends Controller
{
    /**
     * List out all the users from the team.
     *
     * @param  Team  $team
     * @return \Illuminate\Support\Collection
     */
    public function index(Team $team)
    {
        return $team->users;
    }
}
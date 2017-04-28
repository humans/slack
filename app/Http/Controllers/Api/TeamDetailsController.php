<?php

namespace App\Http\Controllers\Api;

use App\Team;

class TeamDetailsController extends Controller
{
    /**
     * Return the team details.
     *
     * @param  Team  $team
     * @return Team
     */
    public function __invoke(Team $team)
    {
        return $team;
    }
}
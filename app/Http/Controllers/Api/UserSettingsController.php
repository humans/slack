<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class UserSettingsController extends Controller
{
    /**
     * Return the settings.
     *
     * @param  Request  $request
     * @return \App\UserSettings
     */
    public function __invoke(Request $request)
    {
        return $request->user()->settings()->with('activeChannel')->first();
    }
}
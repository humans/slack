<?php

namespace App\Http\Controllers;

class LandingPageController extends Controller
{
    public function __invoke()
    {
        return view('landing');
    }
}
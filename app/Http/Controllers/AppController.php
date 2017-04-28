<?php

namespace App\Http\Controllers;

class AppController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke()
    {
        return view('home');
    }
}
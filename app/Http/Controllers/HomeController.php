<?php

namespace App\Http\Controllers;

use App\Models\About;

class HomeController extends Controller
{
    public function index()
    {
        $abouts = About::with('section', 'media')->get();
        return view('frontend.home', compact('abouts'));
    }
}

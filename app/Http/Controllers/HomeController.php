<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($locale = null)
    {
        if($locale) {
            app()->setLocale($locale);
        }
        return view('home');
    }

    public function view_chart() {
        return view('chart');
    }
}

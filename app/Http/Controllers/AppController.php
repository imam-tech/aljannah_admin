<?php

namespace App\Http\Controllers;

class AppController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function indexParent()
    {
        return view('app');
    }
}

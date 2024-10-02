<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function services()
    {
        return view('services.index');
    }

    public function about()
    {
        return view('about.about');
    }

    public function contactUs()
    {
        return view('contact.index');
    }
}
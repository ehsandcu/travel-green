<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CarbonEmission;
use App\Models\Team;
use App\Services\EmissionService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {   
        $emissionsResult = (new EmissionService())->getEmissionStats();

        return view('home', compact('emissionsResult'));
    }

    public function services()
    {
        return view('services.index');
    }

    public function about()
    {
        $team = Team::get();

        return view('about.about', compact('team'));
    }

    public function contactUs()
    {
        return view('contact.index');
    }
}
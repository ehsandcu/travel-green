<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CarbonEmission;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $emissionsResult = CarbonEmission::selectRaw('
            COUNT(*) as total_records,              
            SUM(distance) as total_distance, 
            SUM(carbon_emission) as total_carbon_emission
        ')->first();

        return view('home', compact('emissionsResult'));
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

    public function getAddressFromLatLng($lat, $lng) {
        // Google Maps Geocoding API URL
        $apiKey = config('services.google.google_map_key');
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key={$apiKey}";
        // Make the API request
        $response = file_get_contents($url);
    
        // Parse the JSON response
        $json = json_decode($response, true);
    
        // Check if we got a successful response
        if ($json['status'] == 'OK') {
            // Return the formatted address from the response
            return $json['results'][0]['formatted_address'];
        } else {
            return "Address not found.";
        }
    }
}
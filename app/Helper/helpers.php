<?php

function getInitialNameWordImage($name=null)
{
    return "https://eu.ui-avatars.com/api/?name=". $name ."";
}

function carbonEmission($tansportMode, $workDays, $distance, $weeksPerYear=48)
{
    return $tansportMode * $distance * 2 * $workDays * $weeksPerYear;
}

function getAddressFromLatLng($lat, $lng) {
    if($lat && $lng) {
        $apiKey = config('services.google.google_map_key');

        // Google Maps Geocoding API URL
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
            return "N/A";
        }
    }

    return "N/A";
}
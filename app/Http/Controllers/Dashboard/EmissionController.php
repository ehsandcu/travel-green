<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Lib\TransportMode;
use App\Models\CarbonEmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function storeEmission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'starting_latitude' => ['required'],
            'starting_longitude' => ['required'],
            'destination_latitude' => ['required'],
            'destination_longitude' => ['required'],
            'transport_method' => ['required', 'in:'.implode(',', array_keys(TransportMode::MODES))],
            'work_days' => ['required', 'gt:0'],
            'route_distance' => ['required', 'gt:0'],
        ]);

        if ($validator->fails()) {
            return $this->sendResponse([
                'success' => 0,
                'message' => $validator->errors()->first(),
            ]);
        }

        $transportMode = $request->transport_method;
        $workDays = $request->work_days;
        $routeDistance = $request->route_distance;

        $carbonEmission = CarbonEmission::create([
            'user_id' => auth()->user()->id,
            'starting_latlng' => $request->all(),
            'destination_latlng' => $request->all(),
            'transport_mode' => $transportMode,
            'work_day_per_week' => $workDays,
            'distance' => $routeDistance,
            'carbon_emission' => carbonEmission($transportMode, $workDays, $routeDistance),
        ]);
        
        return $this->sendResponse([
            'success' => 1,
            'message' => 'Data calculated successfully.',
        ]);        
    }

    public function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
        // Convert degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);
    
        // Haversine formula
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
    
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
        // Distance in meters
        return $earthRadius * $c;
    }

    public function getAddressFromLatLng($lat, $lng, $apiKey) {
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
            return "Address not found.";
        }
    }
}

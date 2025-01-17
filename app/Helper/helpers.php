<?php

use App\Lib\DcuCampus;
use Carbon\Carbon;

function getInitialNameWordImage($name=null)
{
    return "https://eu.ui-avatars.com/api/?name=". $name ."";
}

function carbonEmission($tansportMode, $workDays, $distance, $routeType=2)
{
    $carbonEmit = $tansportMode * $distance * $routeType * $workDays;
    
    return number_format((float)$carbonEmit, 2, '.', '');
}

function numFormat($val, $precisionNo=2) 
{
    return number_format((float)$val, $precisionNo, '.', '');
}

function convertInInteger($value)
{
    return intval($value);
}

function getAddressFromLatLng($lat, $lng) 
{
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

function listOfYears($startYear = null)
{
    $currentYear = now()->year;
    
    return range($startYear ?? $currentYear, $currentYear);
}

function calculateAvailableDays($startDate, $endDate) 
{
    $start = Carbon::parse($startDate);
    $end = Carbon::parse($endDate);

    // Calculate the total number of days between the start and end dates
    $totalDays = $start->diffInDays($end);
    $availableDays = 0;

    for ($date = $start; $date->lte($end); $date->addDay()) {
        // Check if the day is a weekday (Monday to Friday) and count it if the person is available
        if ($date->isWeekday() && $date->dayOfWeek != Carbon::SATURDAY && $date->dayOfWeek != Carbon::SUNDAY) {
            $availableDays++;
        }
    }

    return $availableDays;
}

function calculateAttendanceForDateRange($startDate, $endDate, $workDay=null) 
{
    $start = Carbon::parse($startDate);
    $end = Carbon::parse($endDate);
    $attendanceDays = 0;

    // Loop through the range week by week
    while ($start <= $end) {
        $startOfWeek = $start->copy()->startOfWeek()->max($start); // Clamp to the range start
        $endOfWeek = $start->copy()->endOfWeek()->min($end); // Clamp to the range end

        // Get the weekdays (Monday to Friday) in the current week
        $weekDays = $startOfWeek->daysUntil($endOfWeek)->filter(fn ($day) => $day->isWeekday());
        
        if ($workDay) {
            $attendanceDays += min($workDay, count($weekDays));
        } else {

            $attendanceDays += count($weekDays);
        }

        // Move to the next week
        $start = $start->addWeek();
    }

    return $attendanceDays;
}

function calculateDaysForDateRange($startDate, $endDate, $workDay=null) {
    $start = Carbon::parse($startDate);
    $end = Carbon::parse($endDate);
    $weekDays = 0;

    while ($start <= $end) {
        // Only count weekdays (Monday to Friday)
        // if ($start->isWeekday()) {
        //     $weekDays++;
        // }

        $weekDays++;

        // Move to the next day
        $start->addDay();
    }

    if ($workDay) {
        // Apply the "given work days per week" rule
        // $weekDays = intdiv($weekDays, 5) * $workDay + min($workDay, $weekDays % 5);  //excluded weekend days
        $weekDays = intdiv($weekDays, 7) * $workDay + min($workDay, $weekDays % 7);  //included weekend days
    }
    
    return $weekDays;
}

function getCampusesLatLng()
{
    $campuses = DcuCampus::CAMPUSES;

    $latLngToCampus = [];

    //format like '{"lat":"12.23","lng":"4.56"}' => 'Campus A',
    foreach ($campuses as $campusKey => $campus) {
        $latLngToCampus['{"lat":"'.$campus['latitude'].'","lng":"'.$campus['longitude'].'"}'] = $campusKey;
    }

    return $latLngToCampus;
}

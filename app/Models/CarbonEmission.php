<?php

namespace App\Models;

use App\Lib\SemesterType;
use App\Lib\TripJourney;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonEmission extends Model
{
    use HasFactory;

    protected $table = "carbon_emission";

    protected $casts = [
        'starting_latlng' => 'array',
        'destination_latlng' => 'array'
    ];

    protected $fillable = [
        'user_id',
        'trip_journey',
        'journey_start_date',
        'journey_end_date',
        'custom_week',
        'custom_month',
        'semester_type',
        'semester_year',
        'custom_date',
        'custom_year',
        'origin_address',
        'starting_latlng',
        'destination_address',
        'destination_latlng',
        'transport_mode',
        'work_day_per_week',
        'distance',
        'carbon_emission',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getJourneyDescriptionAttribute()
    {
        $description = '-';

        switch ($this->trip_journey) {
            case TripJourney::WEEKLY :
                $splitWeek = explode('-', $this->custom_week);
                
                $description = '<span><strong>Week:</strong>' .($splitWeek[1] ?? ''). '</span></br><span><strong>Year:</strong>' .($splitWeek[0] ?? ''). '</span>';
                break;
            
            case TripJourney::MONTHLY :
                $splitMonth = explode('-', $this->custom_month);
                $description = '<span><strong>Month:</strong>' .($splitMonth[1] ?? ''). '</span></br><span><strong>Year:</strong>' .($splitMonth[0] ?? ''). '</span>';

                break;
            
            case TripJourney::SEMESTER :
                $description = '<span><strong>Semester:</strong>' .(SemesterType::TYPES[$this->semester_type]['label'] ?? ''). '</span></br><span><strong>Year:</strong>' .($this->semester_year). '</span>';
                break;
            
            case TripJourney::ANNUAL :
                $description = '<span><strong>Year:</strong>' .$this->custom_year. '</span>';
                break;
            
            case TripJourney::CUSTOM :
                $splitDate = explode(' - ', $this->custom_date);
                
                $description = '<span><strong>Start Date:</strong>' .($splitDate[0] ?? ''). '</span></br><span><strong>End Date:</strong>' .($splitDate[1] ?? ''). '</span>';
                break;
            
            default:
                $description = '-';
                break;
        }

        return $description;
    }

    public function setStartingLatlngAttribute($startingArray)
    {   
        $startingLat = 0;
        $startingLng = 0;

        if (key_exists('starting_latitude', $startingArray) && key_exists('starting_longitude', $startingArray)) {
            $startingLat = $startingArray['starting_latitude'];
            $startingLng = $startingArray['starting_longitude'];
        }

        $this->attributes['starting_latlng'] = json_encode(['lat' => $startingLat, 'lng' => $startingLng]);
    }

    public function setDestinationLatlngAttribute($destinationArray)
    {   
        $destinationLat = 0;
        $destinationLng = 0;

        if (key_exists('destination_latitude', $destinationArray) && key_exists('destination_longitude', $destinationArray)) {
            $destinationLat = $destinationArray['destination_latitude'];
            $destinationLng = $destinationArray['destination_longitude'];
        }

        $this->attributes['destination_latlng'] = json_encode(['lat' => $destinationLat, 'lng' => $destinationLng]);
    }

    // public function getOriginAddressAttribute()
    // {
    //     $lat = $this->starting_latlng['lat'] ?? 0;
    //     $lng = $this->starting_latlng['lng'] ?? 0;
        
    //     return $this->getAddressFromLatLng($lat, $lng);
    // }

    // public function getDestinationAddressAttribute()
    // {
    //     $lat = $this->destination_latlng['lat'] ?? 0;
    //     $lng = $this->destination_latlng['lng'] ?? 0;
        
    //     return $this->getAddressFromLatLng($lat, $lng);
    // }
}

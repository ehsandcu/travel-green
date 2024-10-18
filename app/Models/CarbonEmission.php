<?php

namespace App\Models;

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
        'origin_address',
        'starting_latlng',
        'destination_address',
        'destination_latlng',
        'transport_mode',
        'work_day_per_week',
        'distance',
        'carbon_emission',
    ];

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

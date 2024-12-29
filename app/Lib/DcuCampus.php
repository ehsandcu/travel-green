<?php

namespace App\Lib;

class DcuCampus extends Enum
{
    const GLASNEVIN = 'glasnevin';
    const ST_PATRICK = 'st_patrick';    
    const ALL_HALLOWS = 'all_hallows';    
    const DCU_ALPHA = 'dcu_alpha';    
    const ST_CLAIRE = 'dcu_sports';    

    const CAMPUSES = [
        self::GLASNEVIN => [
            'label' => 'Glasnevin',
            'latitude' => '53.38543088444176', //according to Google maps
            'longitude' => '-6.2587973846566864', //according to Google maps
        ],
        self::ST_PATRICK => [
            'label' => 'St Patrick’s',
            'latitude' => '53.37178623482478', //according to Google maps
            'longitude' => '-6.2535996746541676', //according to Google maps
        ],
        self::ALL_HALLOWS => [
            'label' => 'All Hallows',
            'latitude' => '53.3709918169038', //according to Google maps
            'longitude' => '-6.2484166428755', //according to Google maps
        ],
        self::DCU_ALPHA => [
            'label' => 'DCU Alpha',
            'latitude' => '53.37632457665991', //according to Google maps
            'longitude' => '-6.270646045526708', //according to Google maps
        ],
        self::ST_CLAIRE => [
            'label' => 'DCU Sports',
            'latitude' => '53.38152926399942', //according to Google maps
            'longitude' => '-6.268261332033288', //according to Google maps
        ]
    ];
}

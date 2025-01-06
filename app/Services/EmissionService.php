<?php

namespace App\Services;

use App\Lib\RouteType;
use App\Lib\SemesterType;
use App\Lib\TransportMode;
use App\Lib\TripJourney;
use App\Lib\UserRole;
use App\Models\CarbonEmission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmissionService
{
    public function emissionFormRules()
    {
        return [
            'trip_journey' => ['required', 'in:'.implode(',', array_keys(TripJourney::JOURNEYS))],
            'custom_week' => ['required_if:trip_journey,==,'. TripJourney::WEEKLY .'','regex:/^\d{4}-(5[0-2]|[1-4][0-9]|0[1-9])$/'], //format 2024-01 like year-weekNo
            'custom_month' => ['required_if:trip_journey,==,'. TripJourney::MONTHLY .'', 'date_format:Y-m'],
            'semester_year' => ['required_if:trip_journey,==,'. TripJourney::SEMESTER .'', 'regex:/^\d{4}-\d{4}$/'], //format 2024-2025 like year-year
            'semester_type' => ['required_if:trip_journey,==,'. TripJourney::SEMESTER .'', 'in:'.implode(',', array_keys(SemesterType::TYPES))],
            'custom_year' => ['required_if:trip_journey,==,'. TripJourney::ANNUAL .'', 'date_format:Y'],
            'custom_date' => ['required_if:trip_journey,==,'. TripJourney::CUSTOM .'', 'regex:/^\d{2}-\d{2}-\d{4} - \d{2}-\d{2}-\d{4}$/'], //format 01-12-2024 - 01-12-2024 like d-m-Y - d-m-Y
            'starting_latitude' => ['required'],
            'starting_longitude' => ['required'],
            'destination_latitude' => ['required'],
            'destination_longitude' => ['required'],
            'transport_method' => ['required', 'in:'.implode(',', array_keys(TransportMode::MODES))],
            'work_days' => ['required_unless:trip_journey,'. TripJourney::DAILY .'', 'between:1,5'],
            'route_type' => ['required', 'in:'.implode(',', array_keys(RouteType::TYPES))],
            'route_distance' => ['required', 'gt:0'],
        ];
    }

    public function getEmissionStats()
    {
        return $this->emissionStatQuery()->first();
    }

    public function getEmissionStatsByUser($request=null)
    {
        $user = auth()->user();
        $format = 'Y-m-d';
        $startDate =   ($request && $request->start_date) ? Carbon::parse($request->start_date)->format($format) : null;
        $endDate = ($request && $request->end_date) ? Carbon::parse($request->end_date)->format($format) : null;

        $statQuery = $this->emissionStatQuery()
        ->when($user, function ($query) use ($user) {
            if ($user->user_role != UserRole::ADMIN_ROLE) {
                $query->where('user_id', $user->id);
            }
        });

        if ($startDate && $endDate) {
            $statQuery->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }

        return $statQuery->first();
    }

    public function emissionExists()
    {
        return CarbonEmission::where('user_id', auth()->user()->id)->where('journey_end_date', '>=', Carbon::today()->format('Y-m-d'))->exists();
    }

    public function getEmissionQuery()
    {
        $user = auth()->user();

        return CarbonEmission::when($user, function ($query) use ($user) {
                    if ($user->user_role != UserRole::ADMIN_ROLE) {
                        $query->where('user_id', $user->id);
                    }
                });
    }

    private function emissionStatQuery()
    {
        return CarbonEmission::selectRaw('
            COUNT(*) as total_records,              
            SUM(distance) as total_distance, 
            SUM(carbon_emission) as total_carbon_emission
        ');
    }
}
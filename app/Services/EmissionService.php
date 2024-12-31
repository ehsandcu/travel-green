<?php

namespace App\Services;

use App\Lib\UserRole;
use App\Models\CarbonEmission;
use Carbon\Carbon;

class EmissionService
{
    public function getEmissionStats()
    {
        return $this->emissionStatQuery()->first();
    }

    public function getEmissionStatsByUser()
    {
        $user = auth()->user();

        return $this->emissionStatQuery()
                ->when($user, function ($query) use ($user) {
                    if ($user->user_role != UserRole::ADMIN_ROLE) {
                        $query->where('user_id', $user->id);
                    }
                })->first();
    }

    public function emissionExists()
    {
        return CarbonEmission::where('user_id', auth()->user()->id)->where('journey_end_date', '>=', Carbon::today()->format('Y-m-d'))->exists();
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
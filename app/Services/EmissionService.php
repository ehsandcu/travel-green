<?php

namespace App\Services;

use App\Lib\UserRole;
use App\Models\CarbonEmission;

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

    private function emissionStatQuery()
    {
        return CarbonEmission::selectRaw('
            COUNT(*) as total_records,              
            SUM(distance) as total_distance, 
            SUM(carbon_emission) as total_carbon_emission
        ');
    }
}
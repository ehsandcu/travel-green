<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Lib\DcuCampus;
use App\Lib\UserRole;
use App\Models\CarbonEmission;
use App\Services\EmissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('getAllCampusesGraphData');
    }
    
    public function index()
    {
        return view('dashboard.emission.index');
    }

    public function getGraphData(Request $request)
    {
        $format = 'Y-m-d';
        $startDate =   ($request && $request->start_date) ? Carbon::parse($request->start_date)->format($format) : null;
        $endDate = ($request && $request->end_date) ? Carbon::parse($request->end_date)->format($format) : null;
        $dateRangeStatus = ($startDate != $endDate);
      
        $dateInterval = $dateRangeStatus ? "P1D" : "PT1H"; // P1D:per day , PT1H:per hour

        $datePeriodStartDate = $dateRangeStatus ? $startDate : date($format);
        $datePeriodEndDate = $dateRangeStatus ? $endDate : date($format);

        $query = $date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($datePeriodStartDate)->format($format). '00:00:00');
        $end = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($datePeriodEndDate)->format($format). '23:59:59');
        $user = auth()->user();
        
        if ($dateRangeStatus) {
            $graphQuery = CarbonEmission::selectRaw('
                            COUNT(*) as total_records,         
                            SUM(distance) as total_distance, 
                            SUM(carbon_emission) as total_carbon_emission,
                            date_format(created_at,"%Y-%m-%d") as dates
                        ')->when($user, function ($query) use ($user) {
                            if ($user->user_role != UserRole::ADMIN_ROLE) {
                                $query->where('user_id', $user->id);
                            }
                        });   

            $graphQuery->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
                ->groupBy('dates')
                ->orderby('dates'); // get data of date range
        } else {
            $graphQuery = CarbonEmission::selectRaw('
                            COUNT(*) as total_records,         
                            SUM(distance) as total_distance, 
                            SUM(carbon_emission) as total_carbon_emission,
                            date_format(created_at,"%H") as hours
                        ')->when($user, function ($query) use ($user) {
                            if ($user->user_role != UserRole::ADMIN_ROLE) {
                                $query->where('user_id', $user->id);
                            }
                        }); 

            $graphQuery->where(DB::raw('DATE(created_at)'), '=', $datePeriodStartDate)
                ->groupBy('hours')
                ->orderby('hours'); // get data of current day
        }

        $graph = $graphQuery->get();

        if(count($graph) === 0) {
            return [
                'success' => 0,
                'labels' => [],
                'emission' => [],
                'total_records' => [],
            ];
        }

        $period = new \DatePeriod(new \DateTime($date), (new \DateInterval($dateInterval)), $end);

        foreach ($period as $date_) {
            $column = $dateRangeStatus ? 'dates' : 'hours';
            $columnValue = $dateRangeStatus ? $date_->format($format) : $date_->format('H') ;
            $exist = $graph->where($column, $columnValue);

            $label = $dateRangeStatus ? Carbon::parse($date_)->format($format) : Carbon::parse($date_)->format('gA');

            if ($exist->count()) {
                $v = $exist->values()[0];
                $y = number_format((float)($v->total_carbon_emission), 2, '.', '');
                $y2 = $v->total_records;
            } else {
                $y = 0.0;
                $y2 = 0;
            }
            
            $response['labels'][] = $label;
            $response['emission'][] = $y;
            $response['total_records'][] = $y2;
        }

        return $response;
    }

    public function getGraphDataByCampuses(Request $request)
    {
        $user = auth()->user();
        $format = 'Y-m-d';
        $startDate = ($request && $request->start_date) ? Carbon::parse($request->start_date)->format($format) : null;
        $endDate = ($request && $request->end_date) ? Carbon::parse($request->end_date)->format($format) : null;
        $latLngToCampus = getCampusesLatLng();

        $latLngs = array_keys($latLngToCampus);

        $campusQuery = CarbonEmission::select('destination_latlng')
            ->selectRaw('SUM(carbon_emission) AS total_emission')
            ->selectRaw('ROUND(SUM(carbon_emission) / (SELECT SUM(carbon_emission) FROM carbon_emission) * 100, 2) AS percentage')
            ->whereIn('destination_latlng', $latLngs)
            ->when($user, function ($query) use ($user) {
                if ($user->user_role != UserRole::ADMIN_ROLE) {
                    $query->where('user_id', $user->id);
                }
            }
        );
        
        if ($startDate && $endDate) {
            $campusQuery->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        
        $campusResult = $campusQuery->groupBy('destination_latlng')->get();
        
        $resultWithCampus = $campusResult->map(function ($item) use ($latLngToCampus) {
            if (isset($item->destination_latlng)) {
                $item->campus_name = DcuCampus::CAMPUSES[$latLngToCampus[$item->getRawOriginal('destination_latlng')]]['label'] ?? 'Unknown Campus';
                return $item;
            }
        });

        return $this->sendResponse([
            'success' => 1,
            'message' => "Data Listed Successfully.",
            'labels' => $resultWithCampus->pluck('campus_name') ?? [],
            'percentages' => $resultWithCampus->pluck('percentage') ?? [],
            'emit_stats' => (new EmissionService())->getEmissionStatsByUser($request),
        ]);
    }

    public function getAllCampusesGraphData(Request $request)
    {
        try {
            $campuses = DcuCampus::CAMPUSES;
            $format = 'Y-m-d';
            $now = Carbon::now();
            $currentYear = $now->copy()->year;
            $startDate = $now->copy()->startOfYear()->format($format); // start date of current year
            $endDate = $now->copy()->endOfYear()->format($format); // end date of current year
            
            $latLngToCampus = getCampusesLatLng();

            $latLngs = array_keys($latLngToCampus);

            $carbonEmissions = CarbonEmission::select(
                'destination_latlng',
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(carbon_emission) as total_emission')
            )
            ->whereIn('destination_latlng', $latLngs)
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->groupBy('month')
            ->groupBy('destination_latlng', 'month')
            ->get();
            
            $monthsList = [];
            $chartData = collect($campuses)->map(function ($campus) use ($carbonEmissions, &$monthsList) {
                return [
                    'name' => $campus['label'],
                    'data' => collect(range(1, 12))->map(function ($month) use ($carbonEmissions, $campus, &$monthsList) {
                        // Add month name to the list if not already added
                        if (!in_array(Carbon::create()->month($month)->format('M'), $monthsList)) {
                            $monthsList[] = Carbon::create()->month($month)->format('M');
                        }

                        return  $carbonEmissions->filter(function ($record) use ($month, $campus) {
                                    return  $record->month === $month && 
                                            $record->destination_latlng === json_decode('{"lat":"'.$campus['latitude'].'","lng":"'.$campus['longitude'].'"}', true);
                                })
                                ->sum('total_emission') ?? 0; // Default to 0 if no data
                    })->toArray()
                ];
            })->toArray();
           
            return $this->sendResponse([
                'success' => 1,
                'message' => "Data Listed Successfully.",
                'data' => array_values($chartData),
                'year' => $currentYear,
                'month_list' => $monthsList
            ]);
        } catch (\Throwable $th) {
            return $this->sendResponse([
                'success' => 0,
                'message' => $th->getMessage()
            ]);
        }
    }
}

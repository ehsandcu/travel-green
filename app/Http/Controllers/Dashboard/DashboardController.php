<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CarbonEmission;
use App\Services\EmissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $emitStats = (new EmissionService())->getEmissionStatsByUser();
       
        return view('dashboard.emission.index', compact('emitStats'));
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
        
        if ($dateRangeStatus) {
            $graphQuery = CarbonEmission::selectRaw('
                            COUNT(*) as total_records,         
                            SUM(distance) as total_distance, 
                            SUM(carbon_emission) as total_carbon_emission,
                            date_format(created_at,"%Y-%m-%d") as dates
                        ');   

            $graphQuery->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
                ->groupBy('dates')
                ->orderby('dates'); // get data of date range
        } else {
            $graphQuery = CarbonEmission::selectRaw('
                            COUNT(*) as total_records,         
                            SUM(distance) as total_distance, 
                            SUM(carbon_emission) as total_carbon_emission,
                            date_format(created_at,"%H") as hours
                        '); 

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
            $columnValue = $dateRangeStatus ? $date_->format($format)  : $date_->format('H') ;
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
}

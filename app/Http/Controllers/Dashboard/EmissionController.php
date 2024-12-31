<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Lib\RouteType;
use App\Lib\SemesterType;
use App\Lib\TransportMode;
use App\Lib\TripJourney;
use App\Models\CarbonEmission;
use App\Services\EmissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {    
        $emissionExists = (new EmissionService())->emissionExists();

        // return view('dashboard.map'); //geoapify implimented
        return view('dashboard.index', compact('emissionExists')); //google map implemented
    }

    public function storeEmission(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
        ]);
        
        if ($validator->fails()) {
            return $this->sendResponse([
                'success' => 0,
                'message' => $validator->errors()->first(),
            ]);
        }
        
        $emissionExists = (new EmissionService())->emissionExists();

        if ($emissionExists) {
            return $this->sendResponse([
                'success' => 0,
                'message' => 'Form already submitted. You cannot submit another one at this time.',
            ]);  
        }

        $transportMode = $request->transport_method;
        $workDays = $request->work_days ?? null;
        $routeDistance = $request->route_distance;
        $routeType = $request->route_type;

        $tripJourney = $request->trip_journey;
        $formatDate = 'Y-m-d';
        $currentDate = Carbon::now()->format($formatDate);
        $journeyStartDate = $currentDate;
        $journeyEndDate = $currentDate;

        switch ($tripJourney) {
            case TripJourney::DAILY :
                $journeyStartDate = $currentDate;
                $journeyEndDate = $currentDate;

                break;
            
            case TripJourney::WEEKLY :
                $customWeek = $request->custom_week; //year-weekNo
                $splitWeekString = explode('-', $customWeek);
                $todayDate = Carbon::now();
                $todayDate->setISODate($splitWeekString[0], $splitWeekString[1]);

                $journeyStartDate = $todayDate->startOfWeek()->format($formatDate);
                $journeyEndDate = $todayDate->endOfWeek()->format($formatDate);
                
                $createData['custom_week'] = $request->custom_week;
                break;
            
            case TripJourney::MONTHLY :
                $customMonth = $request->custom_month; //year-monthNo
                $splitMonthString = explode('-', $customMonth);
                $year = $splitMonthString[0];
                $month = $splitMonthString[1];
                $customDate = Carbon::create($year, $month);

                $journeyStartDate = $customDate->startOfMonth()->format($formatDate);
                $journeyEndDate = $customDate->lastOfMonth()->format($formatDate);
                
                $createData['custom_month'] = $request->custom_month;
                break;
            
            case TripJourney::SEMESTER :
                $semesterType = $request->semester_type;
                $semesterYear = $request->semester_year; //year-year

                $splitSemesterYear = explode('-', $semesterYear);
                $startYear = $splitSemesterYear[0];
                $endYear = $splitSemesterYear[1];

                $semesterTypeData = SemesterType::TYPES[$semesterType];
                $splitSemesterLabel = explode('-', $semesterTypeData['label']);
                $semesterStartMonth = trim($splitSemesterLabel[0]);
                $semesterEndMonth = trim($splitSemesterLabel[1]);
                $semesterStartDate = $semesterTypeData['start_date'];
                $semesterEndDate = $semesterTypeData['end_date'];
                
                $startDateWithoutYear = $semesterStartDate .'-'. $semesterStartMonth ; //d-F
                $endDateWithoutYear = $semesterEndDate .'-'. $semesterEndMonth; //d-F
                
                switch ($semesterType) {
                    case SemesterType::WINTER :
                        $startDateWithYear = $startDateWithoutYear .'-'. $startYear; //d-F-Y
                        $endDateWithYear = $endDateWithoutYear .'-'. $startYear; //d-F-Y
                        break;
                        
                    case SemesterType::SPRING :
                        $startDateWithYear = $startDateWithoutYear .'-'. $endYear; //d-F-Y
                        $endDateWithYear = $endDateWithoutYear .'-'. $endYear; //d-F-Y
                        break;
                }
                
                $semesterDateFormat = 'd-F-Y';
                $journeyStartDate = Carbon::createFromFormat($semesterDateFormat, $startDateWithYear)->format($formatDate);
                $journeyEndDate = Carbon::createFromFormat($semesterDateFormat, $endDateWithYear)->format($formatDate);

                $createData['semester_type'] = $request->semester_type;
                $createData['semester_year'] = $request->semester_year;
                break;
                
            case TripJourney::ANNUAL :
                $customYear = $request->custom_year;

                $journeyStartDate = $customYear .'-'.'01'.'-'.'01'; //first date of given year
                $journeyEndDate = $customYear .'-'.'12'.'-'.'31'; //last date of given year

                $createData['custom_year'] = $request->custom_year;
                break;
            
            case TripJourney::CUSTOM :
                $customDate = $request->custom_date; //date-month-year - date-month-year
                $splitCustomDateString = explode(' - ', $customDate);
                $inputDateFormat = 'd-m-Y';

                $journeyStartDate = Carbon::createFromFormat($inputDateFormat, $splitCustomDateString[0])->format($formatDate);
                $journeyEndDate = Carbon::createFromFormat($inputDateFormat, $splitCustomDateString[1])->format($formatDate);

                $createData['custom_date'] = $request->custom_date;
                break;
            
            default:
                $journeyStartDate = $currentDate;
                $journeyEndDate = $currentDate;

                break;
        }

        $calculateDays = calculateDaysForDateRange($journeyStartDate, $journeyEndDate, $workDays);
        
        $createArr =  array_merge($createData, [
            'user_id' => auth()->user()->id,
            'trip_journey' => $tripJourney,
            'journey_start_date' => $journeyStartDate,
            'journey_end_date' => $journeyEndDate,
            // 'origin_address' => getAddressFromLatLng($request->starting_latitude, $request->starting_longitude), //if you have google map api use this
            // 'destination_address' => getAddressFromLatLng($request->destination_latitude, $request->destination_longitude), //if you have google map api use this
            'origin_address' => $request->starting_address,
            'destination_address' => $request->destination_address,
            'starting_latlng' => $request->all(),
            'destination_latlng' => $request->all(),
            'transport_mode' => $transportMode,
            'work_day_per_week' => $workDays,
            'distance' => $routeDistance,
            'route_type' => $routeType,
            'carbon_emission' => carbonEmission($transportMode, $calculateDays, $routeDistance, $routeType),
        ]);

        $carbonEmission = CarbonEmission::create($createArr);
        
        return $this->sendResponse([
            'success' => 1,
            'message' => $carbonEmission->carbon_emission .'kg of CO2 emissions.',
        ]);        
    }

    public function loadEmission(Request $request)
    {
        $columnIndex_arr = $request->input('order');
        $columnName_arr = $request->input('columns');
        $columnIndex = $columnIndex_arr[0]['column'];
        $columnSortOrder = $columnIndex_arr[0]['dir'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        
        $order_arr = $request->input('order');

        $draw = $request->input('draw');
        $limit = $request->input('length');
        $offset = $request->input('start');
        $searchKey = $request->input('search')['value'];
        
        $alterColumn = [
            'Origin' => 'origin_address',
            'Destination' => 'destination_address',
            'Trip Journey' => 'trip_journey',
            'Journey Start Date' => 'journey_start_date',
            'Journey End Date' => 'journey_end_date',
            'Journey Description' => 'journey_end_date',
            'Travel Mode' => 'transport_mode',
            'Work Days/Week' => 'work_day_per_week',
            'Distance' => 'distance',
            'Carbon Emission' => 'carbon_emission',
            'Calculated At' => 'created_at',
        ];

        $emissionQuery = CarbonEmission::whereUserId(auth()->user()->id)->orderBy($alterColumn[$columnName], $columnSortOrder);

        if (!empty($searchKey)) {
            $searchKey = trim($searchKey);
            $emissionQuery->where(function ($query) use ($searchKey) {
                $query->orWhere('origin_address', 'like', '%' . $searchKey . '%');
                $query->orWhere('destination_address', 'like', '%' . $searchKey . '%');
                $query->orWhere('trip_journey', 'like', '%' . $searchKey . '%');
                $query->orWhere('journey_start_date', 'like', '%' . $searchKey . '%');
                $query->orWhere('journey_end_date', 'like', '%' . $searchKey . '%');
                $query->orWhere('transport_mode', 'like', '%' . $searchKey . '%');
                $query->orWhere('work_day_per_week', 'like', '%' . $searchKey . '%');
                $query->orWhere('distance', 'like', '%' . $searchKey . '%');
                $query->orWhere('carbon_emission', 'like', '%' . $searchKey . '%');
                $query->orWhere('created_at', 'like', '%' . $searchKey . '%');
            });
        }

        $totalRecords = $emissionQuery->count();
        $carbonEmissions = $emissionQuery->skip($offset)->take($limit)->get();
        
        $aaData = [];

        foreach ($carbonEmissions as $emission) {
            $tripJourney = '<span class="badge badge-'. TripJourney::JOURNEYS[$emission->trip_journey]['color'] .'">'. TripJourney::JOURNEYS[$emission->trip_journey]['label'] .'</span>';

            $data['Origin'] = $emission->origin_address ?? 'N/A';
            $data['Destination'] = $emission->destination_address ?? 'N/A';
            $data['Trip Journey'] =  $tripJourney;
            $data['Journey Start Date'] =  $emission->journey_start_date ?? 'N/A';
            $data['Journey End Date'] =  $emission->journey_end_date ?? 'N/A';
            $data['Journey Description'] =  $emission->journey_description ?? 'N/A';
            $data['Travel Mode'] = TransportMode::MODES[$emission->transport_mode] ?? '';
            $data['Work Days/Week'] = $emission->work_day_per_week ?? '';
            $data['Distance'] = $emission->distance ?? '';
            $data['Carbon Emission'] = number_format(($emission->carbon_emission ?? ''), 2, '.', '');                
            $data['Calculated At'] = $emission->created_at->format('Y-m-d') ?? '-';                

            $aaData[] = $data;
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $aaData
        );
        return response()->json($response);
    }
}

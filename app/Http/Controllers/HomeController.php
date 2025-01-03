<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lib\SemesterType;
use App\Lib\TripJourney;
use App\Models\ContactUs;
use App\Models\Team;
use App\Services\EmissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {   
        $emissionsResult = (new EmissionService())->getEmissionStats();

        return view('home', compact('emissionsResult'));
    }

    public function services()
    {
        return view('services.index');
    }

    public function about()
    {
        $team = Team::get();

        return view('about.about', compact('team'));
    }

    public function contactUs()
    {
        return view('contact.index');
    }

    public function getCarbonCalculation(Request $request)
    {
        $validator = Validator::make($request->all(), (new EmissionService())->emissionFormRules());
        
        if ($validator->fails()) {
            return $this->sendResponse([
                'success' => 0,
                'message' => $validator->errors()->first(),
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
        $createData = [];
        
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
        $carbonEmission = carbonEmission($transportMode, $calculateDays, $routeDistance, $routeType);

        return $this->sendResponse([
            'success' => 1,
            'message' => 'Calculated CO2 emissions successfully.',
            'data' => $carbonEmission
        ]);  
    }

    public function storeContactUsInfo(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => ['required'],
                'last_name' => ['required'],
                'email' => ['required', 'email'],
                'message' => ['required'],
            ]);
            
            if ($validator->fails()) {
                return $this->sendResponse([
                    'success' => 0,
                    'message' => $validator->errors()->first(),
                ]);
            }
           
            $contactFormCreate = ContactUs::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'message' => $request->message,
            ]);
            
            return $this->sendResponse([
                'success' => 1,
                'message' => 'Thank you for reaching out! Your message has been successfully sent. Our team will get back to you as soon as possible.',
            ]);  
        } catch (\Throwable $th) {
            return $this->sendResponse([
                'success' => 0,
                'message' => $th->getMessage(),
            ]);
        }
        
    }
}
<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Lib\TransportMode;
use App\Models\CarbonEmission;
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
        $emitList = CarbonEmission::all();
       
        return view('dashboard.emission.index', compact('emitList'));
    }

    public function storeEmission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'starting_latitude' => ['required'],
            'starting_longitude' => ['required'],
            'destination_latitude' => ['required'],
            'destination_longitude' => ['required'],
            'transport_method' => ['required', 'in:'.implode(',', array_keys(TransportMode::MODES))],
            'work_days' => ['required', 'gt:0'],
            'route_distance' => ['required', 'gt:0'],
        ]);

        if ($validator->fails()) {
            return $this->sendResponse([
                'success' => 0,
                'message' => $validator->errors()->first(),
            ]);
        }

        $transportMode = $request->transport_method;
        $workDays = $request->work_days;
        $routeDistance = $request->route_distance;

        $carbonEmission = CarbonEmission::create([
            'user_id' => auth()->user()->id,
            'origin_address' => getAddressFromLatLng($request->starting_latitude, $request->starting_longitude),
            'starting_latlng' => $request->all(),
            'destination_address' => getAddressFromLatLng($request->destination_latitude, $request->destination_longitude),
            'destination_latlng' => $request->all(),
            'transport_mode' => $transportMode,
            'work_day_per_week' => $workDays,
            'distance' => $routeDistance,
            'carbon_emission' => carbonEmission($transportMode, $workDays, $routeDistance),
        ]);
        
        return $this->sendResponse([
            'success' => 1,
            'message' => 'Data calculated successfully.',
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
            'Travel Mode' => 'transport_mode',
            'Work Days/Week' => 'work_day_per_week',
            'Distance' => 'distance',
            'Carbon Emission' => 'carbon_emission',
        ];

        $emissionQuery = CarbonEmission::whereUserId(auth()->user()->id)->orderBy($alterColumn[$columnName], $columnSortOrder);

        if (!empty($searchKey)) {
            $searchKey = trim($searchKey);
            $emissionQuery->where(function ($query) use ($searchKey) {
                $query->orWhere('origin_address', 'like', '%' . $searchKey . '%');
                $query->orWhere('destination_address', 'like', '%' . $searchKey . '%');
                $query->orWhere('transport_mode', 'like', '%' . $searchKey . '%');
                $query->orWhere('work_day_per_week', 'like', '%' . $searchKey . '%');
                $query->orWhere('distance', 'like', '%' . $searchKey . '%');
                $query->orWhere('carbon_emission', 'like', '%' . $searchKey . '%');
            });
        }

        $totalRecords = $emissionQuery->count();
        $carbonEmissions = $emissionQuery->skip($offset)->take($limit)->get();
        
        $aaData = [];

        foreach ($carbonEmissions as $emission) {
            $data['Origin'] = $emission->origin_address ?? 'N/A';
            $data['Destination'] = $emission->destination_address ?? 'N/A';
            $data['Travel Mode'] = TransportMode::MODES[$emission->transport_mode] ?? '';
            $data['Work Days/Week'] = $emission->work_day_per_week ?? '';
            $data['Distance'] = $emission->distance ?? '';
            $data['Carbon Emission'] = $emission->carbon_emission ?? '';                

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

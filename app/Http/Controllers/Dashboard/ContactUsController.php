<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Lib\UserRole;
use App\Models\CarbonEmission;
use App\Models\ContactUs;
use App\Services\EmissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('dashboard.contact.index');
    }

    public function showContact($id)
    {
        $getContact = ContactUs::findOrFail($id);

        return view('dashboard.contact.show', compact('getContact'));
    }

    public function loadContactUsList(Request $request)
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
            'Name' => 'first_name',
            'Email' => 'email',
            'Message' => 'message',
            'Received At' => 'created_at',
        ];

        $contactUsQuery = ContactUs::orderBy($alterColumn[$columnName], $columnSortOrder);

        if (!empty($searchKey)) {
            $searchKey = trim($searchKey);
            $contactUsQuery->where(function ($query) use ($searchKey) {
                $query->orWhere('first_name', 'like', '%' . $searchKey . '%');
                $query->orWhere('last_name', 'like', '%' . $searchKey . '%');
                $query->orWhere('email', 'like', '%' . $searchKey . '%');
                $query->orWhere('message', 'like', '%' . $searchKey . '%');
                $query->orWhere('created_at', 'like', '%' . $searchKey . '%');
            });
        }

        $totalRecords = $contactUsQuery->count();
        $contactUsList = $contactUsQuery->skip($offset)->take($limit)->get();
        
        $aaData = [];

        foreach ($contactUsList as $contact) {
            $data['Name'] = $contact->name ?? 'N/A';
            $data['Email'] = $contact->email ?? 'N/A';
            $data['Message'] = $contact->message ?? 'N/A';
            $data['Received At'] =  $contact->received_at ?? 'N/A';        
            $data['Action'] =  '<a href= "'.route('contact_us.show', ['id' => $contact->id]) .'" style="color:inherit;"><div class="typcn icon typcn-eye"></div></a>';    

            $aaData[] = $data;
        }

        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $aaData,
        ];
        return response()->json($response);
    }
}

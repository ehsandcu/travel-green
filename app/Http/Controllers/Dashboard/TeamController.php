<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('dashboard.team.index');
    }

    public function loadTeamList(Request $request)
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
            'Name' => 'name',
            'Position' => 'position',
            'Link' => 'link',
        ];

        $teamQuery = Team::orderBy($alterColumn[$columnName], $columnSortOrder);

        if (!empty($searchKey)) {
            $searchKey = trim($searchKey);
            $teamQuery->where(function ($query) use ($searchKey) {
                $query->orWhere('name', 'like', '%' . $searchKey . '%');
                $query->orWhere('position', 'like', '%' . $searchKey . '%');
                $query->orWhere('link', 'like', '%' . $searchKey . '%');
            });
        }

        $totalRecords = $teamQuery->count();
        $teamList = $teamQuery->skip($offset)->take($limit)->get();
        
        $aaData = [];

        foreach ($teamList as $member) {
            $data['Name'] = '<img src="'.asset( $member->image ).'" alt="Image" class="img-fluid rounded-20 mr-2"/><span>'.$member->name ?? 'N/A'.'</span>';
            $data['Position'] = $member->position ?? 'N/A';
            $data['Link'] =  '<a href="'. ($member->link ?? "#") .'" target="_blank">Profile</a>';

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

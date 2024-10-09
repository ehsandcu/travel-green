<?php

namespace App\Http\Controllers;

use App\Lib\UserType;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userInfo()
    {
        $loginUser = auth()->user();
        
        //check user type 
        if ($loginUser->type) {
            return redirect()->route('dashboard');
        }

       return view('user.info');
    }

    public function updateUserInfo(Request $request)
    {
        $validated = $request->validate([
            'user_type' => ['required', 'in:'.implode(',', array_keys(UserType::TYPES))],
        ]);

        $user = auth()->user();        
        $user->type = $request->user_type;
        $user->save();

        return redirect()->route('dashboard');
    }
}

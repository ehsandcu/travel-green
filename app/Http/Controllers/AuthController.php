<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->only('logout');
    }

    public function showLogin()
    {
        if(auth()->user()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'register_name' => ['required'],
            'register_email' => ['required', 'email','unique:users,email'],
            'new_password' => ['required','required_with:confirm_password', 'same:confirm_password'],
            'confirm_password' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->sendResponse([
                'success' => 0,
                'message' => $validator->errors()->first(),
            ]);
        }
        
        try {
            User::create([
                'name' => $request->register_name,
                'email' => $request->register_email,
                'password' => Hash::make($request->new_password),
            ]);

            return $this->sendResponse([
                'success' => 1,
                'message' => "Account successfully created!",
            ]);
        } catch (\Throwable $th) {
            return $this->sendResponse([
                'success' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_email' => ['required', 'email','exists:users,email'],
            'login_password' => ['required'],
        ]);
        
        if ($validator->fails()) {
            return $this->sendResponse([
                'success' => 0,
                'message' => $validator->errors()->first(),
            ]);
        }

        $user_data = [
            'email' => $request->get('login_email'), 
            'password' => $request->get('login_password')
        ];
     
        if (Auth::attempt($user_data)) {
            return $this->sendResponse([
                'success' => 1,
                'message' => 'Login Successful',
            ]);
        } else {
            return $this->sendResponse([
                'success' => 0,
                'message' => 'Sorry, Wrong Login Details, please try again',
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        
        return redirect()->route('home');
    }
}

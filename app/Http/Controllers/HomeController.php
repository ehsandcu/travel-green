<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Team;
use App\Services\EmissionService;
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
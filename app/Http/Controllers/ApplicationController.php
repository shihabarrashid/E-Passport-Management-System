<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Application;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ApplicationController extends Controller
{

     /* Set Schedule */
     public function setSchedule(Request $request)
     { 
      $dateValidate = $request->validate( 
         [
               'scheduled_at' => 'required',              
         ],
         [
               'scheduled_at.required' => 'Please Select Appointment Date',
         ]);

      $application = Application::find($request->id);


      if ($application){
            $application->scheduled_at = $request->scheduled_at;
            $application->status = 'biometric_pending';
            $application->save();
            return redirect()->route('applicant.dashboard');
      }else {
            Session::flash('error', 'Try Again!');
            return redirect()->route('applicant.dashboard'); 
        }
     }
}

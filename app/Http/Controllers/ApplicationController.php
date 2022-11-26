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

      /* Application Verified */
      public function applicationVerified($id)
      {
            $application = Application::find($id);
            $application->status = 'verified';
            $application->save();
            session()->flash('success', 'Application Verified!');
            return redirect()->route('officer.dashboard');
      }

      /* Application Rejected */
      public function applicationRejected(Request $request)
      {
            $application = Application::find($request->id);
            $application->issue = $request->issue;
            $application->status = 'rejected';
            $application->save();
            session()->flash('success', 'Application Rejected!');
            return redirect()->route('officer.dashboard');
      }

      /* Application Feedback */
      public function applicationFeedback(Request $request)
      {
            $formValidate = $request->validate( 
                  [
                        'stars' => 'required',              
                  ],
                  [
                        'stars.required' => 'Please Rate',
                  ]);
         
               $application = Application::find($request->id);
         
         
               if ($application){
                     $application->rating = $request->stars;
                     $application->feedback = $request->feedback;
                     $application->save();
                     return redirect()->route('applicant.dashboard');
               }else {
                     Session::flash('error', 'Try Again!');
                     return redirect()->route('applicant.dashboard'); 
                 }
      }
}

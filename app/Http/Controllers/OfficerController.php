<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Applicant;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class OfficerController extends Controller
{
    /* Authenticate Officer Credentials */
    public function authenticate(Request $req)
    {
        $credValidate = $req->validate(
            [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
            ],
            [
                'email.required' => 'Please enter your Email!',
                'password.required' => 'Please enter your Password!'
            ]
        );

        $officer = User::where('email', '=', $req->email)->first();

        if ($officer->type == 'officer'){
            if (auth()->attempt($credValidate)) {
                if (Hash::check($req->password, $officer->password)) {
                    $req->session()->regenerate();
                    return redirect()->route('officer.dashboard');
                }
                else {
                    Session::flash('error', 'Invalid Email or Password!');
                    return redirect()->route('officer.signIn');
                }
            }  else {
                Session::flash('error', 'Invalid Email or Password!');
                return redirect()->route('officer.signIn'); 
            }
        }else {
                Session::flash('error', 'Invalid Email or Password!');
                return redirect()->route('officer.signIn'); 
        }
        
    }

       /* Officer SignIn */
       public function signIn()
       {
           return view('officer.signIn');
       }
   
       /*Officer Dashboard */
       public function dashboard()
       {
           return view('officer.dashboard');
       }

       /*Officer Pending Applications */
       public function pendingApplication()
       {
            $applications = Application::where('status', 'uploaded')->get();
           return view('officer.pendingApplication', compact('applications'));
       }

       /*Officer Verified Applications */
       public function verifiedApplication()
       {
            $applications = Application::where('status', 'verified')->get();
           return view('officer.verifiedApplication', compact('applications'));
       }

       /*Officer Rejected Applications */
       public function rejectedApplication()
       {
            $applications = Application::where('status', 'rejected')->get();
           return view('officer.rejectedApplication', compact('applications'));
       }
   
       /* Officer Logout */
       public function logout(Request $req)
       {
           auth()->logout();
   
           $req->session()->invalidate();
           $req->session()->regenerateToken();
   
           Session::flash('success', 'Logged Out Successfully');
           return redirect()->route('officer.signIn');
       }
   
       /*Officer Account */
       public function account()
       {
           return view('officer.account');
       }
}

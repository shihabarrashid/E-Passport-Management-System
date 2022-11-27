<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Applicant;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
         $heading = 'Pending';
        return view('officer.application', compact('applications', 'heading'));
    }

    /*Officer Verified Applications */
    public function verifiedApplication()
    {
         $applications = Application::where('status', 'verified')->get();
         $heading = 'Verified';
         return view('officer.application', compact('applications', 'heading'));
    }

    /*Officer Rejected Applications */
    public function rejectedApplication()
    {
         $applications = Application::where('status', 'rejected')->get();
         $heading = 'Rejected';
         return view('officer.application', compact('applications', 'heading'));
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

       

    /* Officer Update */
    public function update(Request $req)
    {
        $formVal = $req->validate(
            [
                'name' => 'required|max:30',
                'email' => 'required|email|ends_with:.com,.me,.edu',
                'password' => 'required',
            ],
    
            [
                "name.required" => "This field is required",
                "email.required" => "This field is required",
                "password.required" => "This field is required",
                "name.max" => "Name should not exceed 30 characters"
            ]
          );

        if (Hash::check($formVal['password'], Auth::user()->password, [])) {
            $formVal['password'] = bcrypt($formVal['password']);
        } else {
            $formVal['password'] = bcrypt($formVal['password']);
        }

        $user = User::find(auth()->user()->id);
        $user->update($formVal);

        Session::flash('msg', 'Profile Updated');

        return redirect()->route('officer.dashboard');
    }

    /* Application Feedback */
    public function applicationFeedback(Request $req)
    {
        $applications = Application::where('rating', '!=', null)->get();
        $heading = 'Feedback';
        return view('officer.feedback', compact('applications', 'heading'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Applicant;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    /* Authenticate Applicant Credentials */
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

        $applicant = User::where('email', '=', $req->email)->first();

        if ($applicant->type == 'applicant'){
            if (auth()->attempt($credValidate)) {
                if (Hash::check($req->password, $applicant->password)) {
                    $req->session()->regenerate();
                    return redirect()->route('applicant.dashboard');
                }
                else {
                    Session::flash('error', 'Invalid Email or Password!');
                    return redirect()->route('applicant.signIn');
                }
            }  else {
                Session::flash('error', 'Invalid Email or Password!');
                return redirect()->route('applicant.signIn'); 
            }
        }else {
                Session::flash('error', 'Invalid Email or Password!');
                return redirect()->route('applicant.signIn'); 
        }
        
    }

    /* Applicant SignIn */
    public function signIn()
    {
        return view('home');
    }

    /*Applicant Dashboard */
    public function dashboard()
    {
        $user_id = auth()->user()->id;
        $applications = Application::where('user_id', $user_id)->get();
        return view('applicant.dashboard', compact('applications'));
    }

    /* Applicant Logout */
    public function logout(Request $req)
    {
        auth()->logout();

        $req->session()->invalidate();
        $req->session()->regenerateToken();

        Session::flash('success', 'Logged Out Successfully');
        return redirect()->route('applicant.signIn');
    }

    /*Applicant Account */
    public function account()
    {
        return view('applicant.account');
    }

    /* Applicant Update */
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

        return redirect()->route('applicant.dashboard');
    }
}

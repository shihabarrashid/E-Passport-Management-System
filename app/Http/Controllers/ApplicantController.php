<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
    }

    /* Applicant SignIn */
    public function signIn(Request $req)
    {
        return view('home');
    }

    /*Applicant Dashboard */
    public function dashboard()
    {
        return view('applicant.dashboard');
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
}
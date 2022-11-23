<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

/* APPLICANT ROUTES */
Route::controller(ApplicantController::class)->group(function () {
    //Authenticate Applicant Credentials
    Route::post('/apllicant/authenticate',  'authenticate') 
    -> name('applicant.authenticate');

    //Applicant SignIn
    Route::get('/applicant/sign-in',  'signIn') 
    -> name('applicant.signIn');

    //Applicant Dashboard
    Route::get('/applicant/dashboard',  'dashboard') 
    -> name('applicant.dashboard');

    //Applicant Logout
    Route::get('/applicant/logout',  'logout') 
    -> name('applicant.logout');

});



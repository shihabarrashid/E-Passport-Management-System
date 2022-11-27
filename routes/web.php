<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicationController;


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

    //Applicant Account
    Route::get('/applicant/account',  'account') 
    -> name('applicant.account');

    //Applicant Update
    Route::post('/applicant/update',  'update') 
    -> name('applicant.update');
});

/* APPLICATION ROUTES */
Route::controller(ApplicationController::class)->group(function () {
    //Set Schedule
    Route::post('/applicant/set-schedule',  'setSchedule') 
    -> name('set.schedule');

    //Application Verified
    Route::get('/application/verified/{id}',  'applicationVerified')
    -> name('application.verified');

    //Application Rejected
    Route::post('/application/rejected',  'applicationRejected')
    -> name('application.rejected');

    //Application Feedback
    Route::post('/application/feedback',  'applicationFeedback')
    -> name('application.feedback');
});

/* DOCUMENTS ROUTES */
Route::controller(DocumentController::class)->group(function () {
    //Upload Documents
    Route::post('/applicant/upload-documents',  'uploadDocuments') 
    -> name('documents.store');

    //PDF Generate
    Route::get('/officer/application/pdf/{id}',  'pdfGenerate') 
    -> name('pdf.generate');
});

/* OFFICER ROUTES */
Route::controller(OfficerController::class)->group(function () {
    //Authenticate Officer Credentials
    Route::post('/officer/authenticate',  'authenticate') 
    -> name('officer.authenticate');

    //Officer SignIn
    Route::get('/officer/sign-in',  'signIn') 
    -> name('officer.signIn');

    //Officer Dashboard
    Route::get('/officer/dashboard',  'dashboard') 
    -> name('officer.dashboard');

    //Officer Logout
    Route::get('/officer/logout',  'logout') 
    -> name('officer.logout');

    //Officer Account
    Route::get('/officer/account',  'account') 
    -> name('officer.account');

    //Officer Pending Applications
    Route::get('/officer/pending-application',  'pendingApplication') 
    -> name('pending.application');

    //Officer Verified Applications
    Route::get('/officer/verified-application',  'verifiedApplication') 
    -> name('verified.application');

    //Officer Rejected Applications
    Route::get('/officer/rejected-application',  'rejectedApplication') 
    -> name('rejected.application');

    //Officer Update
    Route::post('/officer/update',  'update') 
    -> name('officer.update');

    //Applications Feedback
    Route::get('/officer/application-feedback',  'applicationFeedback') 
    -> name('officer.feedback');
});



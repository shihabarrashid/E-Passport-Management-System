<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Document;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
   /* Upload Dcouments */
   public function uploadDocuments(Request $request)
   {
    $docValidate = $request->validate( 
    [
          'nid' => 'required| image',
          'birth_certificate' => 'required| image',
          'passport' => 'image',
          'national_certificate' => 'required| image',
          'go_noc' => 'image',
          'tin_certificate' => 'image'
         
    ],
    [
          'nid.required' => 'Please Upload NID',
          'nid.image' => 'Please select an image',
          'birth_certificate.required' => 'Please Upload Birth Certificate',
          'birth_certificate.image' => 'Please select an image',
          'passport.image' => 'Please select an image',
          'national_certificate.required' => 'Please Upload Nationality Certificate',
          'national_certificate.image' => 'Please select an image',
          'go_noc.image' => 'Please select an image',
          'tin_certificate.image' => 'Please select an image',
    ]);

    $newNid = time() . '-ID-' . $request->id . '-NID.' . $request->nid->getClientOriginalExtension();
    $request->nid->move(public_path('storage/images'), $newNid);

    $newBirthCertificate = time() . '-ID-' . $request->id . '-BirthCertificate.'. $request->birth_certificate->getClientOriginalExtension();
    $request->birth_certificate->move(public_path('storage/images'), $newBirthCertificate);

    $newNationalCertificate = time() . '-ID-' . $request->id . '-NationalCertificate.' . $request->national_certificate->getClientOriginalExtension();
    $request->national_certificate->move(public_path('storage/images'), $newNationalCertificate);

    if($request->passport != null){
       $newPassport = time() . '-ID-' . $request->id . '-Passport.' . $request->passport->getClientOriginalExtension();
       $request->passport->move(public_path('storage/images'), $newPassport);
    }

    if($request->go_noc != null){
       $newGoNoc = time() . '-ID-' . $request->id . '-GoNoc.' . $request->go_noc->getClientOriginalExtension();
       $request->go_noc->move(public_path('storage/images'), $newGoNoc);
    }

    if($request->tin_certificate != null){
       $newTinCertificate = time() . '-ID-' . $request->id . '-TinCertificate.' . $request->tin_certificate->getClientOriginalExtension();
       $request->tin_certificate->move(public_path('storage/images'), $newTinCertificate);
    }
   
    $document = new Document;
    $document->application_id = $request->id;
    $document->nid = $newNid;
    $document->birth_certificate = $newBirthCertificate;
    $document->national_certificate = $newNationalCertificate;

    if($request->passport != null){
       $document->passport = $newPassport;
    }
    if($request->go_noc != null){
       $document->go_noc = $newGoNoc;
    }
    if($request->tin_certificate != null){
       $document->tin_certificate = $newTinCertificate;
    }

    $document->save();

    $application = Application::find($request->id);
    $application->status = 'uploaded';
    $application->save();

    return redirect()->route('applicant.dashboard');
   }
    

   /* PDF Generate */
   public function pdfGenerate($id){

      $application = Application::find($id);
      $document = Document::where('application_id', '=', $id)->first();

      $pdfView = PDF::loadView('PDF.pdf-generate', compact('application', 'document'));

      return $pdfView->download($application->name.'-documents.pdf');
   }
}

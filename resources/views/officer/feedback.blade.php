@extends('layouts.officer-layout')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-5 mb-2">
            <div>
                <h1>{{ $heading }} Passport Applications</h1>
            </div>
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        <table class="table border">
			<thead>
				<tr class="text-center">
					<th>#</th>
					<th>Applicant Name</th>
					<th>Status</th>
					<th colspan="2">Actions</th>
				</tr>
			</thead>

            @if(count($applications) > 0)
                <tbody>
                    @foreach($applications as $key=>$application)
                        <tr class="text-center">
                            <td>{{ ++$key }}</td>
                            <td>{{ $application->name }}</td>                                     
        
                            <td class="text-center">
                                @if($application->status == 'payment_done')
                                <span class="badge bg-success">Payment Done</span>
                                @elseif($application->status == 'uploaded')
                                <span class="badge bg-success">Documents Uploaded</span>
                                @elseif($application->status == 'verified')
                                <span class="badge bg-success">Documents Verified</span>
                                @elseif($application->status == 'rejected')
                                <span class="badge bg-danger">Documents Verification Rejected</span>
                                @elseif($application->status == 'biometric_pending')
                                <span class="badge bg-primary">Biometric Pending</span>
                                @elseif($application->status == 'in_process')
                                <span class="badge bg-success">Enrollment in Process</span>
                                @else
                                <span class="badge bg-secondary">No Status</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#feedbackModal" data-bs-id="{{ $application->id }}" data-bs-rating="{{$application->rating}}" data-bs-feedback="{{ $application->feedback }}" data-bs-toggle="tooltip" data-bs-placement="right" title="View Feedback"><i class="bi bi-arrows-fullscreen"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody> 
            @else
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center">No Applications Added!</td>
                    </tr>
                </tbody>
             @endif
        </table>    
    </div>


{{-- View Feedback Modal --}}
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="feedbackModalLabel">Applicants Feedback</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="application-rating" class="" style="vertical-align: 15px;">Rating:</label>
                    <div class="rating">
                        <label>
                            <input type="radio" name="stars" value="1" disabled id="star1"/>
                            <span class="icon">★</span>
                          </label>
                          <label>
                            <input type="radio" name="stars" value="2" disabled  id="star2"/>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                          </label>
                          <label>
                            <input type="radio" name="stars" value="3" disabled id="star3"/>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>   
                          </label>
                          <label>
                            <input type="radio" name="stars" value="4" disabled id="star4"/>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                          </label>
                          <label>
                            <input type="radio" name="stars" value="5" disabled id="star5"/>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                          </label>
                    </div>
                </div>    

                <div class="mb-3">
                    <label for="application-feedback" class="col-form-label">Feedback:</label>
                    <textarea class="form-control" id="application-feedback" rows="3" readonly disabled></textarea>
                </div>    
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

    <script>
        var feedbackModal = document.getElementById('feedbackModal')
        var applicationRating = document.getElementById('application-rating')
        var applicationFeedback = document.getElementById('application-feedback')

        feedbackModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var rating = button.dataset.bsRating
            var feedback = button.dataset.bsFeedback

            if(rating == 1)
            {
                document.getElementById('star1').checked = "true";
            }
            else if(rating == 2)
            {
                document.getElementById('star2').checked = "true";
            }
            else if(rating == 3)
            {
                document.getElementById('star3').checked = "true";
            }
            else if(rating == 4)
            {
                document.getElementById('star4').checked = "true";
            }
            else if(rating == 5)
            {
                document.getElementById('star5').checked = "true";
            }
            else{

            }
            applicationFeedback.value = feedback
        })
    </script>
@endsection
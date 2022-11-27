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
					<th>Uploaded Documents</th>
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
                            <td> <a href="{{ route('pdf.generate', ['id' => $application->id]) }}" class="btn btn-secondary">View Documents</a></td>                    
        
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
                                @if($application->status == 'uploaded')
                                    <a href="{{ route('application.verified', ['id' => $application->id]) }}" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="right" title="Verify"><i class="bi bi-check2"></i></a>

                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectApplicationModal" data-bs-id="{{ $application->id }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Reject">
                                        <i class="bi bi-x-lg"></i>
                                    </button>

                                @elseif($application->status == 'verified')
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectApplicationModal" data-bs-id="{{ $application->id }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Reject">
                                        <i class="bi bi-x-lg"></i>
                                    </button>

                                @elseif($application->status == 'rejected')
                                    <a href="{{ route('application.verified', ['id' => $application->id]) }}" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="right" title="Verify"><i class="bi bi-check2"></i></a>

                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#applicationIssueModal" data-bs-id="{{ $application->id }}" data-bs-issue="{{$application->issue}}" data-bs-toggle="tooltip" data-bs-placement="right" title="View Issue"><i class="bi bi-arrows-fullscreen"></i></button>
                                    
                                @else
                                <span class="badge bg-secondary">No Actions Available</span>
                                @endif
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

<!-- Reject Application -->
    <div class="modal fade" id="rejectApplicationModal" tabindex="-1" aria-labelledby="rejectApplicationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="rejectApplicationModalLabel">Reject Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="{{ route('application.rejected') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="application-id" value="">
                    <div class="form-group mb-3">
                        <label for="issue">Issue</label>
                        <textarea type="text" name="issue" class="form-control" id="issue" placeholder="Mention Application Issues Here" cols="20" rows="5"></textarea>
                        @error('issue')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group text-end">
                        <input type="submit" class="btn btn-danger" value="Reject Application">
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


{{-- View Issue Modal --}}
    <div class="modal fade" id="applicationIssueModal" tabindex="-1" aria-labelledby="applicationIssueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="applicationIssueModalLabel">Application Issue</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="application-issue" class="col-form-label">Issue:</label>
                    <textarea class="form-control" id="application-issue" rows="3" readonly disabled></textarea>
                </div>    
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

    <script>
        var rejectApplicationModal = document.getElementById('rejectApplicationModal');
        var applicationId = document.getElementById('application-id');

        rejectApplicationModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.dataset.bsId;
           
            applicationId.value = id;
        });
    </script>

    <script>
        var applicationIssueModal = document.getElementById('applicationIssueModal')
        var applicationIssue = document.getElementById('application-issue')

        applicationIssueModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var issue = button.dataset.bsIssue

            applicationIssue.value = issue
        })
    </script>
@endsection
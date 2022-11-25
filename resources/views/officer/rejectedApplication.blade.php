@extends('layouts.officer-layout')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-5 mb-2">
            <div>
                <h1>Rejected Passport Applications</h1>
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
				<tr>
					<th>#</th>
					<th>Applicant Name</th>
					<th>Uploaded Documents</th>
					<th>Status</th>
					<th colspan="2">Actions</th>
				</tr>
			</thead>

            @if(count($applications) > 0)
                <tbody>
                    @foreach($applications as $application)
                        <tr>
                            <td>{{ $application->id }}</td>
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
@endsection
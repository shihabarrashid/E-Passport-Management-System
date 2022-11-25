@extends('layouts.applicant-layout')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-5 mb-2">
            <div>
                <h1>My Passport Application</h1>
            </div>
            <div>
                <a class="btn btn-primary mt-2" href="#">Apply for a new E-Passport</a>
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
					<th>Passport Type</th>
					<th>Delivery Type</th>
					<th>Scheduled At</th>
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
                        <td>{{ $application->passport_type }}</td>
                        <td>{{ $application->delivery_type }}</td>
                        <td>{{ $application->scheduled_at }}</td>
                       
    
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
                            @if($application->status == 'payment_done')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadDocumentsModal" data-bs-id="{{ $application->id }}" data-bs-toggle="tooltip" title="Upload Documents">
                                <i class="bi bi-upload"></i>
                                </button>

                            @elseif($application->status == 'uploaded') 
                                <span class="badge bg-secondary">Wait Until Documents are Verified</span>

                            @elseif($application->status == 'verified') 
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#setScheduleModal" data-bs-id="{{ $application->id }}" data-bs-toggle="tooltip" title="Set Schedule">
                                <i class="bi bi-calendar3"></i>
                                </button>

                            @elseif($application->status == 'rejected') 
                                <button type="button" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#setScheduleModal" data-bs-id="{{ $application->id }}" data-bs-toggle="tooltip" title="View Issue">
                                <i class="bi bi-arrows-fullscreen"></i>

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadDocumentsModal" data-bs-id="{{ $application->id }}" data-bs-toggle="tooltip" title="Upload Documents Again">
                                <i class="bi bi-upload"></i>
                                </button>

                            @elseif($application->status == 'in_process') 
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#setScheduleModal" data-bs-id="{{ $application->id }}" data-bs-toggle="tooltip" title="Give your Feedback">
                                <i class="bi bi-star"></i>
                                </button>

                            @else
                                {{-- <span class="badge bg-secondary">No Actions Available</span> --}}
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

<!-- Upload Documents -->
    <div class="modal fade" id="uploadDocumentsModal" tabindex="-1" aria-labelledby="uploadDocumentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="uploadDocumentsModalLabel">Upload Documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="application-id" value="">
                    <div class="form-group mb-3">
                        <label for="nid">NID</label>
                        <input type="file" name="nid" class="form-control" id="nid">
                        @error('nid')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="birth_certificate">Birth Certificate</label>
                        <input type="file" name="birth_certificate" class="form-control" id="birth_certificate">
                        @error('birth_certificate')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="passport">Previous Passport (if any)</label>
                        <input type="file" name="passport" class="form-control" id="passport">
                        @error('passport')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="national_certificate">Nationality Certificate</label>
                        <input type="file" name="national_certificate" class="form-control" id="national_certificate">
                        @error('national_certificate')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="go_noc">GO/NOC for government service holder (if any)</label>
                        <input type="file" name="go_noc" class="form-control" id="go_noc">
                        @error('go_noc')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="tin_certificate">TIN Certificate (if any)</label>
                        <input type="file" name="tin_certificate" class="form-control" id="tin_certificate">
                        @error('tin_certificate')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group text-end">
                        <input type="submit" class="btn btn-success" value="Upload Documents">
                    </div>

                    </form>
                </div>
            </div>
        </div>
   </div>



<!-- Set Schedule -->
    <div class="modal fade" id="setScheduleModal" tabindex="-1" aria-labelledby="setScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="setScheduleModalLabel">Set Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="{{ route('set.schedule')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="a-id" value="">
                    <div class="form-group mb-3">
                        <label for="scheduled_at" class="form-label">Appoinment Date</label>
						<input type="datetime-local" class="form-control" name="scheduled_at" id="scheduled_at">
                        @error('scheduled_at')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group text-end">
                        <input type="submit" class="btn btn-success" value="Set Schedule">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var uploadDocumentsModal = document.getElementById('uploadDocumentsModal');
        var applicationId = document.getElementById('application-id');

        uploadDocumentsModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.dataset.bsId;
           
            applicationId.value = id;
        });
    </script>

    <script>
        var setScheduleModal = document.getElementById('setScheduleModal');
        var aId = document.getElementById('a-id');

        setScheduleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.dataset.bsId;
           
            aId.value = id;
        });
    </script>
@endsection
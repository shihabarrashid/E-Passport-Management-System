@extends('layouts.applicant-layout')
@section('content')
    <div class="mt-4">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Account
            </h2>
            <p class="mb-2">Edit Account Data</p>
        </header>

        <div class="d-flex align-items-center vh-100 flex-column mt-3">
            @if(session('error'))
                <div class="alert alert-danger">
                {{ session('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('applicant.update')}}" class="shadow-lg p-4 rounded">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input
                        type="text"
                        class="form-control input-width"
                        name="name"
                        value="{{auth()->user()->name}}"
                    />
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
    
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        class="form-control input-width"
                        name="email"
                        value="{{auth()->user()->email}}"
                    />
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact_no" class="form-label">Contact Number</label>
                    <input
                        type="contact_no"
                        class="form-control input-width"
                        name="contact_no"
                        value="{{auth()->user()->contact_no}}"
                    />
                    @error('contact_no')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        class="form-control input-width"
                        name="password"
                    />
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-success w-100">Update</button>
            </form>
        </div>    
    </div> 
@endsection
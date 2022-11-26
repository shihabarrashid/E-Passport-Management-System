@extends('layouts.applicant-layout')
@section('content')
    <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Account
            </h2>
            <p class="mb-4">Edit Account Data</p>
        </header>

        <div class="d-flex align-items-center vh-100 flex-column mt-5">
            @if(session('error'))
                <div class="alert alert-danger">
                {{ session('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('applicant.update')}}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input
                        type="text"
                        class=""
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
                        class=""
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
                        class=""
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
                        class=""
                        name="password"
                    />
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>    
    </div> 
@endsection
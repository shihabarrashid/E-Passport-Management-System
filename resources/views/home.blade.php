@extends('layouts.general-layout')
@section('content')
    <div class="d-flex align-items-center vh-100 flex-column mt-5">
        @if(session('error'))
            <div class="alert alert-danger">
            {{ session('error') }}
            </div>
        @endif
        <form method="POST" action="{{route('applicant.authenticate')}}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email">
                @error('email')
                  <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                @error('password')
                  <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>    
@endsection
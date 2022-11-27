@extends('layouts.officer-general-layout')
@section('content')
    <div class="container">
        <div class="mt-4">
            <header class="text-center">
                <h2 class="text-2xl font-bold uppercase mb-1">
                    Officer Portal Sign In
                </h2>
                <p class="mb-2">Sign In</p>
            </header>
            <div class="d-flex align-items-center vh-100 flex-column mt-3">
                @if(session('error'))
                    <div class="alert alert-danger">
                    {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{route('officer.authenticate')}}" class="shadow-lg p-4 rounded">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control input-width" placeholder="Enter Email">
                        @error('email')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control input-width" placeholder="Enter Password">
                        @error('password')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100">Submit</button>
                </form>
            </div>  
        </div>  
    </div>
@endsection
@extends('layouts.officer-layout')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-5 mb-2">
            <div>
                <h1>All Passport Applications</h1>
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
    </div>
@endsection
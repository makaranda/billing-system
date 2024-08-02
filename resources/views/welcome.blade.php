@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <h1>CRUD Operation</h1>
            </div>
            <div class="col-12 col-md-12">
                <a href="{{ route('student') }}" class="btn btn-lg btn-primary">View Student Table</a>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <style>

    </style>
@endpush

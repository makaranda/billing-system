@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <h1>Students</h1>
            <a href='{{ route('student.add') }}' class='btn btn-warning float-right'>Add Student</a>
        </div>
        <div class="col-12 col-md-12">
            <div class="table-responsive">
                <table class='table'>
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Phone</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>


                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student['name'] }}</td>
                                    <td>{{ $student['email'] }}</td>
                                    <td>{{ $student['phone'] }}</td>
                                    <td>{{ $student['status'] }}</td>
                                    <td><a href='{{ route('student.edit',$student['id']) }}' class='btn btn-primary'>Edit</a> | <a href='{{ route('student.delete',$student['id']) }}' class='btn btn-sm btn-danger'>Delete</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>

    </style>
@endpush

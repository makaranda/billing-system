@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-5">
                <h4 class="page-title">User Profile</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-7">
                <div class="text-end upgrade-btn">

                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 col-xlg-12 col-md-12">
                <div class="card">
                    <div class="card- p-5">
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Alert</strong> {{ Session::get('message') }}
                                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            {{ Session::forget('message') }}
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal form-material mx-2" action="{{ route('users.save') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label class="col-md-12">User Name</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Johnathan Doe" class="form-control form-control-line" name="username" value="{{ old('username') }}">
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="example-email" class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" placeholder="johnathan@admin.com" class="form-control form-control-line" name="email" id="example-email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-12">
                                    <label class="col-md-12">Extension</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="11223344" class="form-control form-control-line" name="extensions" value="{{ old('extensions') }}">
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label class="col-md-12">Status</label>
                                    <div class="col-md-12">
                                        <select name="status" class="form-control form-control-line">
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label class="col-md-12">Privilege</label>
                                    <div class="col-md-12">
                                        <select class="form-control form-control-line" name="privilege">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label class="col-md-12">Password</label>
                                    <div class="col-md-12">
                                        <input type="password" placeholder="1234567890" class="form-control form-control-line" name="password" value="{{ old('password') }}">
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label class="col-md-12">Confirm Password</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="1234567890" class="form-control form-control-line" name="confirmpassword" value="{{ old('confirmpassword') }}">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success text-white" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Column -->

        </div>



    </div>

@endsection

@push('css')
    <style>

    </style>
@endpush

@push('scripts')
    <script>

    </script>
@endpush


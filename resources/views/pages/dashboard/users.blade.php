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
                    <div class="card-body">
                        <div class="d-md-flex">
                            <div>
                                {{-- <h4 class="card-title">Top Selling Products</h4>
                                <h5 class="card-subtitle">Overview of Top Selling Items</h5> --}}
                            </div>
                            <div class="ms-auto">
                                <div class="dl">
                                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">Add New User</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            @if(Session::has('message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Alert</strong> {{ Session::get('message') }}
                                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                {{ Session::forget('message') }}
                            @endif
                            <table class="table v-middle table-striped table-hover" id="dataTable">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="border-top-0">#</th>
                                        <th class="border-top-0">Username</th>
                                        <th class="border-top-0">Email</th>
                                        <th class="border-top-0">Privilege</th>
                                        <th class="border-top-0">Extensions</th>
                                        <th class="border-top-0">Status</th>
                                        <th class="border-top-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->privilege }}</td>
                                        <td>{{ $user->extensions }}</td>
                                        <td>{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td><a href="{{ route('extensions.edit',$user->id) }}" class="btn btn-sm btn-info">Add Extension</a> | <a href="{{ route('users.edit',$user->id) }}" class="btn btn-sm btn-primary">Edit</a> | <a href="{{ route('users.delete',$user->id) }}" class="btn btn-sm btn-danger">Delete</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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


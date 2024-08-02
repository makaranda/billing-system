@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <h1>Add Student</h1>
        </div>
        <div class="col-12 col-md-12">
          <form action="{{ route('student.save') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-6 col-md-6 mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" placeholder="Name" name="name">
              </div>
              <div class="col-6 col-md-6 mb-3">
                <label class="form-label">email</label>
                <input type="text" class="form-control" placeholder="Email" name="email">
              </div>
              <div class="col-6 col-md-6 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" placeholder="phone" name="phone">
              </div>
              <div class="col-6 col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select class="form-control" name="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
              </div>
              <div class="col-12 col-md-12 mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
           </form>
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>

    </style>
@endpush

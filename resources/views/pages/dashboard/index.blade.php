@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <ul class="breadcrumbs mb-3">
          <li class="nav-home">
            <a href="#">
              <i class="icon-home"></i>
            </a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="#">Dashboard</a>
          </li>
        </ul>
      </div>

        <div class="row">
            <div class="col-12 col-md-12">
                @if (Session::has('error'))
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div><i class="fa fa-ban mr-2"></i>Error</div>
                            </div>
                            <div class="col-12 col-md-12">
                                <p>{{ Session::get('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="d-md-flex">
                            <div>
                                {{-- <h4 class="card-title">Top Selling Products</h4>
                                <h5 class="card-subtitle">Overview of Top Selling Items</h5> --}}
                            </div>
                            <div class="ms-auto">
                                <div class="dl">
                                    <form class="row justify-content-end g-3" action="{{ route('export.excell') }}" method="GET">
                                        <div class="col-auto">
                                          <label for="staticDate" class="visually-hidden">Date</label>
                                          <input type="date" class="form-control" name="export_date" id="staticDate" placeholder="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="col-auto">
                                          <label for="staticMonth" class="visually-hidden">Month</label>
                                          <select class="form-control form-select shadow-none" name="export_month" id="staticMonth">
                                              <option value="">Select Month</option>
                                              @for($x=1;$x <= 12;$x++)
                                                @php
                                                  $month_name = date("F", mktime(0, 0, 0, $x, 10));
                                                @endphp
                                                <option value="{{ $x }}">{{ $month_name }}</option>
                                              @endfor
                                          </select>
                                        </div>
                                        <div class="col-auto">
                                          <label for="staticYear" class="visually-hidden">Year</label>
                                          <select class="form-control form-select shadow-none" name="export_year" id="staticYear">
                                              <option value="">Select Year</option>
                                              @for($x=2024;$x <= 2034;$x++)
                                                <option value="{{ $x }}">{{ $x }}</option>
                                              @endfor
                                          </select>
                                        </div>
                                        <div class="col-auto">
                                          <button type="submit" class="btn btn-info mb-3">Get Export Excel</button>
                                        </div>
                                      </form>
                                    {{-- <a href="{{ route('export.excell') }}" class="btn btn-sm btn-info">Download Excel</a> --}}
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="table-responsive p-4">
                        {{-- {{ var_dump($cdrs) }} --}}
                        <table class="table v-middle table-striped table-hover" id="dataTable">
                            <thead>
                                <tr class="bg-light">
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0">Date</th>
                                    <th class="border-top-0">Time</th>
                                    <th class="border-top-0">Source</th>
                                    <th class="border-top-0">Destination</th>
                                    <th class="border-top-0">Disposition</th>
                                    <th class="border-top-0">Cnum</th>
                                    <th class="border-top-0">Duration (s)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cdrs as $key => $cdr)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $cdr->calldate }}</td>
                                    <td>{{ $cdr->calldate }}</td>
                                    <td>{{ $cdr->src }}</td>
                                    <td>{{ $cdr->dst }}</td>
                                    <td>{{ $cdr->disposition }}</td>
                                    <td>{{ $cdr->cnum }}</td>
                                    <td>{{ $cdr->duration }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>



    </div>
</div>

@endsection

@push('css')
    <style>

    </style>
@endpush

@push('scripts')
    <script>
        $("#dataTable").DataTable({
            pageLength: 50,
        	lengthMenu: [ [50,100, 250, 500, 1000], [50,100, 250, 500, 1000] ]
        });
    </script>
@endpush


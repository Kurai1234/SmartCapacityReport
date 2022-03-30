@extends('layouts.auth-layout')

@section('content')
    <h1>Reports</h1>
@if(session()->has('testing'))
    {{session()->get('testing')}}
@endif
    <div class=" container-fluid     report--container">
        <div class="report--form--container">
            <form action="{{route('export')}}" method="post" class="report--form">
                @csrf
                <div class="row">
                    <label for="startTime" class="col-sm-1 col-form-label col-form-label">Start Date</label>
                    <div class="col-sm-3">
                        <input type="datetime-local" name="start_time" class="form-control form-control" id="startTime"  value=""
                            placeholder="col-form-label-sm" required>
                    </div>
                    <label for="endTime" class="col-sm-1 col-form-label col-form-label">End Date</label>
                    <div class="col-sm-3">
                        <input type="datetime-local" name="end_time"class="form-control form-control" id="endTime"
                            placeholder="col-form-label-sm" required>
                        </div>
                        <div class="col-2">
                        </div>
                        <div class="col-sm-1">
                            <button name="action" value="filter"class="btn btn-success w-100"> Filter </button>
                        </div>
                    
                    <div class="col-sm-1">
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                              Export
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                              <li><button name="action" value="csv" class="btn btn-white w-100" type="submit">CSV</button></li>
                              <li><button name="action" value="xlsx" class="btn btn-white w-100" type="submit">XLSX</button></li>
                              <li><button name="action" value="tsv" class="btn btn-white w-100" type="submit">TSV</button></li>
                              <li><button class="btn btn-white w-100" type="submit">ODS</button></li>
                              <li><button class="btn btn-white w-100" type="submit">XLX</button></li>
                              <li><button class="btn btn-white w-100" type="submit">HTML</button></li>
                            </ul>
                          </div>
                        {{-- <button class="btn btn-success w-100 mx-auto ">Export</button> --}}
                    </div>
                    
                </div>
            </form>
            
            <div class="report--datatable table-responsive">
                <table id="reportTable" class="table .table-striped report--table">
                    <thead>
                        <th>
                            Access Point Name
                        </th>
                        <th>
                            Mac Address
                        </th>
                        <th>
                            Product
                        </th>
                        <th>
                            Peak Throughput
                        </th>
                        <th>
                            Capacity Throughput
                        </th>
                        <th>
                            Time Stamp
                        </th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
<script defer type="text/javascript" src="{{ asset('js/report.js') }}"> </script>

    @endsection

@extends('layouts.auth-layout')

@section('content')
    <h1>Reports</h1>

    <div class=" container-fluid     report--container">

        <div class="report--form--container">
            <form action="" class="report--form">
                @csrf
                <div class="row ">
                    <label for="startTime" class="col-sm-1 col-form-label col-form-label">Start Date</label>
                    <div class="col-sm-4">
                        <input type="datetime-local" class="form-control form-control" id="startTime"
                            placeholder="col-form-label-sm">
                    </div>
                    <label for="endTime" class="col-sm-1 col-form-label col-form-label">End Date</label>
                    <div class="col-sm-4">
                        <input type="datetime-local" class="form-control form-control" id="endTime"
                            placeholder="col-form-label-sm">
                    </div>
                    <button class="btn btn-success col-sm-1 ">Submit </button>
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

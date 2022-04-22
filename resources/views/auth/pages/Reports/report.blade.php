@extends('layouts.auth-layout')

@section('content')

    <h2>Reports</h2>
    <h6 class="text-muted">View and Export Historical Records</h6>
    <div class=" container-fluid     report--container">
        <div class="report--form--container">
            <form action="{{ route('export') }}" method="get" class="report--form">
                @csrf
                <div class="row">
                    <label for="startTime" class="col-sm-1 col-form-label col-form-label">Start Date</label>
                    <div class="col-sm-3">
                        <input type="datetime-local" name="startTime" class="form-control form-control" id="startTime"
                            value="@isset($time){{$time['start']}}@endisset"
                            placeholder="col-form-label-sm" required>
                    </div>
                    <label for="endTime" class="col-sm-1 col-form-label col-form-label">End Date</label>
                    <div class="col-sm-3">
                        <input type="datetime-local" name="endTime" class="form-control form-control" id="endTime"
                            value="@isset($time){{$time['end']}}@endisset"
                            placeholder="col-form-label-sm" required>
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-sm-1 report--button--container">
                        <button name="action" value="filter" class="btn btn-success w-100"> Filter </button>
                    </div>

                    <div class="col-sm-1 report--button--container">
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle w-100" type="button"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Export
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><button name="action" value="csv" class="btn btn-white w-100" type="submit">CSV</button>
                                </li>
                                <li><button name="action" value="xlsx" class="btn btn-white w-100"
                                        type="submit">XLSX</button></li>
                                <li><button name="action" value="html" class="btn btn-white w-100"
                                        type="submit">HTML</button></li>

                            </ul>
                        </div>
                        {{-- <button class="btn btn-success w-100 mx-auto ">Export</button> --}}
                    </div>

                </div>
            </form>

            <div class="report--datatable table-responsive">
                <table id="reportTable" class="table table-striped report--table text-center">
                    <thead>
                        <th>
                            Access Point Name
                        </th>
                        <th class="table--hide--column">
                            Mac Address
                        </th>
                        <th class="table--hide--column">
                            Product
                        </th>
                        <th>
                            Peak Throughput
                        </th>
                        <th class="table--hide--column">
                            Capacity Throughput
                        </th>
                        <th class="table--hide--column">
                            Connected Sms
                        </th>
                        <th class="table--hide--column">
                            Time Stamp
                        </th>
                    </thead>
                    <tbody>
                        @isset($peakData)
                            @foreach ($peakData as $key)
                                <tr>
                                    <td>{{ $key->name }}</td>
                                    <td class="table--hide--column"> {{ $key->mac_address }}</td>
                                    <td class="table--hide--column">{{ $key->product }}</td>
                                    <td>{{ $key->peak }} Mpbs</td>
                                    <td class="table--hide--column">{{ $key->dl_capacity_throughput }} %</td>
                                    <td class="table--hide--column">{{ $key->connected_sms }}</td>
                                    <td class="table--hide--column">{{ $key->created_at }}</td>

                                </tr>
                            @endforeach
                        @endisset

                    </tbody>
                </table>
            </div>
        </div>
        <script defer type="text/javascript" src="{{ asset('js/report.js') }}"> </script>

    @endsection

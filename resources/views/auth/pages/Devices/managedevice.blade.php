@extends('layouts.auth-layout')

@section('content')
    <h2>Manage Device</h2>
    <h6 class="text-muted">View and Update Devices</h6>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="managedevice--container">
        <div class=" device--datatable table-responsive">
            <table id="device--table " class="table table-striped">
                <thead>
                    <th>Name</th>
                    <th class="table--hide--column">Tower</th>
                    <th class="table--hide--column">Network</th>
                    <th class="table--hide--column">Mac Address </th>
                    <th>Product</th>
                    <th class="table--hide--column">Ip Address</th>
                    <th class="table--hide--column">Tag</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($collection as $data)
                        <tr>
                            <td>{{ $data->name }}</td>
                            <td class="table--hide--column">{{ $data->tower->name }}</td>
                            <td class="table--hide--column">{{ $data->tower->network->name }}</td>
                            <td class="table--hide--column">{{ $data->mac_address }}</td>
                            <td>{{ $data->product }}</td>
                            <td class="table--hide--column">{{ $data->ip_address }}</td>
                            <td class="table--hide--column"> {{ $data->tag }}</td>
                            <td><a class="btn btn-sm btn-primary w-100"
                                    href="{{ route('devices.edit', $data->id) }}">Edit</a> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script defer type="text/javascript" src="{{ asset('js/devices.js') }}"> </script>
@endsection

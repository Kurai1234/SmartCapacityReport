@extends('layouts.auth-layout')

@section('content')
    <h4>Access Point</h4>
    <div class="row container-fluid access--point--dashboard">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        @endif
        <div class="col-md-4 filter--container">
            <h5 class="py-4">Filter Access Points</h5>
            <form method="POST" action="{{ route('accesspointgraph') }}">
                @csrf
                <div class="mb-3 pe-3">
                    <label for="networks" class="form-label">Network</label>
                    <select id="networks" class="form-control form-control-sm form-select" name="network" required>
                        <option></option>
                        @foreach ($data['networks'] as $key)
                            @if (old('network') == $key->id)
                                <option value="{{ $key->id }}" selected> {{ $key->name }}</option>
                            @else
                                <option value="{{ $key->id }}"> {{ $key->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 pe-3">
                    <label for="towers" class="form-label">Tower</label>
                    <select id="towers" class="form-control form-control-sm form-select" name="tower" required>
                        <option>                        </option>
                        @foreach ($data['towers'] as $key)
                            @if (old('tower') == $key->id)
                                <option id="{{$key->network_id}}"value="{{ $key->id }}" selected>{{ $key->name }}</option>
                            @else
                                <option id="{{$key->network_id}}"value="{{ $key->id }}">{{ $key->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 pe-3">
                    <label for="accesspoints" class="form-label">Access Points</label>
                    <select id="accesspoints" class="form-control form-control-sm form-select" name="accesspoint"
                        required>
                        <option></option>
                        @foreach ($data['accesspoints'] as $key)
                            @if (old('accesspoint') == $key->id)
                                <option id="{{$key->tower_id}}" value="{{ $key->id }}" selected>{{ $key->name }}</option>
                            @else
                                <option id="{{$key->tower_id}}" value="{{ $key->id }}">{{ $key->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 pe-3 ">
                    <label for="datetime--start" class="form-label">Start-Time</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="datetime--start" name="start_time" required />

                </div>
                <div class="mb-3 pe-3 ">
                    <label for="datetime--end" class="form-label">End-Time</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="datetime--end" name="end_time" required />

                </div>

                <div class="mb-3 pe-3 text-center">
                    <button type="submit" class="btn btn-success mx-2">Display</button>
                    <button type="button" class="btn btn-light">Clear</button>
                </div>

            </form>
            
        </div>
        <div class="col-md-8">
            <div id="dl--graph" class="charts">
            </div>
            <div id="frame--graph" class="charts">

            </div>
            <div id="retransmission--graph" class="charts">
            </div>
        </div>
    </div>




    <script defer type="text/javascript" src="{{ asset('/js/graph.js') }}"> </script>

@endsection

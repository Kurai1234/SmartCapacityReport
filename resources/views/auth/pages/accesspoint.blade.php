@extends('layouts.auth-layout')

@section('content')
<h4>Access Point</h4>
{{$testing??''}}
<div class="row container-fluid access--point--dashboard">
    <div class="col-md-4 filter--container">
        <h5 class="py-4">Filter Access Points</h5>
        <form method="POST" action="{{route('accesspointgraph')}}">
            @csrf
            <div class="mb-3 pe-3">
                <label for="Network" class="form-label">Network</label>
                <select id="Network" class="form-control form-control-sm ap--filter--select" name="network">
                    <option value="Default">Default
                    </option>
                    @foreach($network as $key)
                            <option value="{{$key->id}}"> {{$key->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 pe-3">
                <label for="Tower" class="form-label">Tower</label>
                <select id="Tower" class="form-control form-control-sm ap--filter--select">
                    <option value="Default">Default
                    </option>
                    
                </select>
            </div>
            <div class="mb-3 pe-3">
                <label for="access--points" class="form-label">Access Points</label>
                <select id="access--points" class="form-control form-control-sm ap--filter--select">
                    <option value="Default">Default
                    </option>

                </select>
            </div>
            <div class="mb-3 pe-3 ">
            <label for="datetime--start" class="form-label">Start-Time</label>
                <input type="datetime-local" class="form-control form-control-sm"id="datetime--start" />

            </div>
            <div class="mb-3 pe-3 ">
            <label for="datetime--end" class="form-label">End-Time</label>
                <input type="datetime-local" class="form-control form-control-sm" id="datetime--end" />

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




<script defer type="text/javascript" src="{{asset('/js/graph.js')}}"> </script>

@endsection

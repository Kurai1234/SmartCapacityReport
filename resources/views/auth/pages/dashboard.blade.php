@extends('layouts.auth-layout')

@section('content')
<h4>Dashboard</h4>
<div class="dashboard--ap--stats">
    <div class="online--ap">
        <span>online</span>
        <span>
            1
        </span>
    </div>
    <div class="boarding--ap">
        <span>boarding</span>
        <span>
            2
        </span>
    </div>
    <div class="offline--ap">
        <span>offline</span>
        <span>
            3
        </span>
    </div>

</div>

<div class="row my-4 gx-3 container-fluid dashboard--content">
    <div class="col-lg-5">
        <div class="row g-3">
            <div class="col-lg-10 col-md-10  container piechart--container">
                <span>Average of Access Points Status</span>
                <h6 class="dashboard--subtitle">Grapical Representation of AP's Status</h6>
                <div id="piechart" class="charts"> </div>
            </div>
            {{-- <div class="col-lg-5 col-md-5 container piechart--container">
                <span>Average of Access Points Status</span>
                <h6 class="dashboard--subtitle">Grapical Representation of AP's Status</h6>
                <div id="piechart"> </div>
            </div> --}}
        </div>
        {{-- <div class="row">
            3
        </div> --}}
    </div>
    <div class="col-lg-7 container-fluid table--container">
        <span>Live Feedback of Access Points Statistics</span>
        <h6 class="dashboard--subtitle">AP's under distress are displayed Live</h6>
        
        

















        <div class="ap--table--container">
            <table class="table table-responsive table-hover ap--live--table" >
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th colspan="2" scope="col">Name</th>
                        <th scope="col">Network</th>
                        <th scope="col">Tower</th>
                        <th scope="col">Frame_Utilization</th>
                        <th scope="col">DL Throughput</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td colspan="2">Mark</td>
                        <td>Otto</td>
                        <td>@asdasdasdadasdsadmdo</td>
                        <td>Otto</td>
                        <td>Otto</td>
                    </tr>
                    @foreach ($testing as $key)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td colspan="2">{{$key->connected_sms}}</td>
                            <td>{{$key->status}}</td>
                            <td>{{$key->mode}}</td>
                            <td>{{$key->dl_capacity_throughput}}</td>
                            <td>{{$key->dl_throughput}}</td>
                        </tr>
                    
                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="dashboard--table table-responsive">

<table class="table" id="sortTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Network</th>
                    <th>Tower</th>
                    <th>DL Capacity Throughput</th>
                    <th>DL Throughput</th>
                    <th>Retransmission PcT</th>
                </tr>
                {{-- fix --}}
            </thead>
            <tbody>
                @foreach($testing as $key)
                <tr>
                    <th>{{$loop->iteration}}</th>
                    <th>{{$key->access_point_id}}</th>
                    <th>{{$key->access_point_id}}</th>
                    <th>{{$key->status}}</th>
                    <th>{{$key->dl_capacity_throughput}}</th>
                    <th>{{$key->dl_throughput}}</th>
                    <th>{{$key->dl_retransmit_pcts}}</th>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>



<script defer type="text/javascript" src="{{asset('js/dashboard_graphs.js')}}"> </script>
<script>

    </script>

@endsection

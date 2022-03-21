@extends('layouts.auth-layout')

@section('content')
<h4>Dashboard</h4>
<div class="dashboard--ap--stats">
    <div class="online--ap">
        <span>online</span>
        <span id='ap--online--count'>
            0
        </span>
    </div>
    <div class="boarding--ap">
        <span>boarding</span>
        <span id="ap--boarding--count">
            0
        </span>
    </div>
    <div class="offline--ap">
        <span>offline</span>
        <span id="ap--offline--count">
            0
        </span>
    </div>

</div>

<div class="row my-4 gx-3 container-fluid dashboard--content">
    <div class="col-lg-3 gx-4">
        <div class="row g-3">
            <div class="col-lg-12 col-md-12  container piechart--container">
                <span>Access Points DL Capacity</span>
                <h6 class="dashboard--subtitle">Access Points Dl Capacity over 80%</h6>
                <div id="piechart" class="charts"> </div>
            </div>
           
        </div>
    </div>
    <div class="col-lg-4 gx-4">
        <div class="row g-5">
            <div class="col-lg-12 col-md-12">
                hi
            </div>
        </div>
    </div>
</div>
<div class="dashboard--table table-responsive">
    <span>Live Feedback of Access Points Statistics</span>
    <h6 class="dashboard--subtitle text-center">AP's under distress are displayed Live</h6>
    
<table class="table" id="sortTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Product</th>
                    <th>Network</th>
                    <th>Tower</th>
                    <th>Connected SM's</th>
                    <th>DL Capacity Throughput</th>
                    <th>DL Throughput</th>
                    <th>Retransmission PcT</th>
                </tr>
            </thead>
            <tbody id="dashboard_table_body">
                
            </tbody>

        </table>
    </div>



<script defer type="text/javascript" src="{{asset('js/dashboard_graphs.js')}}"> </script>
<script>

    </script>

@endsection

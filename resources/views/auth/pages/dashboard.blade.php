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
    {{-- <div class="col-lg-7 container-fluid table--container">
        <span>Live Feedback of Access Points Statistics</span>
        <h6 class="dashboard--subtitle">AP's under distress are displayed Live</h6>
        
        
       <div class="ap--table--container">
        </div>
    </div> --}}
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

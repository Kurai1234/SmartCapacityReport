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
            <form method="get" action="{{ route('accesspointgraph') }}">
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
                        <option> </option>
                        @foreach ($data['towers'] as $key)
                            @if (old('tower') == $key->id)
                                <option id="{{ $key->network_id }}" value="{{ $key->id }}" selected>{{ $key->name }}
                                </option>
                            @else
                                <option id="{{ $key->network_id }}" value="{{ $key->id }}">{{ $key->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 pe-3">
                    <label for="accesspoints" class="form-label">Access Points</label>
                    <select id="accesspoints" class="form-control form-control-sm form-select" name="accesspoint" required>
                        <option></option>
                        @foreach ($data['accesspoints'] as $key)
                            @if (old('accesspoint') == $key->id)
                                <option id="{{ $key->tower_id }}" value="{{ $key->id }}" selected>
                                    {{ $key->name }}</option>
                            @else
                                <option id="{{ $key->tower_id }}" value="{{ $key->id }}">{{ $key->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 pe-3 ">
                    <label for="datetime--start" class="form-label">Start-Time</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="datetime--start" name="start_time"
                        required />

                </div>
                <div class="mb-3 pe-3 ">
                    <label for="datetime--end" class="form-label">End-Time</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="datetime--end" name="end_time"
                        required />

                </div>

                <div class="mb-3 pe-3 text-center">
                    <button type="submit" class="btn btn-success mx-2">Display</button>
                    <button type="button" class="btn btn-light">Clear</button>
                </div>

            </form>

        </div>
        <div class="col-md-8">
            {{-- <div id="dl--graph" class="charts"> --}}
            {{-- </div> --}}
            <canvas id="myChart2" width="100" height="30"></canvas>

            {{-- <div id="frame--graph" class="charts"> --}}
            <canvas id="canvas" width="100" height="30"></canvas>

            {{-- </div>/ --}}
            {{-- <div id="retransmission--graph" class="charts"> --}}
            <canvas id="myChart" width="100" height="30"></canvas>

        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"> </script>
    <script>
        var app = <?php echo json_encode(isset($result)? $result:[]);?>;

        var r = app.data.dl_retransmission;
        var date = app.data.dates;
        console.log(app.data.dl_retransmission);
        
        const ctxx = document.getElementById('myChart2').getContext('2d');
        const myCharts = new Chart(ctxx, {
            type: 'line',
            data: {
                labels:date                //  ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange']
                 ,
                datasets: [{
                    label: 'DownLink Throughput',
                    data: r,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }, ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x:{
                        ticks:{
                            display:false
                        }
                    }
                }
            }
        });
        // const ctxxx = document.getElementById('myChart3').getContext('2d');
        // const myCharts2 = new Chart(ctxxx, {
        //     type: 'line',
        //     data: {
        //         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        //         datasets: [{
        //             label: '# of Votes',
        //             data: [12, 19, 3, 5, 2, 3],
        //             backgroundColor: [
        //                 'rgba(255, 99, 132, 0.2)',
        //                 'rgba(54, 162, 235, 0.2)',
        //                 'rgba(255, 206, 86, 0.2)',
        //                 'rgba(75, 192, 192, 0.2)',
        //                 'rgba(153, 102, 255, 0.2)',
        //                 'rgba(255, 159, 64, 0.2)'
        //             ],
        //             borderColor: [
        //                 'rgba(255, 99, 132, 1)',
        //                 'rgba(54, 162, 235, 1)',
        //                 'rgba(255, 206, 86, 1)',
        //                 'rgba(75, 192, 192, 1)',
        //                 'rgba(153, 102, 255, 1)',
        //                 'rgba(255, 159, 64, 1)'
        //             ],
        //             borderWidth: 1
        //         },
        //         {
        //             label: '# of Votes',
        //             data: [2, 9, 13, 15, 12, 7],
        //             backgroundColor: [
        //                 'rgba(255, 99, 132, 0.2)',
        //                 'rgba(54, 162, 235, 0.2)',
        //                 'rgba(255, 206, 86, 0.2)',
        //                 'rgba(75, 192, 192, 0.2)',
        //                 'rgba(153, 102, 255, 0.2)',
        //                 'rgba(255, 159, 64, 0.2)'
        //             ],
        //             borderColor: [
        //                 'rgba(255, 99, 132, 1)',
        //                 'rgba(54, 162, 235, 1)',
        //                 'rgba(255, 206, 86, 1)',
        //                 'rgba(75, 192, 192, 1)',
        //                 'rgba(153, 102, 255, 1)',
        //                 'rgba(255, 159, 64, 1)'
        //             ],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });
    </script>


    {{-- <script defer type="text/javascript" src="{{ asset('/js/graph.js') }}"> </script> --}}





@endsection

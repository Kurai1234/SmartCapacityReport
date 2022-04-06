@extends('layouts.auth-layout')

@section('content')
    <h2>Access Point Graphs</h2>
    <h6 class="text-muted">Display Graphically representation</h6>
    <div class="row container-fluid access--point--dashboard">

        <div class="col-md-4 filter--container">
            <h5 class="py-4">Filter Access Points</h5>
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

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
                                <option id="{{ $key->network_id }}" value="{{ $key->id }}" selected>
                                    {{ $key->name }}
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
        <div class="col-md-8 py-4 canvas--containers">
            @isset($result)
                <h5 class="text-center">{{ $result['name'] }}</h5>
                <h6 class="text-center text-muted">{{ $result['product'] }} </h6>
            @endisset
            <div class="canvas">
                <h6 id="retransmitMax" class="canvas--max--value">MAX: Apr 24,2020 7:00AM 54.6%</h6>
                <canvas id="canvas" width="100" height="31">
                </canvas>
            </div>

            <div class="canvas">
                <h6 id="frameUtilizationMax" class="canvas--max--value">Apr 24,2020 7:00AM 54.6%</h6>
                <canvas id="canvas2" width="100" height="31"></canvas>
            </div>

            <div class="canvas">
                <h6 id="throughputMax" class="canvas--max--value"><span id="dlthroughputMax"> </span> <span id="ulthroughputMax"> </span></h6>
                <canvas id="canvas3" width="100" height="31"></canvas>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"> </script>
    <script>
        var app = <?php echo json_encode(isset($result) ? $result : []); ?>;
        if (Object.keys(app).length !== 0) {
            var frame_utilization = app.frame_utilization;
            var dl_retransmission = app.dl_retransmission;
            var date = app.dates;
            var dl_throughput = app.throughput.dl_throughput;
            var ul_throughput = app.throughput.ul_throughput;
            drawRetransmitPct();
            drawFrameUtilization();
            drawThroughput()
        }

        function drawRetransmitPct() {
            const ctxx = document.getElementById('canvas').getContext('2d');
            const myCharts = new Chart(ctxx, {
                type: 'line',
                data: {
                    labels: date, //  ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange']                    ,
                    datasets: [{
                        label: 'Retransmissions Percentage',
                        data: dl_retransmission,
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
                        borderWidth: 1,

                    }]
                },
                options: {

                    scales: {
                        y: {

                            beginAtZero: true,

                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    return context.parsed.y + ' %';
                                    return label;
                                }
                            }
                        }
                    }

                }
            });
            max = Math.max(...myCharts.data.datasets[0].data);
            document.getElementById('retransmitMax').innerText = 'MAX: ' + myCharts.data.labels[myCharts.data.datasets[0]
                .data.indexOf(max)] + ' ' + max + '%';
        };

        function drawFrameUtilization() {
            const ctx = document.getElementById('canvas2').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: date //  ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange']
                        ,
                    datasets: [{
                        label: 'Frame Utilizations',
                        data: frame_utilization,
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
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    return context.parsed.y + ' %';
                                    return label;
                                }
                            }
                        }
                    }

                }
            });
            max = Math.max(...myChart.data.datasets[0].data);
            document.getElementById('frameUtilizationMax').innerText = 'MAX: ' + myChart.data.labels[myChart.data.datasets[
                0].data.indexOf(max)] + ' ' + max + '%';


        };

        function drawThroughput() {
            const ctxxx = document.getElementById('canvas3').getContext('2d');
            const myChartw = new Chart(ctxxx, {
                type: 'line',
                data: {
                    labels: date //  ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange']
                        ,
                    datasets: [{
                            label: 'Downlink Throughput',
                            data: dl_throughput,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                // 'rgba(54, 162, 235, 0.2)',
                                // 'rgba(255, 206, 86, 0.2)',
                                // 'rgba(75, 192, 192, 0.2)',
                                // 'rgba(153, 102, 255, 0.2)',
                                // 'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                // 'rgba(54, 162, 235, 1)',
                                // 'rgba(255, 206, 86, 1)',
                                // 'rgba(75, 192, 192, 1)',
                                // 'rgba(153, 102, 255, 1)',
                                // 'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        },
                        {
                            label: 'Uplink Throughput',
                            data: ul_throughput,
                            backgroundColor: [
                                // 'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                // 'rgba(255, 206, 86, 0.2)',
                                // 'rgba(75, 192, 192, 0.2)',
                                // 'rgba(153, 102, 255, 0.2)',
                                // 'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                // 'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                // 'rgba(255, 206, 86, 1)',
                                // 'rgba(75, 192, 192, 1)',
                                // 'rgba(153, 102, 255, 1)',
                                // 'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        },
                    ]
                },
                options: {
                    scales: {
                        y: {

                            beginAtZero: true
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    return context.parsed.y + ' Mpbs';
                                    return label;
                                }
                            }
                        }
                    }

                }
            });
            console.log(myChartw);
            dlmax = Math.max(...myChartw.data.datasets[0].data);
            ulmax = Math.max(...myChartw.data.datasets[1].data);
            console.log(ulmax);
            document.getElementById('dlthroughputMax').innerText = 'DL: ' + myChartw.data.labels[myChartw.data.datasets[0]
                .data.indexOf(dlmax)] + ' ' + dlmax + '%';
            document.getElementById('ulthroughputMax').innerText = 'UL: ' + myChartw.data.labels[myChartw.data.datasets[1]
                .data.indexOf(ulmax)] + ' ' + ulmax + '%';
            
        };
    </script>
@endsection

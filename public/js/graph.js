
google.charts.load("visualization", "1", { packages: ["corechart", "line"] });

google.charts.setOnLoadCallback(drawDownLinkChart);
google.charts.setOnLoadCallback(drawFrameUtilizationChart);
google.charts.setOnLoadCallback(drawRetransmissionChart);
function drawDownLinkChart() {
    
    var data = new google.visualization.DataTable();
    data.addColumn("datetime", "Date");
    data.addColumn("number", "Downlink Throughput");
    data.addColumn("number", "Uplink Throughput");
    data.addRows([
        [new Date(2000, 8, 4, 10,0), 0, 0],
        [new Date(2000, 8, 6 ,7,6), 2, 2],
        [new Date(2000, 8, 7, 4,5), 3, 125],
    ]);
    var option = {
        title:'Frame Ultization',
        hAxis: {
                gridlines:{
                    count:1,
                }
        },
        vAxis: {
            title: "Mpbs",
                gridlines:{
                    count:1,
                }
        },
        legend: {
            position: "bottom",
            textStyle: {
                fontSize: 11,
                bold: true,
            },
        },
    };
    var chart = new google.visualization.LineChart(
        document.getElementById("dl--graph")
    );
    chart.draw(data, option);
}
function drawFrameUtilizationChart() {
    var data = new google.visualization.DataTable();
    data.addColumn("number", "X");
    data.addColumn("number", "Frame Utilization");

    data.addRows([
        [0, 0],
        [1, 2],
        [2, 3],
    ]);
    var option = {
        hAxis: {
            title: "Time",
        },
        vAxis: {
            title: "Mpbs",
        },
        legend: {
            position: "bottom",
            textStyle: {
                fontSize: 11,
                bold: true,
            },
        },
    };
    var chart = new google.visualization.LineChart(
        document.getElementById("frame--graph")
    );
    chart.draw(data, option);
}
function drawRetransmissionChart() {
    var data = new google.visualization.DataTable();
    data.addColumn("number", "X");
    data.addColumn("number", "Downlink Retransmission");
    data.addColumn("number", "Uplink Retransmission");
    data.addRows([
        [0, 0, 0],
        [1, 2, 2],
        [2, 3, 5],
    ]);

    var option = {
        hAxis: {
            title: "Time",
        },
        vAxis: {
            title: "Mpbs",
        },

        legend: {
            position: "bottom",
            textStyle: {
                fontSize: 11,
                bold: true,
            },
        },
    };
    var chart = new google.visualization.LineChart(
        document.getElementById("retransmission--graph")
    );
    chart.draw(data, option);
}

test1='2022-03-28T00:40:54-06:00';
test2='2022-03-28T06:38:00+00:00';

function arrangeDate(date){
    return new Date(date);
}



$(window).resize(function () {
    if (this.resizeTo) clearTimeout(this.resizeTo);
    this.resizeTo = setTimeout(function () {
        $(this).trigger("resizeEnd");
    }, 500);
});

$(window).on("resizeEnd", function () {
    drawDownLinkChart();
    drawFrameUtilizationChart();
    drawRetransmissionChart();
});

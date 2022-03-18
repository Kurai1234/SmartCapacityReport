google.charts.load("visualization", "1", { packages: ["corechart", "line"] });
google.charts.setOnLoadCallback(drawchart);
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="crsf-token"]').attr("content"),
    },
});

function drawchart() {
    var data = google.visualization.arrayToDataTable([
        ["Status", "Numbers of Access Points"],
        ["Critical", 10],
        ["OK", 100],
    ]);

    var option = {
        pieHole: 0.3,
        fontName: "Arial",
        legend: {
            position: "bottom",
            textStyle: {
                fontSize: 11,
                bold: true,
            },
        },
        backgroundColor: {
            fill: "none",
        },
        chartArea: {
            width: "100%",
            height: "80%",
        },
        tooltip: {
            showColorCode: true,

            textStyle: {
                bold: true,
            },
        },

        slices: { 0: { color: "#D74C4C" }, 1: { color: "#68DC93" } },
        pieStartAngle: 200,
    };

    var chart = new google.visualization.PieChart(
        document.getElementById("piechart")
    );
    chart.draw(data, option);
}

var dashBoardTable=$("#sortTable").DataTable({
    "ajax":{
        "type":"GET",
         "url": "/api/liveapdata",
         "dataSrc":function (json) { 
             console.log(json.data);
             return json.data;
         }
    },
    
    "columns":[
            
            {"data":"accesspoint.name"},
            {"data":"accesspoint.product"},
            {"data":"accesspoint.tower.network.name"},

            {"data":"accesspoint.tower.name"},
            {"data":"connected_sms"},
            {"data":"dl_capacity_throughput",render: $.fn.dataTable.render.number(',','.',2,''," %")},

            {"data":"dl_throughput",render:$.fn.dataTable.render.number(',','.',3,''," mbps")},
            {"data":"dl_retransmit_pcts",render:$.fn.dataTable.render.number(',','.',2,''," %")},

    ]
 });








// var update_ap_data_table = function () {
//     $.ajaxSetup({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="crsf-token"]').attr("content"),
//         },
//     });
//     $.ajax({
//         type: "GET",
//         url: "/api/liveapdata",
//         cache:false,
//         dataType: "json",
//         success: function (response) {
//             // console.log(response.data[0]);
        
//         },
//     });
// };
var status_of_apis = function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="crsf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "GET",
        url: "/api/apstatus",
        dataType: "json",
        success: function (response) {
            // console.log(response.data);
            document.getElementById("ap--online--count").innerText =
                response.data.online;
            document.getElementById("ap--boarding--count").innerText =
                response.data.boarding;
            document.getElementById("ap--offline--count").innerText =
                response.data.offline;
        },
    });
};





var interval = 1000 * 60 * 2;
setInterval(status_of_apis, interval);
setInterval(function(){
    dashBoardTable.ajax.reload();
},interval)
$(window).resize(function () {
    drawchart();
});

// window.onload=(event)=>{
$(document).ready(function () {
    // update_ap_data_table();
    // dashBoardTable();
    status_of_apis();



}, 500);

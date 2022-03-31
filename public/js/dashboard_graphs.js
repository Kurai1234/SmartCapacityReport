var interval = 1000 * 60 * 2;
google.charts.load("visualization", "1", { packages: ["corechart", "line"] });
google.charts.setOnLoadCallback(drawchart);
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="crsf-token"]').attr("content"),
    },
});

function drawchart() {
   var datatest= $.ajax({
        type: "GET",
        url: "/api/appieinfo",
        dataType: "json",
        async:false, 
    }).responseText;
    var data = google.visualization.arrayToDataTable(

        JSON.parse(datatest)
        );
    var option = {
        pieHole: 0.3,
        fontName: "Arial",
        width:'300',
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
            height: "70%",
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
         "url": "/api/apstatistic",
        //  processing:true,
        //  serverSide:true,
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
            {"data":"ul_throughput",render:$.fn.dataTable.render.number(',','.',2,''," mbps")},
            {"data":"dl_throughput",render:$.fn.dataTable.render.number(',','.',2,''," mbps")},
            {"data":"dl_retransmit_pcts",render:$.fn.dataTable.render.number(',','.',2,''," %")},

    ]
 });

var status_of_apis = function () {
    document.getElementById("offline--aps--tbody").innerHTML ='';

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
            Object.values(response.data.devices).forEach(device => {
                document.getElementById("offline--aps--tbody").innerHTML +=`<td>${device.accesspoint.name} </td>
                <td>${device.accesspoint.tower.name} </td>
                <td>${device.accesspoint.tower.network.name} </td>`;
                // console.log(device);
            });
            document.getElementById("ap--online--count").innerText =
                response.data.status.online;
            document.getElementById("ap--boarding--count").innerText =
                response.data.status.boarding;
            document.getElementById("ap--offline--count").innerText =
                response.data.status.offline;
        },
    });
};

setInterval(function(){
    dashBoardTable.ajax.reload();
    status_of_apis();
},interval);

$(window).resize(function(){
    if(this.resizeTo) clearTimeout(this.resizeTo);
    this.resizeTo = setTimeout(function(){
        $(this).trigger('resizeEnd');
    },500);
})

$(window).on('resizeEnd',function(){
    drawchart();
});
$(document).ready(function () {
    
    status_of_apis();
});

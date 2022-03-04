google.charts.load('visualization','1',{packages:['corechart','line']});



google.charts.setOnLoadCallback(drawDownLinkChart);
google.charts.setOnLoadCallback(drawFrameUtilizationChart);
google.charts.setOnLoadCallback(drawRetransmissionChart);


function drawDownLinkChart(){
    var data= new google.visualization.DataTable();
        data.addColumn('number','X');
        data.addColumn('number',"Downlink Throughput");
        data.addColumn('number',"Uplink Throughput");
        data.addRows([
            [0,0,0],[1,2,2],[2,3,5]
        ]);
        var option ={
            hAxis:{
                title:'Time',
            },
            vAxis:{
                title:'Mpbs'
            },
          legend:{
            position:'bottom',
            textStyle:{
            fontSize:11,
            bold:true,},
        },
        };
    var chart= new google.visualization.LineChart(document.getElementById('dl--graph'));
    chart.draw(data,option);
};
function drawFrameUtilizationChart(){
    var data= new google.visualization.DataTable();
        data.addColumn('number','X');
        data.addColumn('number',"Frame Utilization");
     
        data.addRows([
            [0,0],[1,2],[2,3]
        ]);
        var option ={
            hAxis:{
                title:'Time',
            },
            vAxis:{
                title:'Mpbs',
            },
          legend:{
            position:'bottom',
            textStyle:{
            fontSize:11,
            bold:true,},
        },
        };
    var chart= new google.visualization.LineChart(document.getElementById('frame--graph'));
    chart.draw(data,option);
}

function drawRetransmissionChart(){
    var data= new google.visualization.DataTable();
        data.addColumn('number','X');
        data.addColumn('number',"Downlink Retransmission");
        data.addColumn('number',"Uplink Retransmission");
        data.addRows([
            [0,0,0],[1,2,2],[2,3,5]
        ]);
        var option ={
            hAxis:{
                title:'Time',
            },
            vAxis:{
                title:'Mpbs'
            },
          
          legend:{
            position:'bottom',
            textStyle:{
            fontSize:11,
            bold:true,},
        },
        };
    var chart= new google.visualization.LineChart(document.getElementById('retransmission--graph'));
    chart.draw(data,option);
}

$(window).resize(function(){
    drawDownLinkChart();
    drawFrameUtilizationChart();
    drawRetransmissionChart();
    
})
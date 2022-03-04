google.charts.load('visualization','1',{packages:['corechart','line']});
google.charts.setOnLoadCallback(drawchart);
function drawchart(){
    var data=google.visualization.arrayToDataTable([
        ['Status','Numbers of Access Points'],
        ['Critical',10],
        ['OK',100]
    ]);
    
    var option ={
        pieHole: 0.3,
        fontName:'Arial',
        legend:{
            position:'bottom',
            textStyle:{
            fontSize:11,
            bold:true,},
        },
        backgroundColor:{
            fill:'none',
        },
        chartArea:{
            width:'100%',
            height:'80%',
        },
        tooltip:{showColorCode:true,
    
        textStyle:{
            bold:true,
        },
        },
        
        slices:{0:{color:'#D74C4C'}, 1:{color:'#68DC93'}},
        pieStartAngle:200,
    };
    
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data,option);
    
    };

    
    
$(window).resize(function(){

    drawchart();
    
})

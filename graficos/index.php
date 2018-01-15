<?php
include '../plantilla.php';
$sql="select a.nombre,
coalesce(sum(b.peso::float),0) peso
from animales a inner join pesos_leches b on b.animal=a.numero||'-'||a.nombre
where fecha::date between  current_date-7 and current_date
group by a.nombre
order by 2 desc";

$res=$conex->query($sql);
$producciones_leches=$res->fetchAll(PDO::FETCH_ASSOC);

$sql_prod_minima="SELECT min(produccion_minima::integer),max(produccion_minima::integer) from grupos where clasificacion ='produccion'";
$res2=$conex->query($sql_prod_minima);

$res_prod_min=$res2->fetch(PDO::FETCH_ASSOC);




?>
<div class="small-12 columns">
   
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</div>
<script>
        datos=<?php echo json_encode($producciones_leches)?>;
        nombres=new Array();
        pesos=new Array();
        
        _.each(datos,function(value,key){
        
        nombres.push(datos[key].nombre);
        pesos.push(parseFloat( datos[key].peso));
    });
    
    Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'total produccion ultimos 7 dias'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories:nombres,
        crosshair: true
    },
    yAxis: {
        min:<?php echo $res_prod_min[min]  ?>,
        max:<?php echo $res_prod_min[max]  ?>,
        title: {
            text: 'botellas'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.2f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'botellas',
        data:pesos

    }],
        credits:{
            enabled:false
        }
           
});


</script>
</div>

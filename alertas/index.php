<?php
include '../plantilla.php';
?>

<div class="column small-10">

    <h2>notificaciones</h2>
<?php

$sql="select numero,nombre,to_char(current_date,'DD MM YYYY')::date  - (select fecha from partos where animal=numero||'-'||nombre order by fecha::date desc limit 1)::date dias_lactancia 
    from animales
    where (to_char(current_date,'DD MM YYYY')::date  - (select fecha from partos where animal=numero||'-'||nombre order by fecha::date desc limit 1)::date)>=305";
#este queri es para las que tienes 2 meses de haber parido y necesitan ser servidas otra vez
$sql2="select numero,nombre,to_char(current_date,'DD MM YYYY')::date  - (select fecha from partos where animal=numero||'-'||nombre order by fecha::date desc limit 1)::date dias_lactancia from animales
where (to_char(current_date,'DD MM YYYY')::date  - (select fecha from partos where animal=numero||'-'||nombre order by fecha::date desc limit 1)::date)>=60";
#alerta para emitir orden de compra
$sql3="select referencia,unidad_standar,nombre,cantidad_total,alerta_min from productos where cantidad_total::numeric(10,2)<=alerta_min";
$res=$conex->query($sql);
$res2=$conex->query($sql2);
$res3=$conex->query($sql3);
$dias_lactancia='';
$para_servir='';
$por_agotarse='';
while($fila=$res->fetch(PDO::FETCH_ASSOC)){
    $dias_lactancia.="
        <div class='small-3 columns'>
        <ul class='pricing-table'>
  <li class='title'>$fila[numero]-$fila[nombre]</li>
  <li class='price'>$fila[dias_lactancia] dias</li>
</ul>
</div>";
    
}
while($fila=$res2->fetch(PDO::FETCH_ASSOC)){
    $para_servir.="
        <div class='small-3 columns'>
        <ul class='pricing-table'>
  <li class='title'>$fila[numero]-$fila[nombre]</li>
  <li class='price'>$fila[dias_lactancia] dias</li>
</ul>
</div>";
    
}
while($fila=$res3->fetch(PDO::FETCH_ASSOC)){
    $por_agotarse.="
        <div class='small-3 columns'>
        <ul class='pricing-table'>
  <li class='title'>$fila[referencia]-$fila[nombre]</li>
  <li class='price'>$fila[cantidad_total] $fila[unidad_standar]</li>
</ul>
</div>";    
}
?>


<ul class="accordion" data-accordion>
  <li class="accordion-navigation">
    <a href="#panel1a">dias lactancia</a>
    <div id="panel1a" class="content active">
        <div class="row">
      <?php echo $dias_lactancia?>
    </div>
    </div>
  </li>
  <li class="accordion-navigation">
    <a href="#panel2a">para servir</a>
    <div id="panel2a" class="content">
      <div class="row">
      <?php echo $para_servir?>
    </div>
    </div>
  </li>
  <li class="accordion-navigation">
    <a href="#panel3a">productos por agotarse</a>
    <div id="panel3a" class="content">
      <?php echo $por_agotarse?>
    </div>
  </li>
</ul>
</div>
</div>


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
$res=$conex->query($sql);
$res2=$conex->query($sql2);
$dias_lactancia='';
$para_servir='';
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
    <a href="#panel3a">Accordion 3</a>
    <div id="panel3a" class="content">
      Panel 3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
    </div>
  </li>
</ul>
</div>
</div>


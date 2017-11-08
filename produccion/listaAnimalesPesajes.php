<?php

include '../conexion.php';
$sql="select regexp_split_to_table(rtrim(numero,','),',')numero"
        . ",regexp_split_to_table(rtrim(nombre,','),',') nombre "
        . ",regexp_split_to_table(rtrim(peso,','),',') peso  from bit_peso_animal where id=$_GET[id]";
$res=$conex->query($sql);
        
$tabla="<table>
  <thead>
    <tr>
      <th>numero</th>     
      <th>nombre</th>     
      <th>peso</th>     
    </tr>
  </thead>
  <tbody>
  {datos}
  </tbody>
</table>";


while($fila=$res->fetch()){
    $lista.= "<tr><td> $fila[numero]</td><td>$fila[nombre]</td><td>$fila[peso]</td>";
}
$tabla=preg_replace("/{datos}/", $lista, $tabla);
echo $tabla;
echo '<a class="close-reveal-modal" aria-label="Close">&#215;</a>';
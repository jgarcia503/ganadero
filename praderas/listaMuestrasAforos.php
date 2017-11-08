<?php

include '../conexion.php';
$sql="select regexp_split_to_table(rtrim(vegetacion,','),',') vegetacion ,regexp_split_to_table(rtrim(peso,','),',') pesos  from aforos where id=$_GET[aforo]";
$res=$conex->query($sql);
        
$tabla="<table>
  <thead>
    <tr>
      <th>vegetacion</th>     
      <th>peso</th>     
    </tr>
  </thead>
  <tbody>
  {datos}
  </tbody>
</table>";

while($fila=$res->fetch()){
    $lista.="<tr><td>$fila[vegetacion]</td><td> $fila[pesos]</td></tr>";
}

$tabla=preg_replace("/{datos}/", $lista, $tabla);

echo $tabla;
echo '<a class="close-reveal-modal" aria-label="Close">&#215;</a>';


?>

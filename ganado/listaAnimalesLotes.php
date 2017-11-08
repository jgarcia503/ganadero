<?php

include '../conexion.php';
$sql="select numero,nombre from animales where numero in (select regexp_split_to_table(animales,',') animales from lotes where nombre='$_GET[lote]')";
$res=$conex->query($sql);
        
$tabla="<table>
  <thead>
    <tr>
      <th>numero</th>     
      <th>nombre</th>     
    </tr>
  </thead>
  <tbody>
  {datos}
  </tbody>
</table>";

while($fila=$res->fetch()){
    $lista.="<tr><td>$fila[numero]</td><td> $fila[nombre]</td></tr>";
}

$tabla=preg_replace("/{datos}/", $lista, $tabla);

echo $tabla;
echo '<a class="close-reveal-modal" aria-label="Close">&#215;</a>';

?>

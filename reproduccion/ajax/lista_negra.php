<?php

include '../../conexion.php';

$id=$_GET[id];

$sql="select regexp_split_to_table(animales_incompatibles,',') incompatibles from lista_negra where animal='$id'  ";
$res=$conex->query($sql);
$tabla="<table>
  <thead>
    <tr>
      <th>animal</th>           
    </tr>
  </thead>
  <tbody>
  {datos}
  </tbody>
</table>";
while($lineas=$res->fetch(PDO::FETCH_ASSOC)){
    $lista.="<tr><td>$lineas[incompatibles]</td>";
    
}
echo preg_replace("/{datos}/", $lista, $tabla);


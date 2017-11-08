<?php
    include '../conexion.php';
$tabla=  explode('/', $_SERVER[QUERY_STRING])[1];
$id_enc=  explode('/', $_SERVER[QUERY_STRING])[0];

    $sql="select * from $tabla where id_enc=$id_enc";
  $res=$conex->query($sql);


$plantilla='<table>
  <thead>
    <tr>
      <th width="200">actividad</th>
      <th>tipo</th>
      <th width="150">costo</th>
      
    </tr>
  </thead>
  <tbody>
  {}
  </tbody>
  </table>';
$datos='';

while($fila=$res->fetch()){
    $datos.="<tr><td>$fila[actividad]</td><td>$fila[tipo_costo]</td><td>$fila[costo]</td></tr>";
}

echo preg_replace('/{}/', $datos, $plantilla);
    

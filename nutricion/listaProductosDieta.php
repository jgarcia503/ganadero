<?php
include '../conexion.php';
$sql="select * from alimentacion_lns where enc_id=$_GET[id]";
$res=$conex->query($sql);

$tabla="<table>
  <thead>
    <tr>
      <th>producto</th>     
      <th>cantidad</th>     
      <th>unidad</th>     
    </tr>
  </thead>
  <tbody>
  {datos}
  </tbody>
</table>";
        
while($fila=$res->fetch()){    
    $lista.="<tr><td>$fila[producto_id]</td><td> $fila[cantidad]</td><td> $fila[unidad]</td></tr>";
}

$tabla=preg_replace("/{datos}/", $lista, $tabla);

echo $tabla;
echo '<a class="close-reveal-modal" aria-label="Close">&#215;</a>';
//include '../conexion.php';
//$sql="select regexp_split_to_table(rtrim(producto,','),',') prod
//,regexp_split_to_table(rtrim(cantidad,','),',') cant 
//from dietas where id=$_GET[dieta]";
//$res=$conex->query($sql);
//
//$tabla="<table>
//  <thead>
//    <tr>
//      <th>producto</th>     
//      <th>cantidad</th>     
//    </tr>
//  </thead>
//  <tbody>
//  {datos}
//  </tbody>
//</table>";
//        
//while($fila=$res->fetch()){    
//    $lista.="<tr><td>$fila[prod]</td><td> $fila[cant]</td></tr>";
//}
//
//$tabla=preg_replace("/{datos}/", $lista, $tabla);
//
//echo $tabla;
//echo '<a class="close-reveal-modal" aria-label="Close">&#215;</a>';
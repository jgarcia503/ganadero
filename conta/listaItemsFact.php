<?php
include '../conexion.php';
$id=$_GET[id];//id encabezado factura

$sql="select * from tratamientos_lns where id_enc=$id";
$res=$conex->query($sql);
$tabla="<table>
  <thead>
    <tr>
      <th>nombre</th>     
      <th>cantidad</th>     
      <th>medida</th>           
    </tr>
  </thead>
  <tbody>
  {datos}
  </tbody>
</table>";

while($fila=$res->fetch()){
    $lista.="<tr>"
                      . "<td>$fila[nombre]</td>"
                      . "<td>$fila[cantidad]</td>"
                      . "<td>$fila[medida]</td>"                      
                      . "</tr>";
}

$tabla=preg_replace("/{datos}/", $lista, $tabla);

echo $tabla;
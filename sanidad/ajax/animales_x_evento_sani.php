<?php
include '../../conexion.php';

$id=$_GET[id];

$sql="select fecha,hora,animal  from controles_sanitarios where evento in (select nombre from eventos_sanitarios where id=$id)";
$sql2="select nombre from eventos_sanitarios where id=$id";
$res2=$conex->query($sql2)->fetchColumn();
$res=$conex->query($sql);

$tabla="
    <h4>animales con el evento $res2</h4>
<table>
  <thead>
    <tr>
      <th width='100px' >fecha</th>     
      <th width='100px' >hora</th>     
      <th width='100px' >animal</th>           
    </tr>
  </thead>
  <tbody>
  {datos}
  </tbody>
</table>";

$lineas="";
while($fila=$res->fetch()){
    $lineas.="<tr>";
    $lineas.="<td>$fila[fecha]</td>";
    $lineas.="<td>$fila[hora]</td>";
    $lineas.="<td>$fila[animal]</td>";
    $lineas.="</tr>";
}
echo preg_replace('/{datos}/', $lineas, $tabla);

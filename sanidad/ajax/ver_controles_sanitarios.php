<?php

include '../../conexion.php';
$animal=$_GET[animal];

$sql="select fecha,hora,evento,empleado from controles_sanitarios where animal='$animal'";

$datos=$conex->query($sql);

$tabla="
<h1>registro sanitario de $_GET[animal]</h1>    
<table id='tabla_modal' class='table' data-filtering='true' data-paging='true'>
  <thead>
    <tr>
      <th width='100px' >fecha</th>     
      <th width='100px' >hora</th>     
      <th width='100px' >empleado</th>     
      <th width='100px' >evento</th>           
    </tr>
  </thead>
  <tbody>
  {datos}
  </tbody>
</table>";

$lineas='';
while($fila=$datos->fetch()){
    $lineas.="<tr>";
    $lineas.="<td>";
    $lineas.=$fila[fecha];    
    $lineas.="</td>";
    $lineas.="<td>";
    $lineas.=$fila[hora];    
    $lineas.="</td>";
    $lineas.="<td>";
    $lineas.=$fila[empleado];    
    $lineas.="</td>";
    $lineas.="<td>";
    $lineas.=$fila[evento];    
    $lineas.="</td>";    
    $lineas.="</tr>";
}

echo preg_replace('/{datos}/', $lineas, $tabla);

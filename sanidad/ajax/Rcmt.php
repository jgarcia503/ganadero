<?php

include '../../conexion.php';

$tabla="<table>
  <thead>
    <tr>
      <th>numero</th>     
      <th>nombre</th>     
      <th>ubre 1</th>     
      <th>ubre 2</th>     
      <th>ubre 3</th>     
      <th>ubre 4</th>     
    </tr>
  </thead>
  <tbody>
  {datos}
  </tbody>
</table>";

$sql="SELECT a.*,b.nombre from pruebas_cmt a
inner join animales b on b.numero=a.animal
where fecha ='$_GET[fecha]' ";
$lineas="";
$res=$conex->query($sql);
while($fila=$res->fetch()){
    $lineas.="<tr>";
    $lineas.="<td>".$fila[animal]."</td>";
    $lineas.="<td>".$fila[nombre]."</td>";
    $lineas.="<td>".$fila[ubre_1]."</td>";
    $lineas.="<td>".$fila[ubre_2]."</td>";
    $lineas.="<td>".$fila[ubre_3]."</td>";
    $lineas.="<td>".$fila[ubre_4]."</td>";
    $lineas.="</tr>";
    
}

echo preg_replace('/{datos}/', $lineas, $tabla);
<?php

include '../../conexion.php';
$lote=$_SERVER[QUERY_STRING];
$sql="select a.nombre from animales a , grupos b  where  a.grupo =b.id::varchar and b.id=$lote";
$res=$conex->query($sql);
$animal=$res->fetchAll(PDO::FETCH_ASSOC);

$plantilla='<table>
  <thead>
    <tr>
      <th width="200">nombre</th>
 
    </tr>
  </thead>
  <tbody>
    
      {datos}
        
  </tbody>
</table>';
$datos='';

foreach ($animal as $valor){

        $datos.="<tr>";
        $datos.="<td>$valor[nombre]</td>";        
  
        $datos.="</tr>";
    
}
echo "<h1>animales en este grupo</h1>";
echo preg_replace('/{datos}/', $datos, $plantilla);
<?php


include '../../conexion.php';
$id=$_GET[id];

$plantilla='
<h1>Existencias de producto por bodega</h1>    
<table width=90%>
          <thead>
            <tr>
              <th  >nombre</th>
              <th >existencia</th>
              <th >categoria</th>
              <th >marca</th>
              
              
            </tr>
          </thead>
          <tbody>

            {datos}

          </tbody>
        </table>';

$sql="select b.nombre,a.existencia,b.categoria,b.marca from existencias a "
        . "inner join productos b on a.codigo_producto=b.referencia  where codigo_bodega ='$id'";

$res=$conex->query($sql);
$datos='';
while($fila=$res->fetch()){
    $datos.="<tr>";
    $datos.="<td>$fila[nombre]</td>";
    $datos.="<td>$fila[existencia]</td>";
    $datos.="<td>$fila[categoria]</td>";
    $datos.="<td>$fila[marca]</td>";
    
    $datos.="</tr>";
}
$plantilla=preg_replace('/{datos}/', $datos, $plantilla);
echo $plantilla;
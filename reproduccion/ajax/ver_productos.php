<?php
include '../../conexion.php';

$id=$_GET[id];
$res=$conex->query("select b.nombre ,a.cantidad,a.unidad from plantilla_servicios_requisicion_lns a join productos b 
on b.referencia=a.producto_id
  where enc_id='$id'");

$tabla='<h1>productos</h1>    
<table width=90%>
          <thead>
            <tr>
              <th  >nombre</th>
              <th >cantidad</th>
              <th >unidad</th>

            </tr>
          </thead>
          <tbody>

            {datos}

          </tbody>
        </table>';

while($fila=$res->fetch()){
    $datos.="<tr>";
    $datos.="<td>$fila[nombre]</td>";
    $datos.="<td>$fila[cantidad]</td>";
    $datos.="<td>$fila[unidad]</td>";
        
    $datos.="</tr>";
    
}
echo preg_replace('/{datos}/', $datos, $tabla);


<?php

include '../../conexion.php';

$id=$_GET[id];
$sql="select * from requisicion_lns a inner join productos b on a.producto=b.referencia where a.enc_id='$id'";

$res=$conex->query($sql);


$plantilla='<table width=90%>
          <thead>
            <tr>
              <th>producto</th>
              <th>cantidad</th>
              <th>costo</th>
              <th>unidad</th>
              <th>importe</th>              
            </tr>
          </thead>
          <tbody>

            {datos}

          </tbody>
        </table>';
$datos='';

while($fila=$res->fetch(PDO::FETCH_ASSOC)){
   $datos.="<tr>";
        
   $datos.="<td>$fila[nombre]</td>";
   $datos.="<td>$fila[cantidad]</td>";   
   $datos.="<td>$fila[costo]</td>";
   $datos.="<td>$fila[unidad]</td>";
   $datos.="<td>$fila[importe]</td>";
   
   $datos.="</tr>";
    
}
$plantilla=preg_replace('/{datos}/', $datos, $plantilla);
echo $plantilla;
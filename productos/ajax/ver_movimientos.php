<?php

include '../../conexion.php';

extract($_GET);

$sql="select * from kardex where codigo_producto ='$prod_id'  ";
$sql.=  $bodega==='todas'?' ': "and codigo_bodega='$bodega'  ";
$sql.= "and fecha::date between '$desde' and '$hasta'  ";

$plantilla="
    <div class='row'>
<h2>movimientos</h2>
<div class='small-12  columns' >
            <table width=100%>
              
          <thead>
            <tr>
               <th>producto</th>
              <th >tipo doc</th>
              <th >no doc</th>
              <th >costo</th>
              <th >entrada</th>
              <th >salida</th>
              <th >bodega</th>
              
            </tr>
          </thead>
          <tbody>

            {datos}

          </tbody>
        </table>
</div>

</div>";
$res=$conex->query($sql);

$datos='';


    
while($fila=$res->fetch(PDO::FETCH_BOTH)){
        $datos.="<tr>";
        
   $datos.="<td>$fila[codigo_producto]</td>";
   $datos.="<td>$fila[tipo_doc]</td>";
   $datos.="<td>$fila[no_doc]</td>";
   $datos.="<td>$fila[costo]</td>";
   $datos.="<td>$fila[entrada]</td>";
   $datos.="<td>$fila[salida]</td>";
   $datos.="<td>$fila[codigo_bodega]</td>";
  
   $datos.="</tr>";
}
echo preg_replace('/{datos}/', $datos, $plantilla);
<?php
include '../../conexion.php';

$id=  filter_input(INPUT_SERVER, 'QUERY_STRING');

$sql="select a.nombre producto,b.existencia,c.nombre bodega from productos a 
inner join existencias b on a.referencia=b.codigo_producto
inner join bodega c on c.codigo=b.codigo_bodega
where a.referencia='$id'";

$plantilla="<div class='row'>
<h2>existencias</h2>
<div class='small-12  columns' >
            <table width=100%>            
          <thead>
            <tr>
               <th >producto</th>
              <th  >existencia (kg)</th>
              <th  >bodega</th>
              
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
while($lineas=$res->fetch(PDO::FETCH_ASSOC)){
    $datos.="<tr>";
   $datos.="<td>$lineas[producto]</td>";
   $datos.="<td>$lineas[existencia]</td>";
   $datos.="<td>$lineas[bodega]</td>";
  
   $datos.="</tr>";
}

echo preg_replace('/{datos}/', $datos, $plantilla);
//echo $plantilla;


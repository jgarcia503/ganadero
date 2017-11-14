<?php

include '../../conexion.php';
$id=$_GET[id];
$sql="select *,b.nombre bodega from compras_lns a inner join bodega b on b.codigo=a.bodega  where enc_id='$id'";
$sql2="select * from compras_enc where id='$id'";
$res=$conex->query($sql);
$res2=$conex->query($sql2)->fetch();

$plantilla="<div class='row'>
    <div class='small-12 columns'>
  <table  width='25%'>

        <tbody>
          <tr>
              <th>Documento No</th>
            <td>
            $res2[doc_no]
            </td>
                <th>Tipo doc.</th>
            <td>
            $res2[tipo_doc]
            </td>
            
          </tr>
          <tr>
              <th>fecha</th>            
            <td>$res2[fecha]</td>
            
            <th>proveedor</th>            
            <td>$res2[proveedor]</td>
          </tr>

        </tbody>
            </table>    
</div>
<div class='small-12  columns' >
            <table width=100%>
          <thead>
            <tr>
              <th  >bodega</th>
              <th  >referencia</th>
              <th >producto</th>
              <th >cantidad</th>
              <th >unidad</th>
              <th >precio</th>
              
              <th >subtotal</th>
            </tr>
          </thead>
          <tbody>

            {datos}

          </tbody>
        </table>
</div>
<div class='small-2 small-offset-10 columns'>

<table  width='50%' class='right'>

        <tbody>
          <tr>
              <td>total</td>
            <td>
            $res2[total]
            </td>

          </tr> 

        </tbody>
            </table>    

</div>

</div>";

$datos='';
while($lineas=$res->fetch(PDO::FETCH_ASSOC)){
    $datos.="<tr>";
   $datos.="<td>$lineas[bodega]</td>";
   $datos.="<td>$lineas[referencia]</td>";
   $datos.="<td>$lineas[producto]</td>";
   $datos.="<td>$lineas[cantidad]</td>";
   $datos.="<td>$lineas[unidad]</td>";
   $datos.="<td>$lineas[precio]</td>";   
   $datos.="<td>".  number_format(floatval($lineas[cantidad]) * floatval($lineas[precio]),2)."</td>";
   $datos.="</tr>";
}

$plantilla=preg_replace('/{datos}/', $datos, $plantilla);
echo $plantilla;


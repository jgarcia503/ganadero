<?php
include '../../vendor/autoload.php';
include '../../conexion.php';
use Dompdf\Dompdf;


$id=$_GET[id];
$sql="select *,b.nombre bodega from compras_lns a inner join bodega b on b.codigo::text=a.bodega  where enc_id='$id'";
$sql2="select * from compras_enc where id='$id'";
#para ver los gastos asociados a esta compra
$sql3="select concepto,valor from compras_otros_gastos where id_enc=$id";
$res=$conex->query($sql);
$res2=$conex->query($sql2)->fetch();
$res3=$conex->query($sql3);

$plantilla="<div class='row'>
    <div class='small-12 columns'>
    <img src='../../assets/img/paso.png'>
    <h1>Registro de factura</h1>    
  <table  width='25%' border='1'>

        <tbody>
          <tr>
              <th width='90px'>Documento No</th>
            <td width='90px'>
            $res2[doc_no]
            </td>
                <th width='90px'>Tipo doc.</th>
            <td width='90px'>
            $res2[tipo_doc]
            </td>
            
          </tr>
          <tr>
              <th width='90px'>fecha</th>            
            <td width='90px'>$res2[fecha]</td>
            
            <th width='90px'>proveedor</th>            
            <td width='90px'>$res2[proveedor]</td>
          </tr>

        </tbody>
            </table>    
</div>
<br>

<div class='small-12 columns'>
<table  width='25%' border='1'>
  <tbody>
         <tr>
              <th>concepto</th>
              <th>valor</th>
            </tr>";
if($res3!==FALSE){
while($fila=$res3->fetch(PDO::FETCH_ASSOC)){
        $plantilla.="<tr>";
        $plantilla.="<td>";
        $plantilla.=$fila[concepto];
        $plantilla.="</td>";
        $plantilla.="<td>";
        $plantilla.=$fila[valor];
        $plantilla.="</td>";
        $plantilla.="</tr>";
    }
}
$plantilla.="
            </tbody>
            </table>    
            </div>
 <br>

<div class='small-12  columns' >
            <table width=100% border='1'>
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

<table  width='25%' style='float:right'  border='1'>

        <thead>
          <tr>
              <th>total</th>
            <td>".
number_format($res2[total],2)
        ."
            </td>

          </tr> 

        </thead>
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
   $datos.="<td>".number_format($lineas[precio],2)."</td>";   
   $datos.="<td>".  number_format(floatval($lineas[cantidad]) * floatval($lineas[precio]),2)."</td>";
   $datos.="</tr>";
}


$dompdf = new Dompdf();
$dompdf->loadHtml(preg_replace('/{datos}/', $datos, $plantilla));

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('letter', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();
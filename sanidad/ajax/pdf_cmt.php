<?php
include '../../vendor/autoload.php';
include '../../conexion.php';
use Dompdf\Dompdf;

$tabla="
<h1>Pruebas CMT de $_GET[fecha]</h1>    
<table border='1'>
  <thead>
    <tr>
      <th width='100px' ><center>numero</center></th>     
      <th width='100px' ><center>nombre</center></th>     
      <th width='100px' ><center>DI</center></th>     
      <th width='100px' ><center>DR</center></th>     
      <th width='100px' ><center>TI</center></th>     
      <th width='100px' ><center>TD</center></th>     
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
    $lineas.="<td><center>".$fila[animal]."</center></td>";
    $lineas.="<td><center>".$fila[nombre]."</center></td>";
    if($fila[ubre_1]==3 or $fila[ubre_1]=='c'){
       $lineas.="<td  style='background-color: red;'><center>".$fila[ubre_1]."</center></td>";
    }else{
        $lineas.="<td  ><center>".$fila[ubre_1]."</td>";
    }
   //$lineas.="<td ".($fila[ubre_1]=='3')?"style='background-color:red' >":'>'.$fila[ubre_1]."</td>";
    if($fila[ubre_2]==3 or $fila[ubre_2]=='c'){
    $lineas.="<td  style='background-color: red;'><center>".$fila[ubre_2]."</center></td>";
    }else{
        $lineas.="<td  ><center>".$fila[ubre_2]."</center></td>";
    }
    
    if($fila[ubre_3]==3 or $fila[ubre_3]=='c'){
    $lineas.="<td  style='background-color: red;'><center>".$fila[ubre_3]."</center></td>";
    }
    else{
        $lineas.="<td  ><center>".$fila[ubre_3]."</center></td>";
    }
        if($fila[ubre_4]==3 or $fila[ubre_4]=='c'){
    $lineas.="<td  style='background-color: red;'><center>".$fila[ubre_4]."</center></td>";
    }
    else{
        $lineas.="<td  ><center>".$fila[ubre_4]."</center></td>";
    }


    $lineas.="</tr>";
    
}


$dompdf = new Dompdf();
$dompdf->loadHtml(preg_replace('/{datos}/', $lineas, $tabla));

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('letter', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();



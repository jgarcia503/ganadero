<?php

include '../../conexion.php';
$id=$_SERVER[QUERY_STRING];
$sql="select *,(select precio_leche::float from configuraciones) precio_base"
        . ",
(((select precio_leche::float from configuraciones)*cantidad_botellas::float)+grasa_valor::float+proteina_valor::float+rcs_x_1000::float+reductasa_valor::float+acidez_valor::float+temperatura_valor::float+agua_valor::float)/cantidad_botellas::float
        valor"
        . " from analisis_leche where id=$id";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);

$plantilla="<div style='overflow-x: scroll;margin-top:40px'><table>"
        . "<tr>"
        . "<td rowspan='2'>fecha</td>"
        . "<td rowspan='2'>recep No</td>"
        . "<td rowspan='2'>Cant.</td>"
        . "<td rowspan='2'>precio original</td>"
        . "<td colspan='2'>grasa</td>"
        . "<td colspan='2'>proteina</td>"
        . "<td colspan='2'>rcs</td>"
        . "<td colspan='2'>reductasa</td>"
        . "<td colspan='2'>acidez</td>"
        . "<td colspan='2'>temperatura</td>"
        . "<td colspan='2'>% de agua</td>"
        . "<td rowspan='2'>precio</td>"
        . "</tr>"
        . "<tr>"
        . "<td>%</td>"
        . "<td>valor</td>"
        . "<td>%</td>"
        . "<td>valor</td>"
        . "<td>x1000</td>"
        . "<td>valor</td>"
        . "<td>%</td>"
        . "<td>valor</td>"
        . "<td>%</td>"
        . "<td>valor</td>"
        . "<td>%</td>"
        . "<td>valor</td>"
        . "<td>%</td>"
        . "<td>valor</td>"
        . "</tr>"
        . "<tr>"
        . "<td>$animal[fecha]</td>"        
        . "<td>$animal[recepcion_no]</td>"        
        . "<td>$animal[cantidad_botellas]</td>"        
        . "<td>$animal[precio_base]</td>"        
        . "<td>".$animal['grasa_%']."</td>"        
        . "<td>$animal[grasa_valor]</td>"        
        . "<td>".$animal['proteina_%']."</td>"        
        . "<td>$animal[proteina_valor]</td>"        
        . "<td>$animal[rcs]</td>"        
        . "<td>$animal[rcs_x_1000]</td>"        
        . "<td>".$animal['reductasa_%']."</td>"        
        . "<td>$animal[reductasa_valor]</td>"        
        . "<td>".$animal['acidez_%']."</td>"        
        . "<td>$animal[acidez_valor]</td>"        
        . "<td>".$animal['temperatura_%']."</td>"        
        . "<td>$animal[temperatura_valor]</td>"        
        . "<td>".$animal['agua_%']."</td>"        
        . "<td>$animal[agua_valor]</td>"        
        . "<td>".number_format($animal[valor],4)."</td>"        
        . "</tr>"        
        . "</table>";
//$datos='';

//foreach ($animal as $key=>$valor){
//if($key!='id'){
//    $key=ucwords(preg_replace('/_/', ' ', $key));
//            if($valor==null){
//                
//                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
//            }else{
//                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
//            }
//}
//}

//echo $datos;
echo $plantilla;

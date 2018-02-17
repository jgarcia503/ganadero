<?php
//session_start();
include '../../conexion.php';
//unset($_SESSION['traslado']);
$bodega_id=$_GET[bodega_id];

$sql_prods_bodega="select a.codigo_producto,a.existencia,b.nombre,b.unidad_standar "
                                                    . "from existencias a "
                                                    . "inner join productos b on b.referencia=a.codigo_producto "
                                                    . "where codigo_bodega='$bodega_id' "
                                                    . "and existencia::numeric(1000,2)>0";

$sql_bod_destino="select * from bodega where codigo<>'$bodega_id'";
$res_bodga_dst=$conex->query($sql_bod_destino);
$res=$conex->query($sql_prods_bodega);
$datos=[];
$opciones_prod="<option value=''>seleccione</option>";
$opciones_bod="<option value=''>seleccione</option>";

$unit_prod=[];
$unit_peso="<option value=''>seleccione</option>"
        . "<option value='qq'>quintal</option>"
        . "<option value='g'>gramos</option>"
        . "<option value='kg'>kilogramos</option>"
        . "<option value='oz'>onzas</option>"
        . "<option value='lb'>libras</option>";

$unit_vol="<option value=''>seleccione</option>"
        . "<option value='lt'>litros</option>"
        . "<option value='ml'>mililitros</option>";

while($fila=$res->fetch()){
//        if($fila[unidad_standar]=='kg'){
//                $unit_prod[$fila[codigo_producto]]=$unit_peso;
//    }else{
//              $unit_prod[$fila[codigo_producto]]=$unit_vol;
//    }
    switch ($fila[unidad_standar]) {
        case 'kg':
            $unit_prod[$fila[codigo_producto]] = $unit_peso;

            break;
        case 'lt':
            $unit_prod[$fila[codigo_producto]] = $unit_vol;
            break;

        case 'cc':
            $unit_prod[$fila[codigo_producto]] = "<option values='cc'>cc</option>";
            break;
    }
      $opciones_prod.="<option value='$fila[codigo_producto]' data-unidad='$fila[unidad_standar]'>$fila[nombre]</option>";
      //$_SESSION['traslado'][$fila[codigo_producto]]=$fila[existencia];
}

while($bodega_dst=$res_bodga_dst->fetch()){
    $opciones_bod.="<option value='$bodega_dst[codigo]'>$bodega_dst[nombre]</option>";
}

$datos[opciones]=$opciones_prod;
$datos[bodega_dst]=$opciones_bod;
$datos[unit_prod]=$unit_prod;

echo json_encode($datos);
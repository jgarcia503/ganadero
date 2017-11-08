<?php
//include '../../conexion.php';
//$proy_id=$_GET[proy_id];
//$nom_prod=$_GET[prod];
//$sql="select existencia from existencias where codigo_producto =(select referencia from productos where nombre='$nom_prod') "
//           . "and codigo_bodega = (select bodega_seleccionada from proyectos_enc where id_proyecto =$proy_id)";
//
//echo floatval($conex->query($sql)->fetch()[existencia]);
session_start();
include '../../php funciones/funciones.php';
include '../../conexion.php';
$tipo=$_GET[tipo];
$producto=$_GET[prod];
$cantidad=$_GET[cantidad];
$unidad=$_GET[unidad];
$cant_conv=  convertir($unidad, $cantidad);
$datos=[];
switch ($tipo){
    #add cantidad
   case '+':
       $_SESSION['inventario'][$producto]+=$cant_conv;
       break;
   #decrease cantidad
   case '-':
    
       if(floatval($_SESSION['inventario'][$producto])>=$cant_conv){
                $_SESSION['inventario'][$producto]-=$cant_conv;
                $datos['importe']= floatval($_SESSION['costo_unit'][$producto]*$cant_conv);
       }
       else{
           $datos['mensaje']=  "disponible ".$_SESSION['inventario'][$producto]." kg";
       }
       break;
   
}


echo json_encode($datos);


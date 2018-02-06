<?php

include '../conexion.php';
 
function calcular_costo_proyecto($enc_id){
    global $conex;
    $sql="select sum(subtotal::numeric(1000,2)) total from proyectos_lns where enc_id ='$enc_id'";
    $costo_total=  floatval($conex->query($sql)->fetch()[total]);
    return $costo_total;
}

function convertir($unidad,$cantidad){
    #unidades estandar dentro del sistema kg y litros
    
    #de peso
    $conversiones['qq']=100;#quintal 100kg
    $conversiones['ton']=1000;
    $conversiones['g']=0.001;
    $conversiones['kg']=1;
    $conversiones['oz']=0.03;
    $conversiones['lb']=0.45;
    #de volumen
    $conversiones['ml']=0.001;
    $conversiones['lt']=1;
    if(array_key_exists($unidad, $conversiones)){
    $resultado=$conversiones[$unidad]*floatval($cantidad);
    
    return $resultado;    
    }
    return $cantidad;
}

function check_permiso($url,$archivo,$titulo){
    switch($url){
    case 2:
    case 4:
    case 5:
$uri=$_SERVER[REQUEST_URI];
$uri=substr($uri,0,strrpos($uri,'/')).'/'.$archivo;
$_SESSION[permisos][$uri]=true;
if($archivo!=='#'){
echo "<a href='$archivo' class='button primary'>$titulo</a>";
}
else{
    echo "<a href='$archivo' id='crear' class='button primary'>$titulo</a>";
}
        
break;
        
    }
}



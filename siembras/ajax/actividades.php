<?php

include '../../conexion.php';
include '../../php clases/kardex.php';
include '../../php clases/kardex_activo.php';

$info = $_GET[datos];
$sql = "with insertados as (insert into proyectos_lns values ";
#$sql_sublinea="insert into proyectos_lns(id,producto,cantidad,costo,enc_id,grupo,fecha_ingreso_act,fecha) values ";
//$sql_grupo="select max(case when grupo is null then '1' else grupo end) from proyectos_lns where enc_id='$info[proy_id]'";
//$sql_grupo="select max(grupo) from proyectos_lns where enc_id='$info[proy_id]'";
//$res_grupo=$conex->query($sql_grupo)->fetch()[max];
//if(is_null($res_grupo)){
//    $grupo= 1;
//}else{
//    $grupo=  intval($res_grupo)+1;
//}
$sql_find_bodega = "select bodega_seleccionada from proyectos_enc where id_proyecto=$info[proy_id]";
$find_bodega = $conex->query($sql_find_bodega)->fetch()[bodega_seleccionada];

$decrease_inventario = [];


foreach ($info[acts] as $lineas) {

    $sql.="(default,";
    $sql.="'" . $lineas[actividad] . "'" . ',';
    $sql.="'" . $lineas[tipo] . "'" . ',';
    $sql.=($lineas[tipo]=='material'? "'" . $lineas[producto] . "'" : "''"). ',';
    //$sql.="'" . $lineas[costo] . "'" . ',';
    $sql.=$lineas[tipo]=='deterioro activo'?"'',": "'" . $lineas[costo] . "'" . ',';
    //$sql.="'" . $lineas[dias_cant] . "'" . ',';
    $sql.= $lineas[tipo]=='deterioro activo'?"'',":  "'" . $lineas[dias_cant] . "'" . ',';
    #$sql.="'".$grupo."'".',';
    #$sql.="now(),";
    $sql.="'" . $lineas[fecha] . "'" . ',';
    $sql.=($lineas[tipo]=='material'?"'" . $lineas[unidad] . "'":"''") . ',';
    $sql.="'" . $lineas[subtotal] . "'" . ',';
    $sql.="now(),";
    $sql.="'" . $info[proy_id] . "'" . ',';
    $sql.="'" . $lineas[notas] . "'".',';
    $sql.=($lineas[tipo]=='deterioro activo'? "'" . $lineas[activo] . "','".$lineas[costo_hora_uso]."'," : "'','',");
    $sql.=($lineas[tipo]=='material'?"35,":"'',");
    

    if ($lineas[tipo] == 'material') {
        $sql_prod = "select referencia from productos where nombre='$lineas[producto]'";
        $referencia = $conex->query($sql_prod)->fetch()[referencia];

        if (array_key_exists($referencia, $decrease_inventario)) {
            $decrease_inventario[$referencia] += convertir($lineas[unidad], $lineas[dias_cant]);
        } else {
            
            $decrease_inventario[$referencia] = convertir($lineas[unidad], $lineas[dias_cant]);
        }
    }

if($lineas[tipo]=='deterioro activo'){
    $sql_costo_hora_uso="select (precio_promedio::numeric(10,5)/vida_util::numeric(10,5))::numeric(10,4) costo_hora_uso "
                                                                . "from activo where  referencia ='$lineas[activo]'";
    $res=$conex->query($sql_costo_hora_uso)->fetchColumn();
    $sql.="$res";
    
}else{
    $sql.="'-'";
}

$sql.="),";

//    foreach ($lineas[lineas] as $sublinea=>$value){
//        $sql_sublinea.="(default,";
//        $sql_sublinea.="'".$lineas[lineas][$sublinea][producto]."'".",";
//        $sql_sublinea.="'".$lineas[lineas][$sublinea][cantidad]."'".",";
//        $sql_sublinea.="'".$lineas[lineas][$sublinea][costo]."'".',';
//        $sql_sublinea.="'".$info[proy_id]."'".',';
//        $sql_sublinea.="'".$grupo."'".',';
//        $sql_sublinea.="now(),";
//        $sql_sublinea.="'".$lineas[fecha]."'";
//        $sql_sublinea.="),";
//        
//        $referencia=$lineas[lineas][$sublinea][referencia];
//        
//
//
//    }
#$grupo++;
}
$sql = trim($sql, ',');
$sql.=" returning id,tipo,cantidad_dias,unidad,producto) select * from insertados where tipo='material'";
#$sql_sublinea=  trim($sql_sublinea,',');

$insert = $conex->prepare($sql);
#$insert_2=$conex->prepare($sql_sublinea);

if ($insert->execute()) {
    $actividades_insertadas=$insert->fetchAll(PDO::FETCH_ASSOC);
    $kardex = new kardex();
    $kardex->decrease_inventario($decrease_inventario, $find_bodega);    
    echo '<div data-alert class="alert-box success round">
        <h5 style="color:white">registro creado exitosamente</h5>
        <a href="#" class="close">&times;</a>
        </div>';
} else {
    echo "<div data-alert class='alert-box alert round'>
       <h5 style='color:white'>Error al insertar el registro</h5>
       <a href='#' class='close'>&times;</a>
       </div>";
}

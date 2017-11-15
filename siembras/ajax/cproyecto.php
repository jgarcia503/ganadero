<?php
include '../../conexion.php';
$nombre=$_GET[nombre];
$f_inicio=$_GET[fecha_inicio];
$estatus=$_GET[cerrado];
$notas=$_GET[notas];
$potrero_id=$_GET[potrero];
$tablon_id=$_GET[tablones];
$tipo_cultivo=$_GET[tipo];
$bodega=$_GET[bodega];
$sql_correlativo="select (count(to_char(fecha_inicio::date,'YYYY'))+1) correlativo from proyectos_enc  where to_char(fecha_inicio::date,'YYYY')='".explode('-', $f_inicio)[2]."'";
$res_corr=$conex->query($sql_correlativo);
$correlativo_proyecto=  explode('-', $f_inicio)[2].explode('-', $f_inicio)[1].'_'.$tipo_cultivo.'_'.$res_corr->fetchColumn(); 

$sql="insert into "
        . "proyectos_enc(id_proyecto,nombre_proyecto,fecha_inicio,cerrado,bodega_seleccionada,tipo_cultivo,notas,correlativo_proyecto) "
        . "values(default,'$nombre','$f_inicio','$estatus','$bodega','$tipo_cultivo','$notas','$correlativo_proyecto') returning id_proyecto";
try{
     $conex->beginTransaction();
     $insert=$conex->prepare($sql);
     if($insert->execute()){
                            $proyecto_id = $insert->fetchColumn();
        $tablones_id = implode(',', $tablon_id);
        $sql2 = "insert into proyecto_tablones values(default,'$proyecto_id','$potrero_id','$tablones_id')";
        $insert2 = $conex->prepare($sql2);
        if ($insert2->execute()) {
            $sql3 = "update tablones set estatus='ocupado' where id in ($tablones_id)";
            $update = $conex->prepare($sql3);

            if ($update->execute()) {
                $conex->commit();
                echo '<div data-alert class="alert-box success round">
                                                    <h5 style="color:white">registro creado exitosamente</h5>
                                                    <a href="#" class="close">&times;</a>
                                                    </div>';
            } else {
                throw new PDOException;
            }
        } else {
            throw new PDOException;
        }
    } else {
        throw new PDOException;
    }
}#bloque try
 catch (PDOException $pe){
                $conex->rollBack();
     echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
     
 }
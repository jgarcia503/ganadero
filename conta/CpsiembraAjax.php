<?php
include_once '../conexion.php';
$mensaje='';
$sql="insert into siembra_enc values(default,'".
        filter_input(INPUT_GET, 'nombre')."','".
        filter_input(INPUT_GET, 'etapa_ant')."','".
        filter_input(INPUT_GET, 'fecha_inicio')."','".
        filter_input(INPUT_GET, 'fecha_fin')."','".
        filter_input(INPUT_GET, 'cerrado')."','".
        filter_input(INPUT_GET, 'notas').
        "') returning id";

$insert=$conex->prepare($sql);

if($insert->execute()){
    $ultimo_id=$insert->fetchColumn();
            
            
    echo  '<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>'."|$ultimo_id";
}else{
       echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
}


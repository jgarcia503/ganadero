<?php
include '../conexion.php';

$pesos=  explode('|',trim( $_GET[pesos],'|'));
$notas=$_GET[notas];
$empleado=$_GET[empleado];
$fecha=$_GET[fecha];
$sql="insert into bit_peso_leche_enc values(default,'$fecha','$empleado','$notas') returning id";
$sql2="insert into bit_peso_leche_lns values ";
$insert=$conex->prepare($sql);
$hora="";
$numero="";
$nombre="";
$pesaje="";
if($insert->execute()){//insercion en bit_peso_leche_enc 
    $ultimo_id=$insert->fetch()[id];
    foreach ($pesos as $peso){
        $peso=  explode(',',trim($peso,','));
                
                                            $hora.=$peso[0].',';
                                            $numero.=$peso[1].',';
                                            $nombre.=$peso[2].',';
                                            $pesaje.=$peso[3].',';
                
                }
                
               $valores.="(default,'$hora','$numero','$nombre','$pesaje',$ultimo_id)";                       
               $sql2.=$valores;
               $insert=$conex->prepare($sql2);
               if($insert->execute()){
                           echo '<div data-alert class="alert-box success round">
                <h5 style="color:white">registro creado exitosamente</h5>
                <a href="#" class="close">&times;</a>
                </div>';
               }else{
                           echo '<div data-alert class="alert-box alert round">
                <h5 style="color:white">error al crear el registro</h5>
                <a href="#" class="close">&times;</a>
                </div>';
               }
    
}else{
            echo '<div data-alert class="alert-box alert round">
        <h5 style="color:white">error al crear el registro</h5>
        <a href="#" class="close">&times;</a>
        </div>';

}





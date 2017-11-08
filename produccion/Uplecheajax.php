<?php
include '../conexion.php';

$pesos=  explode('|',trim( $_GET[pesos],'|'));
$notas=$_GET[notas];
$empleado=$_GET[empleado];
$fecha=$_GET[fecha];
$sql="update bit_peso_leche_enc set fecha='$fecha',empleado='$empleado',notas='$notas' where id=$_GET[id_enc]";
$sql2="update bit_peso_leche_lns set ";
$insert=$conex->query($sql);
$hora="";
$numero="";
$nombre="";
$pesaje="";
if($insert->execute()){//insercion en bit_peso_leche_enc 
    
    foreach ($pesos as $peso){
        $peso=  explode(',',trim($peso,','));
                
                                            $hora.=$peso[0].',';
                                            $numero.=$peso[1].',';
                                            $nombre.=$peso[2].',';
                                            $pesaje.=$peso[3].',';
                
                }
                
               $valores.="hora='$hora',numero='$numero',nombre='$nombre',peso='$pesaje' where id_enc=$_GET[id_enc]";                       
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





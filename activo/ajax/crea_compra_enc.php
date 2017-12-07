<?php

include '../../conexion.php';
 //include '../../php clases/kardex.php';

    try{
        unset($_GET[gastos_rowOrder]);#viene por defecto del plugin appendgrid,en esta caso no me sirve
        $datos=[];
        $doc_no=$_GET[fac_no];
        $fecha=$_GET[fecha];
        $proveedor=$_GET[proveedor];
        $tipo_doc=$_GET[tipo_doc];
        $sql="insert into compras_activo_enc (id,fecha,doc_no,tipo_doc,proveedor,fecha_ingreso_fact,aplicada) values(default,'$fecha','$doc_no','$tipo_doc','$proveedor',now(),'0') returning id";
        $conex->beginTransaction();
        $insert=$conex->prepare($sql);
        //$sql_lns="insert into compras_lns values ";
        if($insert->execute())   {
            $id=$insert->fetchColumn();
            agrega_gastos($id);
            $conex->commit();
            $datos['id']=$id;
            $datos['ok']= '<div data-alert class="alert-box success round">
            <h5 style="color:white">registro creado exitosamente</h5>
            <a href="#" class="close">&times;</a>
            </div>';            
        }else{
            throw new PDOException;
        }
       
    }
    catch (PDOException $pe){
                    $conex->rollBack();
   $datos['error']= '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
        
    }     
     echo json_encode($datos);

    function agrega_gastos($enc_id){
        $gastos=[];
     
        $sql_gastos="insert into compras_activo_otros_gastos values ";
        foreach ($_GET as $key => $value) {
            if(startsWith($key, 'gastos')){
                $gastos[trim($key,'gastos_')]=$value;                               
                //  $sql_gastos.="(default,'$key',$value,$enc_id),";            
            }            
        }
        if(count($gastos)!==0){
            $tmp=1;
            $c='concepto_';
            $v='valor_';
                        for($i=0;$i<count($gastos)/2;$i++){                                                        
                            $sql_gastos.="(default,'".$gastos[$c.$tmp]."',".$gastos[$v.$tmp].",$enc_id),";                            
                            $tmp++;
                        }
                        $sql_gastos=trim($sql_gastos,',');

                        if(!$GLOBALS[conex]->prepare($sql_gastos)->execute()){
                            throw new PDOException;
                        }
        
            }
    }
    
    function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}
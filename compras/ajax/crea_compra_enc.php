<?php

include '../../conexion.php';
 //include '../../php clases/kardex.php';

    try{
        //unset($_GET[linea_rowOrder]);#viene por defecto del plugin appendgrid,en esta caso no me sirve
        $datos=[];
        $doc_no=$_GET[fac_no];
        $fecha=$_GET[fecha];
        $proveedor=$_GET[proveedor];
        $tipo_doc=$_GET[tipo_doc];
        $sql="insert into compras_enc (id,fecha,doc_no,tipo_doc,proveedor,fecha_ingreso_fact,aplicada) values(default,'$fecha','$doc_no','$tipo_doc','$proveedor',now(),'0') returning id";
        //$conex->beginTransaction();
        $insert=$conex->prepare($sql);
        //$sql_lns="insert into compras_lns values ";
        if($insert->execute())   {
            $datos['id']=$insert->fetchColumn();
            $datos['ok']= '<div data-alert class="alert-box success round">
            <h5 style="color:white">registro creado exitosamente</h5>
            <a href="#" class="close">&times;</a>
            </div>';            
//            $enc_id = $insert->fetchColumn();
//            foreach ($_GET as $key => $value) {
//                $tmp=explode('_',$key)[0];
//                    if( $tmp === 'linea'){
//                        $tmp2=explode('_',$key)[1];
//                        if($tmp2==='bodega'){
//                            $sql_lns.="(default,'".$_GET[$key]."',";
//                            continue;
//                        }
//                        if($tmp2==='referencia'){
//                                                        $sql_lns.="'".explode('-',$_GET[$key])[0]."','".explode('-',$_GET[$key])[1]."',";
//                                                        continue;
//                        }
//                        if($tmp2==='subtotal'){
//                            $sql_lns.= "'$_GET[$key]','$enc_id'),";
//                            continue;
//                        }
//                        
//                       $sql_lns.="'$_GET[$key]',";
//                    }
//            }
//            $sql_lns=trim($sql_lns,',');
//            $insert_lns=$conex->prepare($sql_lns);
//            if($insert_lns->execute()){
                  #kardex 
                #existencias
                #prods
                                                     // $kardex=new kardex();
                                                      //$kardex->actualiza_inventario('+',$enc_id);
                                                      //$kardex->actualiza_existencias($cod_bodega, $enc_id);
                                                      //$kardex->actualiza_kardex($cod_bodega,$tipo_doc,$doc_no, $enc_id);
                                                      
//                                                      $conex->commit();
//                echo '<div data-alert class="alert-box success round">
//            <h5 style="color:white">registro creado exitosamente</h5>
//            <a href="#" class="close">&times;</a>
//            </div>';
//            }else{
//                  throw new PDOException;
//            }            
        }else{
               $datos['error']= '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
        }
        echo json_encode($datos);
    }
    catch (PDOException $pe){
                    //  $conex->rollBack();
//     echo '<div data-alert class="alert-box alert round">
//       <h5 style="color:white">Error al insertar el registro</h5>
//       <a href="#" class="close">&times;</a>
//       </div>';
        
    }     

    
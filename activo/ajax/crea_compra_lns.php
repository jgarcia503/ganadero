<?php
session_start();
include '../../conexion.php';
 include '../../php clases/kardex.php';

    try{

        
        $conex->beginTransaction();

        $sql_lns="insert into compras_activo_lns values ";
        $sql_update="update compras_activo_enc set total=";
        $enc_id=$_GET[enc_id];
        $total=0;
//            $enc_id = $insert->fetchColumn();
            foreach ($_SESSION[lineas_fact] as $key => $value) {
                //$tmp=explode('_',$key)[0];
                    //if( $tmp === 'linea'){
                        //$tmp2=explode('_',$key)[1];
                        //if($tmp2==='bodega'){
                            $sql_lns.="(default,'".$value[bodega]."',";
                            //continue;
                        //}
                        //if($tmp2==='referencia'){
                                                        $sql_lns.="'".explode('-',$key)[0]."','".explode('-',$key)[1]."',";
                                 //                       continue;
                        //}
                        //if($tmp2==='subtotal'){
                            $sql_lns.= "'$value[cant]','$value[unidad]','$value[precio]','$value[subtotal]','$enc_id'),";
                            //continue;
                        //}
                        $total+=$value[subtotal];
                       //$sql_lns.="'$_GET[$key]',";
                    //}
            }
            $sql_update.=$total." where id=$enc_id";
            $sql_lns=trim($sql_lns,',');
            $insert_lns=$conex->prepare($sql_lns);
            if($insert_lns->execute()){
                if($conex->prepare($sql_update)->execute()){
                  #kardex 
                #existencias
                #prods
                                                     // $kardex=new kardex();
                                                      //$kardex->actualiza_inventario('+',$enc_id);
                                                      //$kardex->actualiza_existencias($cod_bodega, $enc_id);
                                                      //$kardex->actualiza_kardex($cod_bodega,$tipo_doc,$doc_no, $enc_id);
                                                      
                                                      $conex->commit();
                                                        echo '<div data-alert class="alert-box success round">
                                                    <h5 style="color:white">registro creado exitosamente</h5>
                                                    <a href="#" class="close">&times;</a>
                                                    </div>';
                                                        unset($_SESSION[lineas_fact]);
                    }
            }else{
                  throw new PDOException;
            }            
 
        //echo json_encode($datos);
    }
    catch (PDOException $pe){
                    unset($_SESSION[lineas_fact]);
                     $conex->rollBack();
     echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
        
    }         


<?php
session_start();
include '../../conexion.php';
 include '../../php clases/kardex.php';

    try{

        $enc_id=$_GET[enc_id];
        $sql_subtotal="select sum(subtotal::numeric(100,2)) from compras_lns where enc_id=$enc_id";
        $total=$conex->query($sql_subtotal)->fetchColumn();

        $sql_update="update compras_enc set total='$total',aplicada='true' where id=$enc_id";
                 if($conex->prepare($sql_update)->execute()){
                  #kardex 
                #existencias
                #prods
                                                     // $kardex=new kardex();
                                                      //$kardex->actualiza_inventario('+',$enc_id);
                                                      //$kardex->actualiza_existencias($cod_bodega, $enc_id);
                                                      //$kardex->actualiza_kardex($cod_bodega,$tipo_doc,$doc_no, $enc_id);
                                                      
                                                      //$conex->commit();
                                                        echo '<div data-alert class="alert-box success round">
                                                    <h5 style="color:white">registro creado exitosamente</h5>
                                                    <a href="#" class="close">&times;</a>
                                                    </div>';
                                                        unset($_SESSION[lineas_fact]);
                    }
        

    }
    catch (PDOException $pe){
                    unset($_SESSION[lineas_fact]);
                     //$conex->rollBack();
     echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
        
    }         

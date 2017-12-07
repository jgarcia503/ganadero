<?php
include '../../conexion.php';
class kardex_activo{
        
    private $conex;
    private $res_lns;
    public function __construct() {
        $this->conex=$GLOBALS[conex];
        
    }
    
    public function registrar_activo($enc_id){
        $lineas_compras_sql="select * from compras_activo_lns where enc_id='$enc_id'";           
        $this->res_lns= $this->conex->query($lineas_compras_sql)->fetchAll();
        $this->actualiza_precio_promedio($this->res_lns);
        $this->actualiza_existencias($this->res_lns);
        $this->actualiza_kardex($enc_id, $this->res_lns);
    }
    
    private function actualiza_precio_promedio($lns){
        
        foreach ($lns as $key => $value) {
                                 $sql="select precio_promedio::numeric(1000,2)*cantidad_total::numeric(1000,2) from activo where referencia='$value[referencia]'"  ;
                              
                                 $subtotal_prod=  floatval($this->conex->query($sql)->fetchColumn());
                                 
                                 $subtotal_prod+=floatval($value[subtotal]);
                                 
                                 $sql_cant="select cantidad_total::numeric(1000,2) from activo where referencia='$value[referencia]'";
                                 
                                 $cant_total=floatval($this->conex->query($sql_cant)->fetchColumn())+$value[cantidad];
                                 
                                    $costo_unitario=$subtotal_prod/$cant_total;

                              
                              $sql2="update activo set precio_promedio='$costo_unitario', cantidad_total='$cant_total' where referencia='$value[referencia]'";
                             if(!$this->conex->prepare($sql2)->execute()){
                                  throw  new PDOException('error al actualizar el inventario');
                              }
                                                          
                              ##formatear cantidad a dos decimales
                              $sql3="update activo set precio_promedio=precio_promedio::numeric(1000,2) where referencia='$value[referencia]'";
                              $this->conex->prepare($sql3)->execute();
        }                             
                
    }
    
    private function actualiza_existencias($lns){          
                       
                    foreach ($lns as $key => $value) {
                               $sql_insert = "insert into existencias_activo values";
            $sql_update = "update existencias_activo set existencia=existencia::numeric(1000,2)+";
            #verificar si existe en la tabla
            $existe = "select *  from existencias_activo where codigo_activo='$value[referencia]' and codigo_bodega='$value[bodega]'";
            $res = $this->conex->query($existe);


            if ($res->rowCount() !== 0) {
                $sql_update.="$value[cantidad] where codigo_activo='$value[referencia]' and codigo_bodega='$value[bodega]'";
                if (!$this->conex->prepare($sql_update)->execute()) {

                    throw new PDOException;
                }
            } else {

                $sql_insert.=" (default,'$value[referencia]','$value[bodega]','$value[cantidad]')";
                if (!$this->conex->prepare($sql_insert)->execute()) {
                    throw new PDOException;
                }
            }
            $sql_update = '';
            $sql_insert = '';
        }#cierro while
    }
    
    private function actualiza_kardex($enc_id,$lns){
        $sql_enc = "select tipo_doc,doc_no from compras_activo_enc where id=$enc_id ";
        $res_enc = $this->conex->query($sql_enc)->fetchAll()[0];

        $sql_insert = "insert into kardex_activo values ";

        foreach ($lns as $key => $value) {

            $subtotal = floatval($value[subtotal]) / $value[cantidad];
            $sql_insert.="(default,'$value[bodega]','$value[referencia]',now(),'$res_enc[tipo_doc]','$res_enc[doc_no]','$subtotal','$value[cantidad]')" . ",";
        }
        $sql_insert = trim($sql_insert, ',');
        if (!$this->conex->prepare($sql_insert)->execute()) {
            throw new PDOException('error al actualizar existencia');
        }
    }
    
}
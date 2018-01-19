<?php
/*
se incluye asi porque este archivo lo incluyo en crea_compra.php y este esta anidado en una carpeta
 * por lo tanto este archivo adquiero el mismo nivel de anidacion que el anterior
 *  */
include '../../php funciones/funciones.php';
class kardex{
    
    private $res_lns;
   private $conex;
    public function __construct() {
        $this->conex=$GLOBALS[conex];
        
    }
/* metodo usado cuando se hace una compra */
    /**
     * 
     * @param type $operacion
     * @param type $enc_id
     * @throws PDOException
     */
    public function actualiza_inventario($operacion,$enc_id=null) {
        
        
        if($operacion==='+'){
            $sql="select * from compras_lns where enc_id='$enc_id'";           
            $this->res_lns= $GLOBALS[conex]->query($sql);
                    while($fila=  $this->res_lns->fetch()){
                            #convertir a unidades standard   
                           
                                $cant_convertida=convertir($fila[unidad],$fila[cantidad]);
                                $costo_unit_conv=  floatval($fila[subtotal])/$cant_convertida;                                                                
                                
                                 $sql="select precio_promedio::numeric(1000,2)*cantidad_total::numeric(1000,2) from productos where referencia='$fila[referencia]'"  ;
                              
                                 $subtotal_prod=  floatval($GLOBALS[conex]->query($sql)->fetchColumn());
                                 
                                 $subtotal_prod+=floatval($fila[subtotal]);
                                 
                                 $sql_cant="select cantidad_total::numeric(1000,2) from productos where referencia='$fila[referencia]'";
                                 
                                 $cant_total=floatval($GLOBALS[conex]->query($sql_cant)->fetchColumn())+$cant_convertida;
                                 
                                    $costo_unitario=$subtotal_prod/$cant_total;

                              
                              $sql2="update productos set precio_promedio='$costo_unitario', cantidad_total='$cant_total' where referencia='$fila[referencia]'";
                             if(!$GLOBALS[conex]->prepare($sql2)->execute()){
                                  throw  new PDOException('error al actualizar el inventario');
                              }
                            
                              
                              ##formatear cantidad a dos decimales
                              $sql3="update productos set precio_promedio=precio_promedio::numeric(1000,2) where referencia='$fila[referencia]'";
                              $GLOBALS[conex]->prepare($sql3)->execute();
                             
                    
                        }                     
                }
        }
        /**
         * 
         * @param type $cod_bodega
         * @param type $enc_id
         */
        public function actualiza_existencias($enc_id){            
             $sql="select * from compras_lns where enc_id='$enc_id'";
             
              $this->res_lns= $GLOBALS[conex]->query($sql);
              while($fila=  $this->res_lns->fetch()){
                               $sql_insert="insert into existencias values";
                               $sql_update="update existencias set existencia=existencia::numeric(1000,2)+";
                               #verificar si existe en la tabla
                            $existe="select *  from existencias where codigo_producto='$fila[referencia]' and codigo_bodega='$fila[bodega]'";
                            $res=$this->conex->query($existe);
             
             $cant_convertida=convertir($fila[unidad],$fila[cantidad]);                                    
             if($res->rowCount()!==0){
                 $sql_update.="$cant_convertida where codigo_producto='$fila[referencia]' and codigo_bodega='$fila[bodega]'";
                 if(!$this->conex->prepare($sql_update)->execute()){
                     
                                          throw new PDOException;
                 }
             }else{
                     
                     $sql_insert.=" (default,'$fila[referencia]','$fila[bodega]','$cant_convertida')";
                     if(!$this->conex->prepare($sql_insert)->execute()){                         
                                throw new PDOException;
                     }
             }
                            $sql_update='';
                            $sql_insert='';
              }#cierro while
          
              
        }
        /**
         * 
         * @param type $cod_bodega
         * @param type $tipo_doc
         * @param type $no_doc
         * @param type $enc_id
         * @throws PDOException
         */
        public function actualiza_kardex($enc_id){
            $sql_enc="select tipo_doc,doc_no from compras_enc where id=$enc_id ";
            $res_enc=   $GLOBALS[conex]->query($sql_enc)->fetchAll()[0];
                  $sql="select * from compras_lns where enc_id='$enc_id'";
                   $sql_insert="insert into kardex values ";
                    $this->res_lns= $GLOBALS[conex]->query($sql);
                         while($fila=  $this->res_lns->fetch()){
                            $cant_convertida=convertir($fila[unidad],$fila[cantidad]);                  
                            $subtotal=  floatval($fila[subtotal])/$cant_convertida;
                            $sql_insert.="(default,'$fila[bodega]','$fila[referencia]',now(),'$res_enc[tipo_doc]','$res_enc[doc_no]','$subtotal','$cant_convertida')".",";
                  
              }
                    $sql_insert=trim($sql_insert, ',');
                    if(!$this->conex->prepare($sql_insert)->execute()){
                                throw  new PDOException('error al actualizar existencia');
              }
        }
        
        
        /* metodo usado cuando se crean actividades en los proyectos siembra */
        # $array es un aparametro con referencia y cantidad
        /**
         * 
         * @param type $array
         * @param type $bodega_seleccionada
         * @throws PDOException
         */
        public function decrease_inventario($array,$bodega_seleccionada=NULL) {
            foreach ($array as $key=>$value){
                                   
                    $consultas=[];
                    $consultas[]="update productos set cantidad_total=(cantidad_total::numeric(1000,2)-$value) where referencia='$key'";
                    $consultas[]="update existencias set existencia=(existencia::numeric(1000,2)-$value) where "
                                                                . "codigo_producto='$key' and codigo_bodega='$bodega_seleccionada'";
                    try{
                                                $this->conex->beginTransaction();
                                                foreach ($consultas as $value) {
                                                    
                                                   if(!$this->conex->prepare($value)->execute())   {
                                                       throw  new PDOException();
                                                   }
                                                    
                                                }
                                                
                                                 
                                                $this->conex->commit();
                    }
                    catch (PDOException $pe){
                        $this->conex->rollBack();
                                   echo '<div data-alert class="alert-box alert round">
                 <h5 style="color:white">Error al insertar el registro</h5>
                 <a href="#" class="close">&times;</a>
                 </div>';
                                   exit($pe->getMessage());
                    }
                                            
            }#foreach    
                        
            #######para insertar en kardex una salida de producto de las actividades 
            $proy_id=$GLOBALS[info][proy_id];
            $acts=$GLOBALS[actividades_insertadas];
            //$sql_costo_promedio="select precio_promedio,referencia from productos where nombre in (";
            foreach ($acts as $key => $value) {
                $sql_costo_promedio="select precio_promedio,referencia from productos where nombre in (";
                $salida=  convertir($value[unidad], $value[cantidad_dias]);
                $sql_costo_promedio.="'$value[producto]')";
                $info_prod=$this->conex->query($sql_costo_promedio)->fetch();
                $sql_kardex="insert into kardex (id,codigo_bodega,codigo_producto,fecha,tipo_doc,no_doc,costo,salida) "
                                                . "values(default,'$bodega_seleccionada','$info_prod[referencia]',now(),'requisicion-actividades','$proy_id-$value[id]','$info_prod[precio_promedio]','$salida')";
            
                                        $this->conex->prepare($sql_kardex)->execute();
                                        $sql_costo_promedio='';
            }
                
        }
        
        /* metodo para verificar existencia antes de aplicar un tratamiento */
        public function check_stock($referencia){
            $sql="select cantidad_total,precio_promedio from productos where referencia='$referencia'";            
            $res=$this->conex->query($sql)->fetch();
            $disponible=$res[cantidad_total];
            $precio_prom=$res[precio_promedio];
            $prod[$referencia]=$disponible.'/'.$precio_prom;
            return $prod;
        }
        
           public function decrease_inventario_farmacia($array,$bodega_seleccionada=NULL) {               
           $sql="select precio_promedio from productos where referencia ='$GLOBALS[nombre]'";
            foreach ($array as $key=>$value){
                                   $costo_promedio=  $this->conex->query($sql)->fetchColumn();
                    $consultas=[];
                    $consultas[]="update productos set cantidad_total=(cantidad_total::numeric(1000,2)-$value) where referencia='$key'";
                    $consultas[]="update existencias set existencia=(existencia::numeric(1000,2)-$value) where "
                                                                . "codigo_producto='$key' and codigo_bodega='$bodega_seleccionada'";
                    $consultas[]="insert into kardex values (default,'$bodega_seleccionada','$key',now(),'requisicion-tratamiento','$GLOBALS[ultimo_id]','$costo_promedio','','$value')";
                    try{
                                               
                                                foreach ($consultas as $value) {
                                                    
                                                   if(!$this->conex->prepare($value)->execute())   {
                                                       throw  new PDOException();
                                                   }
                                                    
                                                   
                                                }
                                         
                    }
                    catch (PDOException $pe){
                        $this->conex->rollBack();
                                   echo '<div data-alert class="alert-box alert round">
                 <h5 style="color:white">Error al insertar el registro</h5>
                 <a href="#" class="close">&times;</a>
                 </div>';
                                   exit($pe->getMessage());
                    }
                                            
            }#foreach    
                                   
                
        }

}



<?php
include '../../conexion.php';
include '../../php clases/kardex.php';
session_start();
if(isset($_GET[id])){
    

$id=$_GET[id];
$_SESSION[enc_id_tratamiento]=$id;
$sql="select * from tratamientos_lns where id_enc='$id'";
$res=$conex->query($sql);

$fila=[];
while($lineas=$res->fetch(PDO::FETCH_ASSOC)){
    #las llaves del array deben llamarse igual que el nombre de las columnas especificadas en el plugin appendgrid
$fila['medicina']=$lineas[nombre];
$fila['cantidad']=$lineas[cantidad];
$fila['medida']=$lineas[medida];
$fila['veces x dia']=$lineas[frecuencia_x_dia];
$fila['id enc']=$id;
$jsonlineas[]=  json_encode($fila);
}

?>

 <table id="tblAppendGrid">
 </table>  

<script>
    $('#tblAppendGrid').appendGrid({
        columns: [
            { name: 'medicina', display: 'medicina', ctrlAttr:{readonly:true}},
            { name: 'cantidad', display: 'cantidad' ,ctrlAttr:{readonly:true}},            
            { name: 'medida', display: 'medida' ,ctrlAttr:{readonly:true}},
            { name: 'veces x dia', display: 'veces x dia' ,ctrlAttr:{readonly:true}},
            { name: 'id enc', display: 'id enc' ,type:'hidden'}            
        ],
                hideButtons:{
                    append:true,
                    removeLast:true,
                    insert:true,
                    remove:true,
                    moveUp:true,
                    moveDown:true
                    },
                   customRowButtons: [
            {
                uiButton: {  label: 'aplicar' },
                click: function (evtObj, uniqueIndex, rowData){
                    $.ajax({
                        url:'<?php echo $_SERVER[PHP_SELF] ?>',
                        data:rowData,
                        success:function(data){
                            alert(data);
                                                    }                        
                                        });
                                        
                                }
                                
            }]   ,
                initData: [<?php foreach ($jsonlineas as $val){echo $val.',';} ?>]//php one liners
    });
    
        </script>
        
  <?php   }else{
     try{
      $kardex=new kardex();
      $referencia=  explode('-', $_GET[medicina])[0];
      $cantidad=$_GET[cantidad];
      $veces_x_dia=$_GET[veces_x_dia];
      $res=$kardex->check_stock($referencia);
      $disponibilidad=  explode('/', $res[$referencia])[0];
      $precio_prom=  explode('/', $res[$referencia])[1];
      #verificar si ha alcanzado el limite de aplicaciones por dia
            $sql_aplic_x_dia="select count(fecha_aplicacion) from aplicaciones_medicas where fecha_aplicacion::date=(select current_date) "
                    . "and medicamento='$referencia' and enc_id='$_GET[id_enc]'";
            $cont_apli=  intval($conex->query($sql_aplic_x_dia)->fetchColumn());
            if($cont_apli<$veces_x_dia){
                                                if($disponibilidad>=$cantidad){
                                                    $conex->beginTransaction();
                                                      $id_enc=$_SESSION[enc_id_tratamiento];            
                                                      $sql="insert into aplicaciones_medicas values(default,current_date,'$referencia','$cantidad','$precio_prom','$id_enc')";
                                                      $insert=$conex->prepare($sql);
                                                    if($insert->execute()){
                                                        $array[$referencia]=$cantidad;
                                                          $kardex->decrease_inventario($array);
                                                               $conex->commit();

                                                          echo 'exito';
                                                    }else{
                                                          throw new PDOException();
                                                    }


                                                }else{
                                                    echo "cantidad insuficiente hay $disponibilidad";
                                                }
                    }  
     else{
         echo "se alcanzado limite de aplicaciones por dia";
         return;
     }
  } 
   catch (PDOException $pe){
       $conex->rollBack();
       echo 'error';
    }
  }//cierro else

<?php   
include '../plantilla.php'; 
include '../php funciones/funciones.php';

if(!isset($_GET[proy_id])){
echo '<script>window.location="http://localhost:8089/ganadero/cosechas/cosechas.php"</script>';
}

$costo_total=  calcular_costo_proyecto($_GET[proy_id]);
$proy_id=$_GET[proy_id];

#calcular costo de uso de el/los tablones
$sql_costo_uso_tablones="select sum(a.dato)
from (select ((regexp_split_to_table(costo_uso_x_dia,',')::numeric(1000,10)* (select fecha_fin::date-fecha_inicio::date from proyectos_enc where id_proyecto =$proy_id))) as dato
from proyecto_tablones where id_proyecto =$proy_id) as a";
$res=$conex->query($sql_costo_uso_tablones)->fetchColumn();
$costo_total+=$res;
if($_SERVER[REQUEST_METHOD]=='POST'){
try{
    $insert="insert into opcion_7 values(default,'$_POST[costo_proyecto]','$_POST[costo_cosecha_mano_obra]'"
            . ",'$_POST[costo_picar_mano_obra]','$_POST[costo_transporte]'"
            . ",'$_POST[notas]',$_POST[proy_id])";
    $update="update proyectos_enc set opcion='7' where id_proyecto=$_POST[proy_id]";

$conex->beginTransaction();
$sql=$conex->prepare($insert);
$sql2=$conex->prepare($update);
    if($sql->execute() and $sql2->execute()){
        $conex->commit();
                              $mensaje='<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro creado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
    }else{
              throw new PDOException();
    }
}
 catch (PDOException $pe){
              $conex->rollBack();
      $mensaje= '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
 }
}
?>

<div class="small-12 columns">
       <h2>corte y reparto en verde</h2>
       <a href="cosechas.php" class="regresar">regresar</a>
         <?php echo $mensaje ?>
    <form data-abide method="post">
        <div class="row">
            <div class="small-3 columns">
                <label>costo total de la siembra
                    <input type="text" readonly="" value="<?php echo number_format($costo_total,2) ?>" name="costo_proyecto">
                </label>
                <input type="hidden" name="proy_id" value="<?php echo $_GET[proy_id] ?>">
            </div>
            <div class="small-3 columns end">
                        <label>costo mano de obra cosecha<input type="number" name="costo_cosecha_mano_obra" required=""></label>
                        <small class="error">obligatorio</small>
                    </div>
              <div class="small-6 columns">
                <label>notas<textarea name="notas"></textarea></label>
            </div>  
        </div>
       
               
           
                    
        
        <div class="row">
            <div class="small-3 columns">
                <label>costo de picado<input type="number" name="costo_picar_mano_obra" required=""></label>
                <small class="error">obligatorio</small>
            </div>
            <div class="small-3 columns end">
                <label>costo de transporte<input type="number" name="costo_transporte" required=""></label>
                <small class="error">obligatorio</small>
            </div>
        </div>
        <div class="row">
            
            <div class="small-6 columns">
                <label>toneladas estimadas<input type="number" name="ton_estimadas" required=""></label>
                <small class="error">obligatorio</small>
            </div>
        </div>

        <div class="row">
            <div class="small-6 columns">
                <button type="submit">crear registro</button>
            </div>
            <div class="small-6 columns"></div>
        </div>     
   
    </form>    
</div>
</div>

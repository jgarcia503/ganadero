<?php
include '../plantilla.php'; 
include '../php funciones/funciones.php';
if(!isset($_GET[proy_id])){
echo '<script>window.location="http://localhost:8089/ganadero/cosechas/cosechas.php"</script>';
}

if($_SERVER[REQUEST_METHOD]=='POST'){
    
try{

    $insert="insert into opcion_4 values(default,'$_POST[costo_proyecto]','$_POST[venta_siembra]',$_POST[proy_id])";
    $update="update proyectos_enc set opcion='4' where id_proyecto=$_POST[proy_id]";

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

$costo_total=  calcular_costo_proyecto($_GET[proy_id]);
?>

<div class="small-10 columns">
    <h2>venta de elote y zacate antes de tiempo</h2>
    <a href="javascript:history.back(1)" class="regresar">regresar</a>
    <?php echo $mensaje ?>
    <form data-abide method="post">
        <div class="row">
            <div class="small-4 columns">
                <label>costo total de la siembra
                    <input type="text" readonly="" value="<?php echo number_format($costo_total,2) ?>" name="costo_proyecto">
                </label>
                <input type="hidden" name="proy_id" value="<?php echo $_GET[proy_id] ?>">
            </div>
              <div class="small-4 columns">
                  <label>venta de la siembra
                      <input type="text"  value="" name="venta_siembra" class="cantidad">
                </label>
               
            </div>
             <div class="small-4 columns">
                  <label>perdida
                      <input type="text"  value="" name="perdida" readonly="">
                </label>
                
            </div>
        </div>
        
    

            <input type="submit" value="crear registro" class="primary button">
    
    </form>
</div>
</div>

<script>
    $("[name=venta_siembra]").on('change',function(){
        var perdida=parseFloat($(this).val())-parseFloat($("[name=costo_proyecto]").val());
        $("[name=perdida]").val(perdida);
    });
                 $(".cantidad").mask('000,000,000,000,000.00', {reverse: true});
</script>
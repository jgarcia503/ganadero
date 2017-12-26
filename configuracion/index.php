<?php
include '../plantilla.php';
if($_POST){
    $precio=$_POST[precio_leche];
    $id=$_POST[id];
    $sql="update configuraciones set precio_leche='$precio' where id=$id";
    if($conex->prepare($sql)->execute()){
            $mensaje=  '<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro actualizado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
    }
    else{
            $mensaje=  '<div data-alert class="alert-box success round">
                    <h5 style="color:white">registro actualizado exitosamente</h5>
                    <a href="#" class="close">&times;</a>
                    </div>';
    }
}
$precio_leche="select * from configuraciones";
$res=$conex->query($precio_leche)->fetch();

?>

<div class="small-3 columns">
<?php echo $mensaje?>
    <form action="" method="post">
        <label>precio botella de leche
            <input type="text" name="precio_leche" value="<?php echo $res[precio_leche]?>">
        </label>
        <input type="hidden" value="<?php echo $res[id]?>" name="id">
        <input type="submit" class="button primary" value="guardar">
    </form>

    </div>
    </div>
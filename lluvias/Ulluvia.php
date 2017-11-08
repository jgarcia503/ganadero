<?php   include '../plantilla.php'; 
if($_POST){

 $insert =$conex->prepare("update lluvias set "
         . "fecha='$_POST[fecha]'"
         . ",mm='$_POST[mm]'"
         . ",notas=trim('$_POST[notas]') where id=$_POST[lluvia_id]");
     if($insert->execute()){
        echo '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }else{
      echo '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
}
 
}
$id=base64_decode($_SERVER[QUERY_STRING]);
$lluvia=$conex->query("select * from lluvias where id=$id")->fetch();

?>

<div class="small-10 columns">
<form action="" method="post">
    <label for="">fecha</label>
    <input type="text" name="fecha" value="<?php echo $lluvia[fecha]?>">
    <label for="">MM</label>
    <input type="text" name="mm"  value="<?php echo $lluvia[mm]?>">
    <label for="">notas</label>
    <textarea name="" id="" cols="30" rows="10" name='notas'>
        <?php echo $lluvia[notas]?>
    </textarea>
    <input type="hidden" value="<?php $id ?>" name="lluvia_id">
    <input type="submit" class="button primary">
</form>
</div>
</div>

<script>
            $("[name=fecha]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});     
    </script>
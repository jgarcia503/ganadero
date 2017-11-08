<?php   include '../plantilla.php'; ?>
    
    <div class="small-10 columns">
    <?php
if($_POST){

 $insert =$conex->prepare("insert into lluvias"
         . " values(default,'$_POST[fecha]','$_POST[mm]',trim('$_POST[notas]'))");
     if($insert->execute()){
        $mensaje= '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }else{
      $mensaje= '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
}
 
}
?>

<script>
            $(document).on('ready',function(){
            $("[name=fecha]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy"});
     
          });
    </script>

<form action="" method="post" data-abide>
    <?php echo $mensaje?>
       <h2>crear lluvia</h2>
    <div class="row">
        <div class="small-12 columns">
             <label for="">fecha</label>
             <input type="text" name="fecha" required="">
                  <small class="error">elija fecha</small>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
              <label for="">MM</label>
              <input type="text" name="mm" required="" pattern="number">
                   <small class="error">solo numeros</small>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
             <label for="">notas</label>
    <textarea name="" id="" cols="30" rows="10" name='notas'></textarea>
    <input type="submit" class="button primary">
        </div>
    </div>
   
  
   
</form>
</div>
</div>
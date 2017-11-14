<?php   include '../plantilla.php'; 
if($_POST){
  try{
      $sql="insert into grupos values(default,'$_POST[nombre]','$_POST[clasificacion]',";
      $sql.=$_POST['clasificacion']=='produccion'?" '$_POST[prod]','n/a' ":" 'n/a',$_POST[dias_nac] ";
      $sql.=")";
      
      $insert=$conex->prepare($sql);
    if($insert->execute()){
        $mensaje= '<div data-alert class="alert-box success round">
 <h5 style="color:white">grupo creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }else{
      $mensaje= '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
}
  }
 catch (Exception $ex){
     echo $ex->getMessage();
  
 }
}

?>

<div class="small-10 columns">
       <h2>crear grupo</h2>
          <?php echo $mensaje?>
       <a href="grupos.php" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    <div class="row">
        <div class="small-4 columns">
             <label for="">nombre</label>   
             <input type="text" name="nombre" required="" pattern="letters_and_spaces">
            <small class="error">requerido</small>
           
        </div>
              <div class="small-4 columns">
             <label for="">clasificacion</label>   
             <select name="clasificacion" required="">
                 
                 <option value="">seleccion</option>
                 <option value="produccion">produccion</option>
                 <option value="desarrollo">desarrollo</option>
             </select>
           <small class="error">requerido</small>
        </div>
        <div class="small-4 columns">
            <label for="" id="prod">produccion minima (botellas)
             <input type="text" name="prod" required="" pattern="number">
            <small class="error">requerido</small>
           </label>   
            <label for="" id="dias">dias nacida
             <input type="text" name="dias_nac" required="" pattern="number">
            <small class="error">requerido</small>
           </label>   
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
             <input type="submit" class="button primary" value="crear registro"> 
        
        </div>
    </div>
            
</form>
</div>
</div>


<script>
$("[name=clasificacion]").on('change',function(){
        switch($(this).val()){
            case 'produccion':
                $('#prod').show();
                $('#dias').hide();
                break;
            case 'desarrollo':
                $('#prod').hide();
                $('#dias').show();
                break;
        }
});

      $('#prod').hide();
      $('#dias').hide();
</script>
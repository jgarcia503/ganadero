<?php   include '../plantilla.php';
if($_POST){

     $insert=$conex->prepare("insert into tablones "
             . "values(default,'$_POST[nombre]','$_POST[potrero]','$_POST[extension]','libre',trim('$_POST[notas]'))");
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
$res=$conex->query("select * from potreros");

?>
<div class="small-10 columns">

<form action="" method="post" data-abide>
    <?php echo $mensaje ?>
    <h2>crear tablones</h2>
    <a href="tablones.php" class="regresar">regresar</a>
    <div class="row">
      
               <div class="small-6 columns">
            <label>potrero</label>
            <select name="potrero" required="">
                <option value="">seleccione</option>
                <?php
                                                                while($fila=$res->fetch()){
                                                                    echo "<option value='$fila[id]' data-extension='$fila[extension]'>$fila[nombre]</option>";
                                                                }
                                                ?>
            </select>
              <small class="error">seleccione</small>
        </div>
         <div class="small-6 columns">
             <label for="">nombre</label>
             <input type="text" name="nombre"  pattern="letters_and_spaces" readonly="">
             
        </div>
    </div>
    <div class="row">
        
  <div class="small-6 columns">
            
            <div class="row collapse">
                <label for="">extension</label>
                <div class="small-9 columns">            
                    <input type="text" name="extension" required="" pattern="number">
                    <small class="error">solo numeros</small>
                </div>

                <div class="small-3 columns">

                    <span class="postfix">metros<sup>2</sup></span>
                </div>
            </div>

        </div>
        <div class="small-6 columns">
            
        </div>
        
        
        
    </div>
    
    <div class="row">
        <div class="small-12 columns">
             <label for="">notas</label>
    <textarea name="notas" id="" cols="30" rows="10"></textarea>
    <input type="submit" class="button primary" value="crear registro">
        </div>
    </div>
    

</form>
</div>
</div>

<script>

    $('[name=potrero]').on('change',function(){
        var ext=parseFloat($(this).find('option:selected').data('extension'));
        $('[name=extension]').trigger('change');
        
        
        
        $('[name=nombre]').val($(this).find('option:selected').html()+'-'+1);
    });

$('[name=extension]').on('change',function(){

    var ext_tab=parseFloat($(this).val());
    var ext_terreno=parseFloat($('[name=potrero] option:selected').data('extension'));
    
    if(ext_tab>ext_terreno){
        alert('extension no valida');
        $(this).val('');
    }
    
});


</script>
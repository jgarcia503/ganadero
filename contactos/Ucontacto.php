<?php
include '../plantilla.php';

if($_POST){

$insert=$conex->prepare("update contactos set"
        . " identificacion='$_POST[identificacion]'"
        . ",tipo='$_POST[tipo]'"
        . ",usuario='$_POST[user]'"      
        . ",telefono='$_POST[tel]'"
        . ",direccion=trim('$_POST[direccion]')"
        . ",nombre='$_POST[nombre]'"
        . ",contrasena='$_POST[pass]'"
        . ",correo='$_POST[email]' where id=$_POST[contacto_id]");      
  
    if($insert->execute()){
        echo '<div data-alert class="alert-box success round">
 <h5 style="color:white">registro actualizado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }else{
      echo '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al actualizar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
}
   
}

$id=base64_decode($_SERVER[QUERY_STRING]);
$contactos=$conex->query("select * from contactos where id=$id")->fetch();

?>
<div class="small-12 columns"> 
<form action="" method="post">
    <h2>editar usuario</h2>
    <a href="contactos.php" class="regresar">regresar</a>
    <div class="row">
        <div class="small-6 columns">
            <label for="identificacion">identificacion
                <input type="text" name="identificacion" value="<?php echo $contactos[identificacion] ?>">
            </label>
        </div>
        <div class="small-6 columns"><label for="">nombre
            <input type="text" name="nombre" value="<?php echo $contactos[nombre] ?>"></label>
        </div>
    </div>

    <div class="row">
        <div class="small-6 columns">
            <label for="">telefono</label>
            <input type="text" name="tel" value="<?php echo $contactos[telefono] ?>">
        </div>
        <div class="small-6 columns">
            <label for="">correo</label>
            <input type="text" name="email" value="<?php echo $contactos[correo] ?>">
        </div>
    </div>
    <div class="row">
                <div class="small-6 columns"><label for="">tipo</label>
                    <select name="tipo" >
                        <option value="">seleccione</option>
                        <option value="admin" <?php echo $contactos[tipo]=='admin'?'selected':''?>>propietario</option>
                        <option value="empleado" <?php echo $contactos[tipo]=='empleado'?'selected':''?>>empleado</option>
                        <option value="cliente" <?php echo $contactos[tipo]=='cliente'?'selected':''?>>cliente</option>
                        <option value="proveedor" <?php echo $contactos[tipo]=='proveedor'?'selected':''?>>proveedor</option>
            </select>
                </div>
        <div class="small-6 columns">
            <?php         if($contactos['usuario']!=='' and $contactos[contrasena]!==''){           ?>
            <label>permisos  </label>
            <a href='#' id="permisos" data-id='<?php echo $contactos[id]?>'><i class="fa fa-key fa-2x" aria-hidden="true"></i></a>
              <?php } ?>
        </div>
    </div>
        <div class="row">
        <div class="small-6 columns">
            <label for="">usuario
                <input type="text" name="user" value="<?php echo $contactos[usuario] ?>">
            </label>
        </div>
        <div class="small-6 columns">
            <label for="">contraseña
                <input type="password" name="pass" value="<?php echo $contactos[contrasena] ?>">
            </label>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
            <label for="">direccion</label><textarea name="direccion" cols="30" rows="10"><?php echo $contactos[direccion] ?>
                
            </textarea>
            <input type="hidden" name="contacto_id" value="<?php echo $id ?>">
            <input type="submit" class="button primary" value="actualizar">
        </div>
    </div>
</form>

</div>
<div id="mimodal" class="reveal-modal"  data-reveal >
    <span></span>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
</div>
<script>
    $("[name=tipo]").on('change',function(){
        var valor=$(this).val();
        switch(valor){
            case 'cliente':
            case 'proveedor':                
                $('[name=user],[name=pass]').val('').parent('label').hide('slow');
                break; 
             case 'empleado':
            case 'admin':
                $('[name=user],[name=pass]').parent('label').show('slow');
                break; 
        }
    });

      $("#permisos").on('click',function(e) {
                            e.preventDefault();

                            $.ajax({
                                url: "ajax/permisos_usuarios.php?id=" + $(this).data('id'),
                                success: function (datos) {
                               
                                    $('#mimodal span').html(datos);
                                }
                            });

                            $('#mimodal').foundation('reveal', 'open');

                        });                        
</script>
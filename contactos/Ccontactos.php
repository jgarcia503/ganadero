<?php
include '../plantilla.php';

if($_POST){

$insert=$conex->prepare("insert into contactos"
        . " values(default,'$_POST[identificacion]','$_POST[tipo]','$_POST[user]','','$_POST[tel]'"
        . ",trim('$_POST[direccion]'),'$_POST[nombre]','$_POST[pass]','$_POST[email]')");      
  
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

<div class="small-12 columns">
    <h2>crear contacto</h2>
<form action="" method="post" data-abide>
    <?php echo $mensaje ?>
    <div class="row">
        <div class="small-6 columns">
            <label for="identificacion">identificacion
                <input type="text" name="identificacion">
            </label>
        </div>
        <div class="small-6 columns"><label for="">nombre
            <input type="text" name="nombre"></label>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns"><label for="">telefono</label><input type="text" name="tel"></div>
        <div class="small-6 columns"><label for="">correo</label><input type="text" name="email"></div>
    </div>
    <div class="row">
                <div class="small-6 columns"><label for="">tipo</label>
                    <select name="tipo" required="">
                        <option value="">seleccione</option>
                        <option value="admin">propietario</option>
                        <option value="empleado">empleado</option>
                        <option value="cliente">cliente</option>
                        <option value="proveedor">proveedor</option>
                    </select>
                    <small class="error">seleccione tipo</small>
                </div>
        <div class="small-6 columns"></div>
    </div>
    <div class="row">
        <div class="small-3 columns">
            <label for="">usuario
                <input type="text" name="user" required="">
            </label>
            <small class="error">escriba usuario</small>
        </div>
        <div class="small-3 columns">
            <label for="">contraseña
                <input type="password" name="pass" required="">
                <small class="error">escriba contraseña</small>
            </label>
        </div>
        <div class="small-6 columns">
            safas
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
            <label for="">direccion</label><textarea name="direccion" id="" cols="30" rows="10"></textarea>
            <input type="submit" class="button primary" value="guardar">
        </div>
    </div>
</form>

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
    })

</script>
<?php   include '../plantilla.php'; 

if($_POST){
$volumen=['litro'=>'l','mililitro'=>'ml','pinta'=>'pt' ,'galon'=>'gal'];
$peso=['kilogramo'=>'kg','gramo'=>'g','miligramo'=>'mg' ,'libra'=>'lb','onza'=>'oz'];
if($_POST['categoria']=='volumen'){$prefijo=$volumen[$_POST[unidad]];}else{$prefijo=$peso[$_POST[unidad]];}
 $insert =$conex->prepare("insert into unidades"
         . " values(default,'$_POST[categoria]','$_POST[unidad]','$prefijo',trim('$_POST[notas]'))");
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
<div class="small-10 columns">
    <?php echo $mensaje ?>
       <h2>crear unidad</h2>
       <a href="javascript:history.back(1)" class="regresar">regresar</a>
<form action="" method="post" data-abide>
    <div class="row">
        <div class="small-6 columns">
             <label for="">categoria</label>
             <select name="categoria" required="">
                 <option value="">seleccione</option>
                 <option value="volumen">volumen</option>
                 <option value="peso">peso</option>                 
             </select>
                <small class="error">elija categoria</small>
        </div>
             <div class="small-6 columns">
             <label for="">unidad</label>
             <select name="unidad" required="">
                      <option value="">seleccione</option>
                      
             </select>
                <small class="error">escriba unidad</small>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns">
             <label for="">notas</label>
    <textarea name="notas" id="" cols="30" rows="10" name="notas"></textarea>
    <input type="submit" class="button primary" value="crear registro">
        </div>
    </div>
   
   
</form>
</div>
</div>

<script>
$('[name=categoria]').on('change',function(){
    var opt_vol='<option value="">seleccione</option><option value="litro">litro</option><option value="mililitro">mililitro</option><option value="pinta">pinta</option><option value="galon">galon</option>';
    var opt_peso='<option value="">seleccione</option><option value="kilogramo">kilogramo</option><option value="gramo">gramo</option><option value="miligramo">miligramo</option><option value="onza">onza</option><option value="libra">libra</option>';
    var selec=  $('[name=unidad]');
    switch($(this).val()){
        case 'volumen':
            selec.html(opt_vol);
            break;
        case 'peso':
            selec.html(opt_peso);
            break;
    }
  
});
</script>
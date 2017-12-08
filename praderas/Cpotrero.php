<?php   include '../plantilla.php';
if($_POST){
#todas las unidades son metros cuadrados
$conversiones=['hectarea'=>10000,'manzana'=>7000];

$extension=floatval($conversiones[$_POST[unidad]])*floatval($_POST[extension]);

     $insert=$conex->prepare("insert into potreros "
             . "values(default,'$_POST[nombre]','$_POST[longitud]','$_POST[latitud]','$_POST[unidad]','$extension','$_POST[propiedad]','$_POST[valor_alquiler]',trim('$_POST[notas]'),'$_POST[valor_terreno]','$_POST[costo_uso]')");
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

    <form action="" method="post" data-abide>
    <?php echo $mensaje ?>
       <h2>crear potrero</h2>
       <a href="potreros.php" class="regresar">regresar</a>
    <div class="row">
         
        <div class="small-6 columns">
            <label for="">nombre</label>
             <input type="text" name="nombre" required="" pattern="letters_and_spaces">
             <small class="error">elija nombre</small>
        </div>
        <div class="small-3 columns">                            
            
                <label for="">extension</label>
                    
                    <input type="text" name="extension" required="" pattern="number">
                    <small class="error">solo numeros</small>
        </div>
        <div class="small-3 columns">      
            <label for="">unidad</label>
            <select name="unidad" required="">
                <option value="">seleccione</option>
                <option value="hectarea">hectareas</option>
                <option value="manzana">manzanas</option>
            </select>
            <small class="error">requerido</small>
        </div>
    </div>
    <div class="row">
        <div class="small-2 columns">
             <label for="">latitud</label>
             <input type="text" name="latitud" value="13.775763">
            </div>
             <div class="small-2 columns">
            <label for="">longitud</label>
            <input type="text" name="longitud" value="-89.394727">
        
        </div>
        <div class="small-2 columns">
        
            <a href='' id="mapa">
                <i class="fa fa-map-marker fa-3x" aria-hidden="true"></i>
            </a>            
            </div>
        <div class="small-6 columns">
            <label for="">terreno?</label>
            <select name="propiedad" id="propiedad" required="">
                <option value="">seleccione</option>
                <option value="propio">propio</option>
                <option value="alquilado">alquilado</option>
            </select>
                      <small class="error">seleccione</small>
        </div>
    </div>
       <div class="row">
           <div class="small-6 columns">
               <label for="">valor alquiler anual</label>
               <input type="text" name="valor_alquiler" pattern="number" required="">
                  <small class="error">solo numeros</small>
           </div>
             <div class="small-3 columns">
               <label for="">valor del terreno</label>
               <input type="text" name="valor_terreno" pattern="number" required="">
                  <small class="error">solo numeros</small>
           </div>
           <div class="small-3 columns end">
               <label for="">costo de uso por dia</label>
               <input type="text" name="costo_uso" pattern="number" required="">
                  <small class="error">solo numeros</small>
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

<div id="googleMap" style="width:100%;height:400px;"></div>
</div>


</div>

<script src="https://maps.googleapis.com/maps/api/js?callback=myMap"></script>
<script>
    
    $("#propiedad").on('change',function(){
        if($("#propiedad option:selected").val()==='propio'){
                $("[name='valor_alquiler']").parent('div').hide(1000)
                $("[name='valor_terreno']").parent('div').show(1000)
                $("[name='costo_uso']").parent('div').show(1000)
            }else{
                $("[name='valor_alquiler']").parent('div').show(1000);
                $("[name='valor_terreno']").parent('div').hide(1000);
                $("[name='costo_uso']").parent('div').hide(1000);
            }
    
    });
    
    //$("[name='valor_alquiler']").parent('div').hide();

$("#mapa").on('click',myMap);
////////////////////////////////////////////////////
function myMap(e) {
    e.preventDefault();
    var lat=$("[name=latitud]").val();
    var long=$("[name=longitud]").val();
    if(isNaN(lat) || isNaN(long) ||
            lat==='' || long===''){
        alert('ingrese coordenadas');
        return;
    }
var mapProp= {
    center:new google.maps.LatLng(lat ,long),
    zoom:10,
};
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

  marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat,long),
                map: map,
                title:"Ubicación Geografica."
            });
}

</script>
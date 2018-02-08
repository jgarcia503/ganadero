<script src="https://maps.googleapis.com/maps/api/js?callback=myMap"></script>
<?php
include '../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from potreros where id=$id";
$res=$conex->query($sql);
$terreno=$res->fetch(PDO::FETCH_ASSOC);
$plantilla="<div class='row'>"
        . "<div class='small-3 columns'>". ucwords('nombre')
        . "<input type='text' value='$terreno[nombre]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('longitud')
        . "<input type='text' value='$terreno[longitud]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('latitud')
        . "<input type='text' value='$terreno[latitud]' readonly>"
        . "</div>"
        . "<div class='small-3 columns'>". ucwords('extension')
        . "<input type='text' value='$terreno[extension]' readonly>"
        . "</div>"
                . "<div class='small-3 columns'>". ucwords('propiedad')
        . "<input type='text' value='$terreno[propiedad]' readonly>"
        . "</div>"
                . "<div class='small-3 columns'>". ucwords('valor alquiler')
        . "<input type='text' value='$terreno[valor_alquiler]' readonly>"
        . "</div>"
                . "<div class='small-3 columns'>". ucwords('unidad seleccionada')
        . "<input type='text' value='$terreno[unidad_seleccionada]' readonly>"
        . "</div>"
                . "<div class='small-3 columns'>". ucwords('valor terreno')
        . "<input type='text' value='$terreno[valor_terreno]' readonly>"
        . "</div>"
                . "<div class='small-3 columns'>". ucwords('costo de uso por dia')
        . "<input type='text' value='$terreno[costo_uso_x_dia]' readonly>"
        . "</div>"       
        . "</div>"
                ."<div class='row'>"
       . "<div class='small-12 columns'>".  ucwords('notas')
        . "<textarea readonly>$terreno[notas]</textarea>"
        . "</div>"        
        . "</div>";
       
echo $plantilla;
//$plantilla='<input type="text" value="{}" readonly>';
//$datos='';
//
//foreach ($terreno as $key=>$valor){
//    if($key!='id'){
//                 $key= ucwords(preg_replace('/_/', ' ', $key));
//            if($valor==null){
//                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
//            }else{
//                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
//            }
//    }
//}
//
//echo $datos;
?>
<div id="googleMap" style="width:100%;height:400px;"></div>


<script>
function myMap(){
        lat='<?php echo trim($terreno[latitud])?>'
    long='<?php echo trim($terreno[longitud])?>'
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


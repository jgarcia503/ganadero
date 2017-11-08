<script src="https://maps.googleapis.com/maps/api/js?callback=myMap"></script>
<?php
include '../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);
$sql="select * from potreros where id=$id";
$res=$conex->query($sql);
$terreno=$res->fetch(PDO::FETCH_ASSOC);

$plantilla='<input type="text" value="{}" readonly>';
$datos='';

foreach ($terreno as $key=>$valor){
    if($key!='id'){
                 $key= ucwords(preg_replace('/_/', ' ', $key));
            if($valor==null){
                $datos.="$key ".preg_replace('/{}/', '', $plantilla);
            }else{
                $datos.="$key ".preg_replace('/{}/', $valor, $plantilla);
            }
    }
}

echo $datos;
?>
<div id="googleMap" style="width:100%;height:400px;"></div>


<script>
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
</script>


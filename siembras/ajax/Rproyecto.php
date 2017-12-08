<?php

include '../../conexion.php';
$id=base64_decode($_SERVER[QUERY_STRING]);
$sql="select a.*,b.nombre nombre_cultivo from proyectos_enc a,tipo_vegetacion b where id_proyecto=$id and a.tipo_cultivo::integer=b.id";
$actividades_proyecto="select * from proyectos_lns where  enc_id='$id'";
#$nombre_tablon="select * from tablones where id=(select id_tablones::integer from proyecto_tablones where id_proyecto ='$id')";
$nombre_tablon="select btrim(array(select nombre from tablones where id::text in (select regexp_split_to_table(id_tablones,',') from proyecto_tablones where id_proyecto ='$id'))::text,'{}')";
$res_acts=$conex->query($actividades_proyecto);
$res=$conex->query($sql);
$res_nombre_tablon=$conex->query($nombre_tablon)->fetchColumn();
$animal=$res->fetch(PDO::FETCH_ASSOC);

$plantilla='<input type="text" value="{}" readonly>';
$datos='';
$plantilla_acts='
    <table width="100%">
      <caption>Actividades</caption>
  <thead>
    <tr>
      <th>actividad</th>      
      <th >tipo</th>
      <th >producto</th>
      <th >mano de obra</th>
      <th >cantidad/dias</th>
      <th >unidad</th>
      <th >subtotal</th>
      
    </tr>
  </thead>
  <tbody>
   {}
  </tbody>
</table>';

$campos_x_fila=0;

$no_permitidos=['id_proyecto','opcion','tipo_cultivo'];
foreach ($animal as $key=>$valor){

       
    if (!in_array($key, $no_permitidos)) {
        $key = ucwords(preg_replace('/_/', ' ', $key));
        if ($campos_x_fila == 0) {
            $datos.="<div class='row'>";
        }
        $datos.="<div class='small-3 columns'>";
        if ($valor == null) {
            $datos.="$key " . preg_replace('/{}/', '', $plantilla);
        } else {
            $datos.="$key " . preg_replace('/{}/', $valor, $plantilla);
        }
        $datos.="</div>";
        $campos_x_fila+=3;
        if ($campos_x_fila == 12) {
            $campos_x_fila = 0;
            $datos.="</div>";
        }
    }
}
           if($campos_x_fila<12){
               $campos_x_fila = 12 - $campos_x_fila;
                $datos.="<div class='small-$campos_x_fila columns'>";
                $datos.='nombre tablon' . preg_replace('/{}/', $res_nombre_tablon, $plantilla);
                $datos.="</div>";#cierro columna
                $datos.="</div>";#cierro fila
}


while($acts=$res_acts->fetch(PDO::FETCH_ASSOC)){
    $lineas.="<tr>
      <td>$acts[actividad]</td>      
      <td>$acts[tipo]</td>      
      <td>$acts[producto]</td>      
      <td>$acts[mano_obra]</td>      
      <td>$acts[cantidad_dias]</td>      
      <td>$acts[unidad]</td>      
      <td>$acts[subtotal]</td>  
      
    </tr>";
}

echo $datos;
echo '<div class="row" style="overflow-y: auto;height: 700px">';
echo "<div class='small-12 columns'>";
echo preg_replace('/{}/', $lineas, $plantilla_acts);
echo "</div>";
echo "</div>";




<?php

include '../../conexion.php';

$id=$_GET[proy_id];
$actividades_proyecto="select * from proyectos_lns where  enc_id='$id'";

$res_acts=$conex->query($actividades_proyecto);

$plantilla_acts='
    <table width="100%">     
  <thead>
    <tr>
        <th>fecha</th>
        <th>actividad</th>      
        <th>tipo</th>
        <th>producto</th>
        <th>mano de obra</th>
        <th>cantidad/dias</th>
        <th>activo</th>
        <th>horas de uso</th>
        <th>unidad</th>
        <th>subtotal</th>      
    </tr>
  </thead>
  <tbody>
   {}
  </tbody>
</table>';


while($acts=$res_acts->fetch(PDO::FETCH_ASSOC)){
    $lineas.="<tr>
      <td>$acts[fecha]</td>
      <td>$acts[actividad]</td>      
      <td>$acts[tipo]</td>      
      <td>$acts[producto]</td>      
      <td>$acts[mano_obra]</td>      
      <td>$acts[cantidad_dias]</td>      
      <td>$acts[activo]</td>      
      <td>$acts[horas_uso_activo]</td>      
      <td>$acts[unidad]</td>      
      <td>$acts[subtotal]</td>            
    </tr>";
}
echo '<h1>Actividades</h1>';
echo '<div style="overflow-y: auto;height: 700px;width:850px">';
echo preg_replace('/{}/', $lineas, $plantilla_acts);
echo '</div>';





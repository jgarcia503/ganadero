<?php

include '../../conexion.php';
extract($_GET);
$sql="select b.id,b.nombre_url,a.nivel,c.usuario  from menu_permisos a join urls b on a.id_url=b.id join contactos c on c.id=a.id_usuario
where c.id=$id";
$sql_niveles="select nivel from niveles";
$res=$conex->query($sql);
$res_niveles=$conex->query($sql_niveles)->fetchAll(PDO::FETCH_ASSOC);
$tabla="<div style='height:400px;width:450px;overflow-y: scroll;padding:10px'>
    <form data-abide='ajax' id='miforma'>
    <table>
    <thead>
    <tr>
      <th width='200'>seccion</th>
      <th>0</th>
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>4</th>
      <th>5</th>
    </tr>
  </thead>
  <tbody>

      {datos}
    
    <input type='hidden' name='id_usuario' value='$id'>
  </tbody>
</table>
<button id='guarda_permisos' type='submit'>actualizar permisos</button>
</form>
</div>";
$datos='';

while($fila=$res->fetch(PDO::FETCH_ASSOC)){
    $datos.="<tr>";
    $datos.= "<td>$fila[nombre_url]</td>";
    foreach ($res_niveles as  $value) {
        $datos.= "<td><input type='radio' name='permisos-$fila[id]' value='$value[nivel]' ";
        $datos.=($value[nivel]===$fila[nivel])?'checked':'';
        $datos.= "></td>";
    }
        
    $datos.="</tr>";
}
echo preg_replace('/{datos}/', $datos, $tabla);


?>

<script>
    $("#miforma").foundation('abide','events');
        $('#miforma').on('valid.fndtn.abide', function () {
                      $.ajax({
                                        url:'ajax/actualiza_permisos.php',
                                        data:$(this).serialize(),                                         
                                        
                                        success:function(data){
                                                alert(data);
                                            
                                    //$("span#mensaje").fadeOut(1500);
                                              
                                        }
                                    });    
  });
</script>

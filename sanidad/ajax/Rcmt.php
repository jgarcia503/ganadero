<?php

include '../../conexion.php';

$tabla="<table>
  <thead>
    <tr>
      <th>numero</th>     
      <th>nombre</th>     
      <th>DI</th>     
      <th>DR</th>     
      <th>TI</th>     
      <th>TD</th>     
    </tr>
  </thead>
  <tbody>
  {datos}
  </tbody>
</table>";

$sql="SELECT a.*,b.nombre from pruebas_cmt a
inner join animales b on b.numero=a.animal
where fecha ='$_GET[fecha]' ";
$lineas="";
$res=$conex->query($sql);
while($fila=$res->fetch()){
    $lineas.="<tr>";
    $lineas.="<td>".$fila[animal]."</td>";
    $lineas.="<td>".$fila[nombre]."</td>";
    if($fila[ubre_1]==3 or $fila[ubre_1]=='c'){
       $lineas.="<td  style='background-color: red;'>".$fila[ubre_1]."</td>";
    }else{
        $lineas.="<td  >".$fila[ubre_1]."</td>";
    }
   //$lineas.="<td ".($fila[ubre_1]=='3')?"style='background-color:red' >":'>'.$fila[ubre_1]."</td>";
    if($fila[ubre_2]==3 or $fila[ubre_2]=='c'){
    $lineas.="<td  style='background-color: red;'>".$fila[ubre_2]."</td>";
    }else{
        $lineas.="<td  >".$fila[ubre_2]."</td>";
    }
    
    if($fila[ubre_3]==3 or $fila[ubre_3]=='c'){
    $lineas.="<td  style='background-color: red;'>".$fila[ubre_3]."</td>";
    }
    else{
        $lineas.="<td  >".$fila[ubre_3]."</td>";
    }
        if($fila[ubre_4]==3 or $fila[ubre_4]=='c'){
    $lineas.="<td  style='background-color: red;'>".$fila[ubre_4]."</td>";
    }
    else{
        $lineas.="<td  >".$fila[ubre_4]."</td>";
    }
    $lineas.="</tr>";
    
}

echo preg_replace('/{datos}/', $lineas, $tabla);
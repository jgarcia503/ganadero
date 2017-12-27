<?php

include '../../conexion.php';
$id=$_GET[id];

$sql="select nombre from tablones where terreno_id ='$id'";
$res=$conex->query($sql)->fetchAll(PDO::FETCH_ASSOC);

echo "<table>";
echo "<tr>";
echo "<th>nombre</th>";
echo "</tr>";
foreach ($res as $v){
    echo "<tr>";
    echo "<td>";
  echo $v[nombre];
  echo "</td>";
  echo "</tr>";
}

echo "</table>";
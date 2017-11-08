<?php

try{
include '../../conexion.php';

if(isset($_GET[id])){
    $sql="select * from plagas_combatidas where id_enc=$_GET[id]";
    $res=$conex->query($sql);
    $tabla="<table>
  <thead>
    <tr>
      <th>plaga</th>     
      <th>tratamiento</th>     
    </tr>
  </thead>
  <tbody>
  {datos}
  </tbody>
</table>";

    while($fila=$res->fetch()){
            $lista.="<tr><td>$fila[plaga]</td><td> $fila[tratamiento]</td></tr>";
    }
    $tabla=preg_replace("/{datos}/", $lista, $tabla);

echo $tabla;
echo '<a class="close-reveal-modal" aria-label="Close">&#215;</a>';
}
else{
                $lineas = $_GET[lineas];
                $siembra_id_enc = $_GET[id_siembra];
                $sql2 = "insert into plagas_combatidas values ";
                $valores = '';
                foreach ($lineas as $linea) {

                    $plaga = $linea[plagas];
                    $tratamiento = $linea[tratamiento];



                    $valores.="(default,'$plaga','$tratamiento',$siembra_id_enc),";
                }


                $sql2.=trim($valores, ',');

                $insert = $conex->prepare($sql2);


                if ($insert->execute()) {

                    echo '<div data-alert class="alert-box success round">
                                <h5 style="color:white">registro creado exitosamente</h5>
                                <a href="#" class="close">&times;</a>
                                </div>';
                } else {
                    throw new PDOException();
                }
}

} catch (PDOException $pe){
         $conex->rollBack();
        echo '<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al insertar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
 }
 catch (Exception $ex){
     echo 'hubo algun error';
 }
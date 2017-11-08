<?php
include '../conexion.php';
$animal=base64_decode($_SERVER[QUERY_STRING]);

$sql="select '|' sep , numero,nombre,sexo,estado,fecha_nacimiento,fecha_deteste fecha_destete,peso_nacimiento,peso_deteste peso_destete,raza,color
	,marca_oreja,marca_hierro,tipo,procedencia,precio_venta,(select nombre from grupos where id::text=grupo) grupo,'|' sep1
	,parto,concepcion,padre,madre,abuelo_materno,abuelo_paterno
	,abuela_materna,abuela_paterna,'|' sep2
	,donadora,estado_cachos,temperamento,estructura,aplomos_corvejon,aplomos_cascos,grupa_ancho,grupa_angulo,
	to_char(current_date,'DD MM YYYY')::date  - (select fecha from partos where animal=numero||'-'||nombre order by fecha::date desc limit 1)::date dias_lactancia
                     ,fotos
                    from animales  where id=$animal";
$res=$conex->query($sql);
$animal=$res->fetch(PDO::FETCH_ASSOC);
$foto=$animal[fotos];
$plantilla='<input type="text" value="{}" readonly>';
$datos='';
unset($animal[fotos]);
$campos_x_fila=0;
foreach ($animal as $key=>$valor){
        if ($valor=='|'){
            $datos.=$valor;
            continue;
        }
     
           if ($campos_x_fila == 0) {
            $datos.="<div class='row'>";
        }
                $datos.="<div class='small-3 columns'> ";
                
        $key = ucwords(preg_replace('/_/', ' ', $key));

        if ($valor == null ) {
            $datos.="$key " . preg_replace('/{}/', '', $plantilla);
        }
            else {
            $datos.="$key " . preg_replace('/{}/', $valor, $plantilla);
        }
          $datos.="</div>";
        $campos_x_fila+=3;
        if ($campos_x_fila == 12) {
            $campos_x_fila = 0;
            $datos.="</div>";
        }      
}

echo "$foto";
echo $datos;
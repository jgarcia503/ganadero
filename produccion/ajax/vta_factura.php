<?php
include '../../vendor/autoload.php';
include '../../conexion.php';
use Dompdf\Dompdf;

$id=$_GET[id];
//$sql=<<<eof
//with datos as(
//select 0.37 precio_base,(select valor_centavos from puntos_grasa where  porcentaje="grasa_%")::float valor_grasa,
//(select valor_centavos from puntos_proteina  where  porcentaje="proteina_%")::float valor_proteina,
//(select valor_centavos from puntos_grasa where  porcentaje="reductasa_%")::float valor_reductasa,
//cantidad_botellas
//
//  from analisis_leche where id=$id ) 
//  select  (precio_base+valor_grasa+valor_proteina+valor_reductasa) unit,
//                (precio_base+valor_grasa+valor_proteina+valor_reductasa)*cantidad_botellas::float tot,
//                    cantidad_botellas from datos
//
//
//eof;
$sql="with total as(select grasa_valor::float+proteina_valor::float
                                    +rcs_x_1000::float+reductasa_valor::float
                                    +temperatura_valor::float+agua_valor::float
                                    +(0.37*cantidad_botellas::integer) total
                                        ,cantidad_botellas::integer
                                        from analisis_leche 
                            where id=$id)
select *,total/cantidad_botellas::float unitario from total";

$res=$conex->query($sql)->fetch();

$htmlfactenc="<table width='100%'>"
        . "<tr><td rowspan='3'><img src='../../assets/img/paso.png'></td>"
        . "<td><h4>paso firme s.a de c.v</h4></td></tr>"
        . "<tr><td style='width:50%'>calle a santa ana km. 80 cton cujucuyo, texistepeque santa ana</td></tr>"
        . "<tr><td>cria y engorde de ganado bovino elaboracion de alimentos preparados para animales</td></tr>"
        . "</table>"
        . "<table  width='100%' border='1' style='border-collapse:collapse'>"
        . "<tr><td>cliente:agrosania sa de cv</td><td>fecha</td></tr>"
        . "<tr><td>direccion: sur #1738</td><td>registro No:260-7</td></tr>"
        . "<tr><td>municipio:san salvador</td><td>giro: fabricacion de lacteos</td></tr>"
        . "<tr><td>departamento:san salvador</td><td>NIT:0614-150185-004-2</td></tr>"
        
        . "</table>";
        
$tablacss="<style> .fondo{"
        . " background-color: #4fab3d;"
        . "}</style>";

$htmlfact="<table width='100%' border='1' style='border-collapse:collapse'><tr class='fondo'>"
        . "<th>cant.</th>"
        . "<th>articulo</th>"
        . "<th>precio unit.</th>"
        . "<th>vta. no sujetas</th>"
        . "<th>vta. exentas</th>"
        . "<th>vta. gravada</th>"
        . "</tr>"
        . "<tr>"
        . "<td>".$res[cantidad_botellas]."</td>"
        . "<td>botellas leche</td>"
        . "<td>".number_format($res[unitario],4)."</td>"
        . "<td>-</td>"
        . "<td>-</td>"
         . "<td>".$res[total]."</td>"
        . "</tr>"        
        . "</table>";

$iva=$res[total]*0.13;
$subtotal=$iva+$res[total];
$percepcion=$subtotal*0.01;
$asileche=5.00;
$total=$subtotal+$iva-$asileche-$percepcion;
$htmlfoot="<table width='100%' border='1' style='border-collapse:collapse'>"
        . "<tr><td>sumas</td><td>$res[total]</td></tr>"
        . "<tr><td>13% iva</td><td>".number_format($iva,2)."</td></tr>"
        . "<tr><td>sub total</td><td>".number_format($subtotal,2)."</td></tr>"
        . "<tr><td>percepcion 1%</td><td>".number_format($percepcion,2)."</td></tr>"
        . "<tr><td>asileche</td><td>".number_format($asileche,2)."</td></tr>"
        . "<tr><td>total</td><td>".number_format($total,2)."</td></tr>"
        . "</table>";

$dompdf = new Dompdf();
$dompdf->loadHtml($tablacss.$htmlfactenc.$htmlfact.$htmlfoot);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('letter', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

?>
<style>
    .fondo{
        background-color: #4fab3d
    }
</style>
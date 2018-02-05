<nav class="top-bar" data-topbar="" role="navigation">
    <section class="top-bar-section">
<?php
//BLOQUES
$res=$conex->query('select * from menu_bloques');
while($fila=$res->fetch(PDO::FETCH_ASSOC)){
    echo ' <ul class="left">';
    echo '<li class="has-dropdown not-click"><a href="#">'.$fila[bloque].'</a>';
    echo '<ul class="dropdown">';
    //SUBBLOQUES
    $ressubblk=$conex->query("select * from menu_subbloques where bloque_id=$fila[id]");
    while($fila1=$ressubblk->fetch(PDO::FETCH_ASSOC)){
        if($fila1[id_url]===null){
                    echo '<li class="has-dropdown not-click"><a href="#">'.$fila1[subbloque].'</a>';
                    echo '<ul class="dropdown">';
                        //URLS
                        $resurl=$conex->query("select b.*,c.nivel from menu_urls a join urls b on a.id_url=b.id join menu_permisos c on c.id_url=b.id  where a.id_subloque=$fila1[id] and a.id_bloque=$fila[id] and c.nivel<>0");
                        while($fila2=$resurl->fetch(PDO::FETCH_ASSOC)){
                            echo '<li><a href=http://'.$_SERVER[HTTP_HOST].$fila2[url].">$fila2[nombre_url]</a></li>";
                            $_SESSION[permisos][$fila2[url]]=$fila2[nivel];
                                }
                    echo "</ul>";           
                    echo "</li>" ;          
                        }  else {
                                $url=$conex->query("select * from urls a  join menu_permisos b on a.id=b.id_url  where a.id=$fila1[id_url] and b.nivel<>0")->fetch();
                               echo '<li><a href=http://'.$_SERVER[HTTP_HOST].$url[url].">$url[nombre_url]</a></li>";
                               $_SESSION[permisos][$url[url]]=$url[nivel];
                        }

                }
         echo '</ul>' ;
         echo '</li>' ;
         echo '</ul>' ;
        }
?>
        </section>
</nav>

<!--<nav class="top-bar" data-topbar="" role="navigation">
<ul class="title-area">

<li class="name">
</li>

<li class="toggle-topbar menu-icon"><a href=""><span>Menu</span></a></li>
</ul>

    <section class="top-bar-section">
            <ul class="left">
          <li class=""><a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero/otros' ?>'>inicio</a>   </li>
              
              </ul>
        <ul class="left">
            <li class="has-dropdown not-click"><a href="#">ganado</a>
                <ul class="dropdown">
                    <li class="title back js-generated"><h5><a href="javascript:void(0)">atras</a></h5></li>



                    <li class="has-dropdown not-click"><a href="#">animales</a>
                        <ul class="dropdown">
                                 <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/ganado/animales.php">animales</a></li>
                    
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/ganado/razas.php">razas</a></li>
                    <li><a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/ganado/colores.php'>colores</a></li>
                    <li><a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/ganado/grupos.php'>grupos</a></li>              
                            
                        </ul>
                    </li>
                            <li class="has-dropdown not-click"><a href="#">produccion</a>
                        <ul class="dropdown">
                           <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/produccion/panimales.php">peso de animales</a></li>  <li class="divider"></li>
                            <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/produccion/pleche.php">produccion de leche</a></li><li class="divider"></li>
                            <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/produccion/analisis.php">analisis de leche</a></li>
                        </ul>
                    </li>
                               <li class="has-dropdown not-click"><a href="#">reproduccion</a>
                        <ul class="dropdown">
                            <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/reproduccion/servicios.php">servicios</a></li>  <li class="divider"></li>
                            <li><a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/reproduccion/palpaciones.php'>palpaciones</a></li>  <li class="divider"></li>
                            <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/reproduccion/respalpaciones.php">resultados palpacion</a></li>  <li class="divider"></li>
                            <li><a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/reproduccion/partos.php'>partos</a></li> <li class="divider"></li>
                            <li><a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/reproduccion/lista_negra.php'>lista incompatibilidad</a></li><li class="divider"></li>
                            <li><a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/reproduccion/pajillas.php'>pajillas</a></li>
                            <li><a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/reproduccion/plantilla_productos.php'>plantilla requisiciones servicios</a></li>
                        </ul>
                    </li>
                               <li class="has-dropdown not-click"><a href="#">mortalidad</a>
                        <ul class="dropdown">
                            <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/mortalidad/mortalidad.php">mortalidad</a></li>  
                            <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/mortalidad/causamortalidad.php">causa de mortalidad</a></li>
                        </ul>
                    </li>
                               <li class="has-dropdown not-click"><a href="#">sanidad</a>
                        <ul class="dropdown">
                            <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/sanidad/controlessanitarios.php">controles sanitarios</a></li>  <li class="divider"></li>
                            <li><a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/sanidad/eventossanitarios.php'>eventos sanitarios</a></li>   <li class="divider"></li>
                            <li><a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/sanidad/cmt/cmt.php'>pruebas CMT</a></li>   
                            <li><a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/sanidad/visita_medica/'>visitas medica</a></li>   
                            <li><a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/conta/tratamientos.php'>tratamientos medicos</a></li>   
                        </ul>
                    </li>
                               <li class="has-dropdown not-click"><a href="#">nutricion</a>
                        <ul class="dropdown">
                            <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/nutricion/dietas.php">dietas</a></li>  <li class="divider"></li>
                            <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/nutricion/suplementaciones.php">suplementaciones</a></li>  
                        </ul>
                    </li>

                </ul>
            </li>

        </ul>
        <ul class="left">
            <li class="has-dropdown not-click"><a href="#">terreno</a>
                <ul class="dropdown">
                    <li class="title back js-generated"><h5><a href="javascript:void(0)">atras</a></h5></li>

<li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/praderas/potreros.php">terrenos</a></li>  <li class="divider"></li>
                    
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/praderas/tablones.php">tablones</a></li><li class="divider"></li>                    
                    
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/praderas/tipocontrolpotrero.php">actividades</a></li>  <li class="divider"></li>
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/praderas/vegetacion.php">vegetacion</a></li>  <li class="divider"></li>
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/praderas/tiposvegetacion.php">tipos de cultivo</a></li>

        

                </ul>
            </li>

        </ul>
        <ul class="left">
            <li class="has-dropdown not-click"><a href="#">proyectos</a>
                <ul class="dropdown">
                    <li class="title back js-generated"><h5><a href="javascript:void(0)">atras</a></h5></li>


                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/cosechas/cosechas.php">cosecha</a></li>
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/siembras/proyectos.php">siembras</a></li>

                </ul>
            </li>

        </ul>
                <ul class="left">
            <li class="has-dropdown not-click"><a href="#">administracion</a>
                <ul class="dropdown">
                    <li class="title back js-generated"><h5><a href="javascript:void(0)">atras</a></h5></li>
                                         <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/contactos/haciendas.php">haciendas</a>
    
    <?php if($_SESSION[tipo]=='admin'){  ?>
    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/contactos/contactos.php">contactos</a>
    <?php } ?>

              <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/configuracion/">configuracion</a></li>      
             <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/alertas/">alertas</a></li> 
             <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/graficos/">produccion de leche</a></li>                    
                </ul>
            </li>
            
   
        </ul>
                        <ul class="left">
          <li class="has-dropdown not-click"><a href="#">financiero/contable</a>
                <ul class="dropdown">
                    <li class="title back js-generated"><h5><a href="javascript:void(0)">atras</a></h5></li>
                    <li class="has-dropdown not-click"><a href="#">activo</a>
                        <ul class="dropdown">
                        <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/activo/deterioro_activo.php">deterioro de activo</a></li>
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/activo/compra_activo.php">compra activo</a></li>                     
                    </ul>
                        </li>
         <li class="has-dropdown not-click"><a href="#">productos</a>
                        <ul class="dropdown">
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/productos/productos.php">productos</a></li>  <li class="divider"></li>                                                
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/productos/categorias.php">categorias</a></li>  <li class="divider"></li>                    
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/productos/marcas.php">marcas</a></li>  <li class="divider"></li>                    
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/productos/unidades.php">unidades</a></li>  
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/productos/compuestos.php">compuestos</a></li>  
                            
                        </ul>
                    </li>
                        <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/ventas/ventas.php">ventas</a></li>
                        
                               <li class="has-dropdown not-click"><a href="#">compras</a>
                        <ul class="dropdown">
            
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/compras/compras.php">compras</a></li><li class="divider"></li>
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/compras/bodegas.php">bodegas</a></li>  <li class="divider"></li>         
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/compras/traslados.php">traslados</a></li>  <li class="divider"></li>         
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/compras/requisiciones.php">requisiciones</a></li>  <li class="divider"></li>         
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/compras/motrequisiciones.php">motivos requesiciones</a></li>  <li class="divider"></li>         
                    <li><a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/compras/servicios.php">servicios</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/conta/inventarioFisico/inv_fisico.php">inventario fisico</a>
                    </li>
                </ul>
            </li>
            
              
        </ul>
           
    </section>
    
</nav>-->
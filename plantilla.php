<?php
session_start();
if(isset($_SESSION[permisos])){
    if(!array_key_exists($_SERVER[REQUEST_URI], $_SESSION[permisos])){
    
    header("location:/ganadero/otros");
    }
}

include  'conexion.php';
include 'vendor/autoload.php';
include 'php funciones/funciones.php';
if(isset($_SESSION[usuario])){
include 'assets.php';

?>

<div id="encabezado" class="row" >
    <div class="small-6 columns">
        
        <a href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero/otros' ?>'><h4><i class="fa fa-cloud" aria-hidden="true"></i>    <?php   echo $_SESSION[hacienda];?></h4> </a>                          
            
    </div>
    <div class="small-6 columns">
                 <?php
                            echo "<span class='right'>bienvenido $_SESSION[usuario]</span><br>";
                       ?>
        <a  href='<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/salir.php' id="salir" class="right">salir</a>

        <?php echo $_SESSION[fecha]?>

        </div>

</div>

<div class="row">
<?php 
include 'menu.php' ;
}
else{
    header("location: //$_SERVER[HTTP_HOST]/ganadero/");
}

?>
    </div>
<script>
$(document).on('ready',function(){
            $(document).foundation({abide : {
                     live_validate : true,
                    patterns: {
                      letters_and_spaces: /^[\w\-\s]+$/
                    }
                  }
});


});


</script>
<?php

#elimar variables que esten en proceso
unset($_SESSION['inventario']);
unset($_SESSION['traslado_lns']);
unset($_SESSION['codigo_silos']);
unset($_SESSION['lineas_fact']);

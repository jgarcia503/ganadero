<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/jquery/jquery.min.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/js/footable.min.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/awesomplete/awesomplete.min.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/jquerytimepicker/jquery.timepicker.min.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/notify/notify.min.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/underscore/underscore-min.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/jquery-flexdatalist/jquery.flexdatalist.min.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/appendgrid/jquery.appendGrid-1.6.3.min.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/multiple-select/multiple-select.js" ></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/zurb/js/vendor/modernizr.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/zurb/js/foundation.min.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/jquery-mask/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/select2/select2.min.js"></script>
<script src="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/numeral/numeral.min.js"></script>

<link rel="stylesheet" href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/appendgrid/jquery.appendGrid-1.6.3.min.css">
<link rel="stylesheet" href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/awesomplete/awesomplete.css">
<link rel="stylesheet" href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/fa/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/jquery-flexdatalist/jquery.flexdatalist.min.css">
<link rel="stylesheet" href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/css/footable.standalone.min.css">
<link rel="stylesheet" href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/jquerytimepicker/jquery.timepicker.css">
<link rel="stylesheet" href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/jsgrid/jsgrid.min.css">
<link rel="stylesheet" href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/jsgrid/jsgrid-theme.min.css">
<link rel="stylesheet" href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/multiple-select/multiple-select.css"  />
<link rel="stylesheet" href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/zurb/css/foundation.min.css">
<link  rel="stylesheet" href="<?php echo  'http://'.$_SERVER[HTTP_HOST].'/ganadero' ?>/assets/select2/select2.min.css" >

<style>
    h2{
        border-bottom: 1px solid #ddd;
        padding-bottom: 45px;
        margin-bottom: 22px;        
    }
    #menu{
        /*background-color:#efefef;*/
        background-color:#141A1B;
        
        height: 1050px;
        
    }
    #encabezado,#encabezado h4,#salir{      
        background-color: #2C6AA0;
        color: white;           
        /*height: 50px;*/
    }    

    .navegacion > a:after {
        content: "↡";
        padding-left: 5px;
        float: right;
        font-size: 20px; 
    }
    .navegacion.active > a:after {
        content: "↟"; 
    }
    .iconos{        
        padding: 3.5%;
        background-color: #6FB3E0;
        color:white;        
        margin-top: 2px;
    }
    .tooltip{
        background-color: steelblue;
    }
    .iconos:hover{
       box-shadow: 1px 1px 3px 3px  inset;
    }
    .fa-users{
        background-color: #FFB752;        
    }
    .fa-plus{
        background-color: #D15B47;
    }
    .fa-arrows{
     background-color: green;   
    }
    .fa-cubes{
        background-color: #9ccc65;
    }
    .row{
        max-width: 100%;
    }
    #navegacion>li>a{
        background-color: #141A1B;
        color: gray;
        border-bottom: 2px solid #3A4344;
    }
    #navegacion>li>a:hover{
        background-color: steelblue;
        color: white;
    }

    #ganado,
    #produccion,
    #reproduccion,
    #mortalidad,
    #sanidad,
    #praderas,
    #nutricion,
    #lluvias,
    #prods,
    #compras,
    #graficos
    {
        background-color: #3A4344;
    }
    span#cantidad{
        text-decoration: underline;
        color: steelblue;
    }
    span#cantidad:hover{
        cursor: pointer;        
    }
    
    a.regresar:hover{
        text-decoration: underline;
    }

</style>
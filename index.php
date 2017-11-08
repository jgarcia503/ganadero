<?php
session_start();
if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')==  'POST'){

    include 'conexion.php';
    $login=false;
    if(filter_has_var(INPUT_POST, 'usuario') and filter_has_var(INPUT_POST, 'pass')){
        $user = $conex->query("select * from contactos where usuario='".filter_input(INPUT_POST, 'usuario')."' "
                                                                  . " and contrasena='".filter_input(INPUT_POST, 'pass')."'");
    if ($user->rowCount() > 0) {

           $hacienda=$conex->query("select nombre from haciendas")->fetch();
          
           $_SESSION[usuario]=  filter_input(INPUT_POST, 'usuario');
           $_SESSION[tipo]=$user->fetch()[tipo];
           $_SESSION[hacienda]=$hacienda[nombre];
           $_SESSION[fecha]=date('d m Y ',time()) ;
           $_SESSION[ip]=$_SERVER[HTTP_HOST];
            echo "<script>window.location='otros';</script>";
        }
    }
}else{

    if(isset($_SESSION[usuario])){
      echo "<script>window.location='otros';</script>";
}
}


?>



  <div class="mdl-layout mdl-js-layout mdl-color--red-200">
      <div class="mdl-card mdl-shadow--6dp">
			<div class="mdl-card__title mdl-color--primary mdl-color-text--white">
				<h2 class="mdl-card__title-text">hacienda</h2>
			</div>
          
      <div class="mdl-card__supporting-text">
          <form method="post" id="login" autocomplete="off">
<div class="mdl-textfield mdl-js-textfield">
    
        <label class="mdl-textfield__label"></label>
          <input type="text" class="mdl-textfield__input"  name="usuario">
      
  </div>
    <div class="mdl-textfield mdl-js-textfield">
        <label class="mdl-textfield__label">contrasena</label>
          <input type="password" class="mdl-textfield__input" name="pass">
      
    </div>

              <input id="envia" type="submit" value="entrar" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="text-align: center">
</form>
          
  </div>
  

<?php if(!$login and $_POST){  ?>
<span style="color:red;text-align: center">Datos Incorrectos</span>
<?php  } ?>

<script src="assets/jquery/jquery.min.js"></script>
<script src="assets/notify/notify.min.js"></script>
<script src="material.min.js"></script>
<link rel="stylesheet" href="material.min.css">
<style>
    .mdl-layout {
        align-items: center;
        justify-content: center;
    }
    .mdl-layout__content {
        padding: 24px;
        flex: none;
    }
    [type='submit']{
        margin-left: 100px;
        margin-right: 100px;

    }
    h2{
        text-align: center;
    }
    
</style>

<script>
    $('#envia').on('click',function(e){
        e.preventDefault();
        var user=$('[name=usuario]').val();
        var pass=$('[name=pass]').val();
        if(user==''){
                    $('[name=usuario]').notify("usuario vacio",{className: 'info',autoHideDelay: 1500});                    
            return;
        }if(pass==''){
               $('[name=pass]').notify("password vacio",{className: 'info',autoHideDelay: 1500});                    
        }
        else{
            $('#login').submit();
        }
    });

</script>
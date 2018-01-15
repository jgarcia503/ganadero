<?php  include '../plantilla.php';

  if($_POST){

      
      try{
                $rut= $_SERVER['DOCUMENT_ROOT'].'/ganadero/img_animales/'. $_FILES['fotos']['name'];
                $nombre_foto=$_FILES['fotos']['name'];
      move_uploaded_file($_FILES['fotos']['tmp_name'], $rut);
  
    $insert =$conex->prepare("insert into animales"
              . " values(default,'$_POST[numero]','$_POST[nombre]','$_POST[sexo]','$_POST[estado]'"
            . ",'$_POST[propietario]','$_POST[registro]','$_POST[fec_nac]','$_POST[fec_deteste]'"
            . ",'$_POST[peso_nac]','$_POST[peso_deteste]','$_POST[raza]','$_POST[color]'"
            . ",'$_POST[marca_oreja]','$_POST[marca_hierro]','$_POST[tipo]','$_POST[procedencia]'"
            . ",'$_POST[precio_venta]','$_POST[parto]','$_POST[concepcion]','$_POST[padre]'"
            . ",'$_POST[madre]','$_POST[abuelo_materno]','$_POST[abuelo_paterno]','$_POST[abuela_materna]'"
            . ",'$_POST[abuela_paterna]','$_POST[donadora]','$_POST[cachos]','$_POST[temperamento]'"
            . ",'$_POST[pigmento]','$_POST[condicion_corporal]','$_POST[corvejon]','$_POST[cascos]'"
            . ",'$_POST[cuartillas]','$_POST[cir_escrotal]','$_POST[prepucio]','$_POST[potencia]'"
            . ",'$_POST[semen]','$nombre_foto',trim('$_POST[notas]'),'$_POST[cc]'"
            . ",'$_POST[grupo]','$_POST[clasificacion]','$_POST[ancho]','$_POST[angulo]')");
    
    if($insert->execute()){
        $mensaje='<div data-alert class="alert-box success round">
 <h5 style="color:white">animal creado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }else{
      $mensaje= '<div data-alert class="alert-box alert round">
  <h5 style="color:white">Error al insertar el registro</h5>
  <a href="#" class="close">&times;</a>
</div>';
}
    
      }
 catch (Exception $ex){
     echo $ex->getMessage();
 }
//      $rut= $_SERVER['DOCUMENT_ROOT'].'/ganadero/img_sub/';
//      move_uploaded_file($_FILES['fotos']['tmp_name'], $rut. $_FILES['fotos']['name']);
//      var_dump($_FILES);

  }

  $razas=$conex->query("select nombre from razas");
  $colores=$conex->query("select nombre from colores");
  $contactos=$conex->query("select nombre from contactos where tipo='admin'");
    $grupo=$conex->query("select * from grupos");
  ?>
<div class="small-12 columns">
    <h2>crear animal</h2>
    <?php echo $mensaje?>
    <a href="animales.php" class="regresar">regresar</a>
  <form action="Canimal.php" method="post" enctype="multipart/form-data"  data-abide>
 <ul class="tabs" data-tab>
  <li class="tab-title active"><a href="#panel1">datos generales</a></li>
  <li class="tab-title"><a href="#panel2">genealogia</a></li>
  <li class="tab-title"><a href="#panel3">fenotipo</a></li>
  <li class="tab-title"><a href="#panel4">foto</a></li>
  <li class="tab-title"><a href="#panel5">clase</a></li>
</ul>
<div class="tabs-content">
  <div class="content active" id="panel1">
         <div class="row">
          <div class="small-4 columns">      
              <div class="row">
                  <div class="small-12 columns">
                        <label for="">Arete Paso Firme</label>
                        <input type="text" name='numero' required="">
                        <small class="error">numero es requerido</small>
                  </div>
              </div>
           <div class="row">
              <div class="small-12 columns">
                  <label for="">nombre</label>
                  <input type="text" name="nombre" required="">
                  <small class="error">nombre es requerido</small>
              </div>
           </div>
      
<!--      <label for="">registro</label>
      <input type="text" name="registro">-->
      <label for="">fecha nacimiento</label>
      <input type="text" name="fec_nac">
      <label for="">fecha destete</label>
      <input type="text" name="fec_deteste">
       <div class="row">
                   <div class="small-12 columns">
      <label for="">peso nac</label>
      <input type="text" name="peso_nac" pattern="number">
      <small class="error">solo numero</small>
      </div>
      </div>
              <label for="">marca hierro</label>
              <input type="checkbox" name="marca_hierro" value="si">

          </div>
          <div class="small-4 columns">
                     <label for="">peso destete</label>
      <input type="text" name="peso_deteste">
              
     
      <label for="">arete MAG</label>
      <input type="text" name="marca_oreja">
    
       
       
     
      <label for="">procedencia</label>
      <input type="text" name="procedencia">
      <div class="row">
          <div class='small-12 columns'>
            <label for="">precio compra</label>
            <input type="text" name="precio_compra" pattern='number'>
            <small class="error">solo numero</small>
            </div>
      </div>
               <!--si es hembra-->
               <div class="row">
                   <div class="small-12 columns">
                         <label for="">parto
      <select name="parto">
          <option value="">seleccione</option>
          <option value="primero">primero</option>
          <option value="segundo">segundo</option>
          <option value="tercero">tercero</option>
          <option value="cuarto">cuarto</option>
          <option value="quinto">quinto</option>
          <option value="sexto">sexto</option>
          <option value="septimo">septimo</option>
          <option value="octavo">octavo</option>
          <option value="noveno">noveno</option>                
      </select>
      </label>
                   </div>
               </div>
                     <label>grupo</label>
      <select name="grupo" >
          <option value="">seleccione</option>
          <?php
          while($fila=$grupo->fetch()){
              echo "<option value='$fila[id]'>$fila[nombre]</option>";
          }
          ?>
      </select>
          </div>
             <div class="small-4 columns">
                 <div class="row">
                     <div class="small-12 columns">
                                         <label for="">sexo</label>
                                         <select name="sexo"  required="">
                                             <option value="">seleccionar</option>
                                             <option value="Hembra">hembra</option>
                                             <option value="Macho">macho</option>
                                         </select>
                                         <small class="error">sexo es requerido</small>
                     </div>
                 </div>
                 <div class="row">
                     <div class="small-12 columns">                           
                         <label for="">estado</label>                          
                         <select name="estado" required="">
                             <option value="">seleccione</option>
                             <option value="Muerto">muerto</option>
                             <option value="Activo">activo</option>
                             <option value="Vendido">vendido</option>
                             <option value="Externo">externo</option>
                         </select>
                         <small class="error">estado es requerido</small>
                     </div>
                 </div>
                 <div class="row">
                     <div class="small-12 columns">
<!--                         <label for="">propietario</label>      
                         <select name="propietario" required="">
                             <option value="">seleccione</option>
                             <?php
                             while ($fila = $contactos->fetch()) {
                                 echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                             }
                             ?>
                         </select>
                         <small class="error">propietario es requerido</small>-->
                     </div>
                 </div>

      <label for="">raza</label>
      <select name="raza">
          <option value="">seleccione</option>
          <?php
          while($fila=$razas->fetch()){
              echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
          }
          ?>
          
      </select>
            <label for="">tipo</label>
      <select name="tipo" id="">
          <option value="seleccione">seleccione</option>
          <option value="lechero">lechero</option>
          <option value="carne">carne</option>
          <option value="doble proposito">doble proposito</option>
          <option value="puro">puro</option>
      </select>
      <label for="">color</label>
      <select name="color" id="">
                  <option value="">seleccione</option>
          <?php
                                while($fila=$colores->fetch()){
                                    echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                                }
                                ?>
      </select>
             </div>
      </div>
  </div>
  <div class="content" id="panel2">
      <div class="row">
          <div class="small-4 columns">
                 <label for="">padre</label>
                 <input type="text" name="padre" pattern="alpha">
          </div>
          <div class="small-4 columns">
              <label for="">madre</label>
          <input type="text" name="madre" pattern="alpha">
          </div>
          <div class="small-4 columns">
              <label for="">concepcion</label>
          <select name="concepcion">
              <option value="seleccione">seleccione</option>
              <option value="monta">monta</option>
              <option value="inseminacion">inseminacion</option>
              <option value="te">tranferencia embriones</option>
              <option value="fiv">fecundacion in vitro</option>
          </select>
          </div>
      </div>
      <div class="row">
          <div class="small-4 columns">  
              <label for="">abuelo materno</label>
                <input type="text" name="abuelo_materno" pattern="alpha">
          </div>
          <div class="small-4 columns">
                 <label for="">abuelo paterno</label>
                <input type="text" name="abuelo_paterno" pattern="alpha">
          </div>
          <div class="small-4 columns">
                  <!--si es te o fiv-->
          <label for="">donadora
          <input type="text" name="donadora" pattern="alpha">
          </label>
          </div>
      </div>
      <div class="row">
          <div class="small-4 columns">
                 <label for="">abuela materna</label>
                <input type="text" name="abuela_materna" pattern="alpha">
          </div>
          <div class="small-4 columns">
                 <label for="">abuela paterna</label>
                <input type="text" name="abuela_paterna" pattern="alpha">
          </div>
          <div class="small-4"></div>
      </div>
     
          
          
      
  </div>
  <div class="content" id="panel3">
          <div class="row">

          <div class="small-4 columns"> 
              <h5>&nbsp;</h5>
<!--              <label for="">pigmento</label>
      <input type="text" name="pigmento">-->
      <label for="">condicion corporal</label>
      <select name="condicion_corporal">
          <option value="">seleccione</option>
          <?php
                $cc=1;
                for (;$cc<=5;$cc+=0.25){
                    echo "<option value='$cc'>$cc</option>";
                }
          ?>
      </select>
      <!--<input type="text" name="estructura">-->
            <div class="row">
          <div class="small-12 columns">
      <label for="">temperamento</label>
      <input type="text" name="temperamento" pattern="alpha">
      <small class="error">solo texto</small>
      </div>
      </div>
      <label for="">estado cachos</label>
      <select name="cachos" id=""><option value="cuernos">cuernos</option>
          <option value="descornado">descornado</option></select>
          </div>
          <div class="small-4 columns">   
              <h5>aplomos</h5>
      <label for="">aplomos corvejon</label>
      <input type="text" name="corvejon">
      <label for="">aplomos cuartillas</label>
      <input type="text" name="cuartillas">
      <label for="">aplomos cascos</label>
      <input type="text" name="cascos">
          </div>
          <div class="small-4 columns">
<!--                    <h5>genitales</h5>
      <label for="">circunferencia escrotal</label>
      <input type="text" name="cir_escrotal" pattern="number">
      <label for="">potencia</label>
      <input type="text" name="potencia">
      <label for="">prepucio</label>
      <input type="text" name="prepucio">
      <label for="">semen</label>
      <input type="text" name="semen">-->
<h5>grupa</h5>
<label>ancho</label>
<select name="ancho">
    <option value="">seleccione</option>
    <option value="ancha">ancha</option>
    <option value="media">media</option>
    <option value="estrecha">estrecha</option>
</select>
<label>angulo</label>
<select name="angulo">
        <option value="">seleccione</option>
        <option value="plana">plana</option>
        <option value="leve">leve</option>
        <option value="pronunciada">pronunciada</option>
</select>
                </div>
      </div>
  </div>
  <div class="content" id="panel4">
      <div class="row">
          <div class="small-12 columns">
               <input type="file" name="fotos" accept="image/*" >
          </div>
      </div>
     
  </div>    
      <div class="content" id="panel5">

          
          <div style="width: 48%;float: left">

<?php
$res=$conex->query("select * from cn_catalogo");
?>
              <div class="small-12 columns">
                  <label for="">cuenta contable
                      <input type="text" name="cc" id="cc" readonly="" required="">
                      <small class="error">cuenta contable es requerida</small>
                  </label>
              </div>
            
    
        <table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>cuenta</th>
			<th>descripcion</th>
		
                        <!--<th data-filterable="false"></th>-->
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){

    ?>
            <tr>
                <td>
                    <a href="#" class="cuenta_id"><?php  echo $fila[cuenta_id]?></a>
                    <input type="hidden" id="<?php  echo $fila[cuenta_id]?>" value="<?php  echo $fila[sumariza].'/'.$fila[descripcion]?>">                    
                    
                </td>
                <td><?php  echo $fila[descripcion]?></td>
   
                <td><a href="">ver</a>
                    <a href="">editar</a>
                    <a href="">eliminar</a>
                </td>
            </tr>
            
<?php
}
?>	

	</tbody>
</table>
</div> 
          
  </div>
          <div class="row">
          <div class="small-12 columns">
              <label for="">notas</label>  <textarea name="notas" id="" cols="100" rows="10"></textarea>
                 
  
          </div>
      </div>
    
</div>
      <input type="submit" value="crear registro" class="button primary">
  </form>

</div>
</div>

<script>
    $(".table").footable();
    
    $('.table').on('click','.cuenta_id',function(e){
        e.preventDefault();
        $('#cc').val( $(this).html());
    });
    
   
      
      $("[name=fec_nac]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy",changeYear: true,changeMonth:true});
      $("[name=fec_deteste]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy",changeYear: true,changeMonth:true});
      
      $("[name=concepcion]").on('change',function(){
          
          var valor=$(this).val();
          if(valor=='te' || valor=='fiv'){
              $("[name=donadora]").parent('label').fadeIn(1500);
          }
          else{
               $("[name=donadora]").parent('label').fadeOut(1500);
          }                                
               
      });
      
//      $("[name=sexo]").on('change',function(){
//                var sexo =$(this).val();
//      switch(sexo){
//          case 'Hembra':
//              $("[name=parto]").parent('label').fadeIn(1500);
//              $("[name=cir_escrotal]").parent('div').fadeOut(1500);
//              $('#panel3 .small-4:nth-child(3)').fadeOut(1500);
//              //campos macho reseteo valores si habia escritp algo
//              $("#panel3 .small-4:nth-child(3) input").val("");
//              break;
//              
//            case 'macho':
//                $("[name=parto]").parent('label').fadeOut(1500);                
//                $("[name=cir_escrotal]").parent('div').fadeIn(1500);
//                //parto seleccione la primera opcion (reseteo)
//                $("[name=parto] option:first").prop('selected', true);                 
//                break;
//                                                 }
//                            });
                            

  </script>
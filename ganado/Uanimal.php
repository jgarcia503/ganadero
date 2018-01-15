<?php  include '../plantilla.php';

  if($_POST){      

      try{
                $rut= $_SERVER['DOCUMENT_ROOT'].'/ganadero/img_animales/'. $_FILES['fotos']['name'];
                $nombre_foto=$_FILES['fotos']['name'];
      move_uploaded_file($_FILES['fotos']['tmp_name'], $rut);
      
      $conex->beginTransaction();
  
    $update =$conex->prepare("update animales set numero='$_POST[numero]'"
            . ",nombre='$_POST[nombre]'"
            . ",sexo='$_POST[sexo]'"
            . ",estado='$_POST[estado]'"             
            . ",propietario_id='$_POST[propietario]'"
            . ",registro='$_POST[registro]'"
            . ",fecha_nacimiento='$_POST[fec_nac]'"
            . ",fecha_deteste='$_POST[fec_destete]'"
            . ",peso_nacimiento='$_POST[peso_nac]'"
            . ",peso_deteste='$_POST[peso_deteste]'"
            . ",raza='$_POST[raza]'"
            . ",color='$_POST[color]'"
            . ",marca_oreja='$_POST[marca_oreja]'"
            . ",marca_hierro='$_POST[marca_hierro]'"
            . ",tipo='$_POST[tipo]'"
            . ",procedencia='$_POST[procedencia]'"
            . ",precio_venta='$_POST[precio_venta]'"
            . ",parto='$_POST[parto]'"
            . ",concepcion='$_POST[concepcion]'"
            . ",padre='$_POST[padre]'"
            . ",madre='$_POST[madre]'"
            . ",donadora='$_POST[donadora]'"
            . ",estado_cachos='$_POST[cachos]'"
            . ",temperamento='$_POST[temperamento]'"
            . ",pigmento='$_POST[pigmento]'"
            . ",estructura='$_POST[condicion_corporal]'"
            . ",aplomos_corvejon='$_POST[corvejon]'"
            . ",aplomos_cascos='$_POST[cascos]'"
            . ",aplomos_cuartillas='$_POST[cuartillas]'"
            . ",circunferencia_escrotal='$_POST[cir_escrotal]'"
            . ",prepucio='$_POST[prepucio]'"
            . ",potencia='$_POST[potencia]'"
            . ",semen='$_POST[semen]'"
            #. ",fotos='$nombre_foto'"
            . ",notas=trim('$_POST[notas]')"
            . ",cc='$_POST[cc]' "
            . ",grupo='$_POST[grupo]' "
            . ",clasificacion='$_POST[clasificacion]' "
            . ",grupa_ancho='$_POST[ancho]' "
            . ",grupa_angulo='$_POST[angulo]' "           
            . "where id=$_POST[id]");
    
            $sqlactualiza="update lotes set animales=replace(animales,'$_POST[num_ant]','$_POST[numero]')";
            $actualiza2=$conex->prepare($sqlactualiza) ;
            
            $sqlactualiza3="update bit_peso_animal set numero=replace(numero,'$_POST[num_ant]','$_POST[numero]'),"
                    . " nombre=replace(nombre,'$_POST[nom_ant]','$_POST[nombre]')";
                $actualiza3=$conex->prepare($sqlactualiza3) ;
                
//                $sqlactualiza4="update bit_peso_leche_lns set numero=replace(numero,'$_POST[num_ant]','$_POST[numero]'),"
//                    . " nombre=replace(nombre,'$_POST[nom_ant]','$_POST[nombre]')";
//                $actualiza4=$conex->prepare($sqlactualiza4) ;
                
            
    if($update->execute() and 
            $actualiza2->execute() and
            $actualiza3->execute() 
            ){
        $conex->commit();
        $mensaje= '<div data-alert class="alert-box success round">
 <h5 style="color:white">animal actualizado exitosamente</h5>
  <a href="#" class="close">&times;</a>
</div>';
    }else{
     throw new PDOException();
                }
    
      }
                catch (PDOException $pe){
                                    $conex->rollBack();
        $mensaje='<div data-alert class="alert-box alert round">
       <h5 style="color:white">Error al actualizar el registro</h5>
       <a href="#" class="close">&times;</a>
       </div>';
            }
//      $rut= $_SERVER['DOCUMENT_ROOT'].'/ganadero/img_sub/';
//      move_uploaded_file($_FILES['fotos']['tmp_name'], $rut. $_FILES['fotos']['name']);
//      var_dump($_FILES);

  }
  $id=base64_decode($_SERVER[QUERY_STRING]);
  $razas=$conex->query("select nombre from razas");
  $colores=$conex->query("select nombre from colores");
  $animales=$conex->query("select * from animales where id='$id'")->fetch();
  $contactos=$conex->query("select nombre from contactos where tipo='admin'");
  $grupo=$conex->query("select * from grupos");
  ?>
<div class="small-12 columns">
    <?php echo $mensaje?>
    
    <h2>actualizar animal</h2>
    <a href="animales.php" class="regresar">regresar</a>
  <form action="" method="post" enctype="multipart/form-data" >
 <ul class="tabs" data-tab>
  <li class="tab-title active"><a href="#panel1">datos generales</a></li>
  <li class="tab-title"><a href="#panel2">genealogia</a></li>
  <li class="tab-title"><a href="#panel3">fenotipo</a></li>
  <!--<li class="tab-title"><a href="#panel4">fotos</a></li>-->
  <li class="tab-title"><a href="#panel5">clase</a></li>
  
</ul>
<div class="tabs-content">
  <div class="content active" id="panel1">
         <div class="row">
          <div class="small-4 columns">      
      <label for="">Arete paso firme</label>
      <input type="text" name='numero' value="<?php echo $animales[numero]?>">
      <label for="">nombre</label>
      <input type="text" name="nombre" value="<?php echo $animales[nombre]?>">
<!--      <label for="">registro</label>
      <input type="text" name="registro" value="<?php echo $animales[registro]?>">-->
      <label for="">fecha nacimiento</label>
      <input type="text" name="fec_nac" value="<?php echo $animales[fecha_nacimiento]?>">
      <label for="">fecha deteste</label>
      <input type="text" name="fec_destete" value="<?php echo $animales[fecha_deteste]?>">
      <label for="">peso nac</label>
      <input type="text" name="peso_nac" value="<?php echo $animales[peso_nacimiento]?>">
   
      <label for="">marca hierro</label>
      <input type="checkbox" name="marca_hierro" value="si" <?php  if($animales[marca_hierro]=='si') echo 'checked'; ?>>

          </div>
          <div class="small-4 columns">
              <label for="">peso deteste</label>
      <input type="text" name="peso_deteste" value="<?php echo $animales[peso_deteste]?>">
      <label for="">Arete MAG</label>
      <input type="text" name="marca_oreja" value="<?php echo $animales[marca_oreja]?>">
      
                    <label for="">procedencia</label>
      <input type="text" name="procedencia" value="<?php echo $animales[procedencia]?>">
      <label for="">precio compra</label>
      <input type="text" name="precio_venta" value="<?php echo $animales[precio_venta]?>">
               <!--si es hembra-->
               <div class="row">
                   <div class="small-12 columns">
                         <label for="">parto
      <select name="parto">
          
          <option value="">seleccione</option>
          <option value="primero"  <?php if($animales[parto]=='primero') echo 'selected' ?>>primero</option>
          <option value="segundo" <?php if($animales[parto]=='segundo') echo 'selected' ?>>segundo</option>
          <option value="tercero" <?php if($animales[parto]=='tercero') echo 'selected' ?>>tercero</option>
          <option value="cuarto" <?php if($animales[parto]=='cuarto') echo 'selected' ?>>tercero</option>
          <option value="quinto" <?php if($animales[parto]=='quinto') echo 'selected' ?>>tercero</option>
          <option value="sexto" <?php if($animales[parto]=='sexto') echo 'selected' ?>>tercero</option>
          <option value="septimo" <?php if($animales[parto]=='septimo') echo 'selected' ?>>tercero</option>
          <option value="octavo" <?php if($animales[parto]=='octavo') echo 'selected' ?>>tercero</option>
          <option value="noveno" <?php if($animales[parto]=='noveno') echo 'selected' ?>>tercero</option>
          
      
      </select>
      </label>
                   </div>
               </div>
               <label>grupo</label>
      <select name="grupo" >
          <option value="">seleccione</option>
          <?php
          while($fila=$grupo->fetch()){
              echo "<option value='$fila[id]' ";
              echo $animales[grupo]==$fila[id] ?"selected":"";
              echo ">$fila[nombre]</option>";
          }
          ?>
      </select>
          </div>
             <div class="small-4 columns">
                  <label for="">sexo</label>
      <select name="sexo" >
          <option value="">seleccionar</option>
          <option value="Hembra"  <?php if($animales[sexo]=='Hembra') echo 'selected' ?>>hembra</option>
          <option value="Macho"  <?php if($animales[sexo]=='Macho') echo 'selected' ?>>macho</option>
      </select>
      <label for="">estado</label>
      <select name="estado" id="">
          <option value="">seleccione</option>
          <option value="Muerto" <?php if($animales[estado]=='Muerto') echo 'selected' ?>>muerto</option>
          <option value="Activo" <?php if($animales[estado]=='Activo') echo 'selected' ?>>activo</option>
          <option value="Vendido" <?php if($animales[estado]=='Vendido') echo 'selected' ?>>vendido</option>
          <option value="Externo" <?php if($animales[estado]=='Externo') echo 'selected' ?>>externo</option>
      </select>
<!--      <label for="">propietario</label>      
      <select name="propietario" id="">
          <option value="">seleccione</option>
           <?php
                             while ($fila = $contactos->fetch()) {
                                 echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                             }
                             ?>
      </select>-->
      <label for="">raza</label>
      <select name="raza" id="">
          <option value="seleccione">seleccione</option>
          <?php
          while($fila=$razas->fetch()){
              echo "<option val='$fila[nombre]' ";
              echo $fila[nombre]==$animales[raza]?'selected':'';
              echo ">$fila[nombre]</option>";
          }
          ?>
          
      </select>
            <label for="">tipo</label>
      <select name="tipo">
          <option value="seleccione">seleccione</option>
          <option value="lechero"  <?php if($animales[tipo]=='lechero') echo 'selected' ?>>lechero</option>
          <option value="carne" <?php if($animales[tipo]=='carne') echo 'selected' ?>>carne</option>
          <option value="doble proposito" <?php if($animales[tipo]=='doble proposito') echo 'selected' ?>>doble proposito</option>
          <option value="puro" <?php if($animales[tipo]=='puro') echo 'selected' ?>>puro</option>
      </select>
      <label for="">color</label>
      <select name="color" id="">
          <?php
                                while($fila=$colores->fetch()){
                                    echo "<option value='$fila[nombre]' ";
                                    echo $fila[nombre]==$animales[color]?'selected':'';
                                    echo ">$fila[nombre]</option>";
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
          <input type="text" name="padre" value="<?php echo $animales[padre]?>">
      </div>
           <div class="small-4 columns">
                  <label for="">madre</label>
          <input type="text" name="madre" value="<?php echo $animales[madre]?>">
      </div>
           <div class="small-4 columns">
                        <label for="">concepcion</label><select name="concepcion">
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
                <input type="text" name="abuelo_materno" value="<?php echo $animales[abuelo_materno]?>">
          </div>
          <div class="small-4 columns">
                 <label for="">abuelo paterno</label>
                <input type="text" name="abuelo_paterno" value="<?php echo $animales[abuelo_paterno]?>">
          </div>
          <div class="small-4 columns">
                  <!--si es te o fiv-->
          <label for="">donadora
          <input type="text" name="donadora" value="<?php echo $animales[donadora]?>">
          </label>
          </div>
      </div>  
                <div class="row">
          <div class="small-4 columns">
                 <label for="">abuela materna</label>
                <input type="text" name="abuela_materna" value="<?php echo $animales[abuela_materna]?>">
          </div>
          <div class="small-4 columns">
                 <label for="">abuela paterna</label>
                <input type="text" name="abuela_paterna" value="<?php echo $animales[abuela_paterna]?>">
          </div>
          <div class="small-4"></div>
      </div>
  </div>
  <div class="content" id="panel3">
          <div class="row">

          <div class="small-4 columns"> 
              <h5>&nbsp;</h5>
<!--              <label for="">pigmento</label>
      <input type="text" name="pigmento" value="<?php echo $animales[pigmento]?>">-->
<!--      <label for="">estructura</label>
      <input type="text" name="estructura" value="<?php echo $animales[estructura]?>">-->
    <label for="">condicion corporal</label>
      <select name="condicion_corporal">
          <option value="">seleccione</option>
          <?php
                $cc=1;
                for (;$cc<=5;$cc+=0.25){
                    echo "<option value='$cc' ";
                    echo $cc==$animales[estructura]?'selected':'';
                     echo  " >$cc</option>";
                }
          ?>
      </select>
      <label for="">temperamento</label>
      <input type="text" name="temperamento" value="<?php echo $animales[temperamento]?>">
      <label for="">estado cachos</label>
      <select name="cachos" id="">
          <option value="cuernos" <?php if($animales[estado_cachos]=='cuernos') echo 'selected' ?>>cuernos</option>
          <option value="descornado" <?php if($animales[estado_cachos]=='descornado') echo 'selected' ?>>descornado</option>
      </select>
          </div>
          <div class="small-4 columns">   
              <h5>aplomos</h5>
      <label for="">aplomos corvejon</label>
      <input type="text" name="corvejon" value="<?php echo $animales[aplomos_corvejon]?>">
      <label for="">aplomos cuartillas</label>
      <input type="text" name="cuartillas" value="<?php echo $animales[aplomos_cuartillas]?>">
      <label for="">aplomos cascos</label>
      <input type="text" name="cascos"  value="<?php echo $animales[aplomos_cascos]?>">
          </div>
                <div class="small-4 columns">
<!--                    <h5>genitales</h5>
      <label for="">circunferencia escrotal</label>
      <input type="text" name="cir_escrotal"  value="<?php echo $animales[circunferencia_escrotal]?>">
      <label for="">potencia</label>
      <input type="text" name="potencia"  value="<?php echo $animales[potencia]?>">
      <label for="">prepucio</label>
      <input type="text" name="prepucio"  value="<?php echo $animales[prepucio ]?>">
      <label for="">semen</label>
      <input type="text" name="semen"  value="<?php echo $animales[semen]?>">-->
<h5>grupa</h5>
<label>ancho</label>
<select name="ancho">
 <option value="">seleccione</option>
    <option value="ancha" <?php echo $animales[grupa_ancho]=='ancha'?'selected':'' ?>>ancha</option>
    <option value="media" <?php echo $animales[grupa_ancho]=='media'?'selected':'' ?>>media</option>
    <option value="estrecha" <?php echo $animales[grupa_ancho]=='estrecha'?'selected':'' ?>>estrecha</option>
</select>
<label>angulo</label>
<select name="angulo">
       <option value="">seleccione</option>
        <option value="plana" <?php echo $animales[grupa_angulo]=='plana'?'selected':'' ?>>plana</option>
        <option value="leve" <?php echo $animales[grupa_ancho]=='leve'?'selected':'' ?>>leve</option>
        <option value="pronunciada" <?php echo $animales[grupa_ancho]=='pronunciada'?'selected':'' ?>>pronunciada</option>
</select>
                </div>
      </div>
  </div>
<!--  <div class="content" id="panel4">
      <div class="row">
          <div class="small-12 columns">
               <input type="file" name="fotos" accept="image/*" >
          </div>
      </div>
     
  </div>-->
      <div class="content" id="panel5">

          
          <div style="width: 48%;float: left">

<?php
$res=$conex->query("select * from cn_catalogo");
?>
             
                  <label for="">cuenta contable
                      <input type="text" name="cc" id="cc" readonly="" required="" value="<?php echo $animales[cc] ?>">
                      
                  </label>
             
            
    
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
              <label for="">notas</label>  <textarea name="notas" id="" cols="100" rows="10">
                   <?php echo $animales[notas]?> 
              </textarea>
                 <input type="submit" value="actualizar registro" class="button primary">
          </div>
      </div>
    
</div>         
      <input type="hidden" value="<?php echo $id ?>" name="id">
      <input type="hidden" value="<?php echo  $animales[nombre] ?>" name="nom_ant">
      <input type="hidden" value="<?php echo  $animales[numero] ?>" name="num_ant">
  </form>


</div>
</div>

<script>

    $(".table").footable();
    
    $('.table').on('click','.cuenta_id',function(e){
        e.preventDefault();
        $('#cc').val( $(this).html());
    });
    
      
      $("[name=fec_nac]").attr('readonly',true).datepicker( { dateFormat: "dd-mm-yy",changeYear: true,changeMonth:true});
      $("[name=fec_destete]").attr('readonly',true).datepicker({ dateFormat: "dd-mm-yy",changeYear: true,changeMonth:true});
           
      $("[name=concepcion]").on('change',function(){
          
          var valor=$(this).val();
          if(valor==='te' || valor==='fiv'){
              $("[name=donadora]").parent('label').fadeIn(1500);
          }
          else{
               $("[name=donadora]").parent('label').fadeOut(1500);
          }
                                               
      }).trigger('change');
      
      $("[name=sexo]").on('change',function(){
                var sexo =$(this).val();
      switch(sexo){
          case 'hembra':
              $("[name=parto]").parent('label').fadeIn(1500);
              $("[name=cir_escrotal]").parent('div').fadeOut(1500);
              //$('h5').next('h5').parent('div').fadeOut(1500);
              break;
              
            case 'macho':
                $("[name=parto]").parent('label').fadeOut(1500);
                $("[name=cir_escrotal]").parent('div').fadeIn(1500);
                break;
                                                 }
                            }).trigger('change');
    
  </script>
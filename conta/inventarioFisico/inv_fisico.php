<?php 
include '../../plantilla.php';
$res=$conex->query('select * from bodega');
$productos=$conex->query('select * from productos');
$htmlsel="<option value=''>seleccione</option>";
while($fila=$res->fetch()){
  $htmlsel.="<option value='$fila[codigo]'>$fila[nombre]</option>";
}
if(isset($_SESSION[inv_fisico])){  unset($_SESSION[inv_fisico]); }
?>
<div class="small-12 columns"> 
    <h2>inventario fisico</h2>
    <div class="row">
        <div class="small-2 columns">

            <form action=""  >
                <label>fecha
                    <input type="text" name="fecha">
                </label>
                <label>bodega
                    <select name="bodega">
                        <?php echo $htmlsel ?>
                    </select>   
                </label>
                <input type="submit" value="crear" class="button primary" name="envia">
            </form>
        </div>
        <div class="small-10 columns" id="tabs">
            <ul class="tabs" data-tab>
  <li class="tab-title active"><a href="#panel1">realizar conteo</a></li>
  <li class="tab-title"><a href="#panel2">ajustes de diferencias</a></li>
  <li class="tab-title"><a href="#panel3">Tab 3</a></li>
  <li class="tab-title"><a href="#panel4">Tab 4</a></li>
</ul>
<div class="tabs-content">
  <div class="content active" id="panel1">
      <div class="row">
          <div class="small-3 columns">
              codigo producto
              <select name="cod_prod" id="referencia">
                  <option value="">seleccione</option>
                  <?php
                  while($fila=$productos->fetch()){
                      echo "<option value='$fila[referencia]' data-unidad='$fila[unidad_standar]'>$fila[nombre]</option>";
                  }
                  ?>
              </select>
          </div>
          <div class="small-3 columns">
              unidad <select id="unidad"><option value="">seleccione</option></select>
          </div>
               <div class="small-3 columns">
                   cantidad<input type="text" id="cantidad">
          </div>
          <div class="small-3 columns">
              <button type="button" id="add">add</button>
          </div>
      </div>
      <div class="row">
            <div class="small-12 columns">
                <table width="100%" id="tabla">
                    <thead>
                        <tr>
                            <th width="400">producto</th>

                            <th width="100">precio promedio</th>
                            <th width="50">unidad</th>
                            <th width="50">cantidad</th>
                            <th width="50">eliminar</th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <button type="button" id="aplicar">aplicar</button>
            </div>
      </div>
      
  </div>
  <div class="content" id="panel2">
    <p>ajustes de diferencias</p>
  </div>
  <div class="content" id="panel3">
    <p>This is the third panel of the basic tab example. This is the third panel of the basic tab example.</p>
  </div>
  <div class="content" id="panel4">
    <p>This is the fourth panel of the basic tab example. This is the fourth panel of the basic tab example.</p>
  </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#referencia').select2();
    $('#tabs').hide();
    $('[name=fecha]').datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",
      changeYear: true});
  
    $('[name=bodega]').on('change',function(){
      bod=$(this).val();
    });
    
    $('[name=envia]').on('click',function(e){
        e.preventDefault();
        bod_id=$('[name=bodega]').val();
        fecha=$('[name=fecha]').val();
        $.ajax({
            url:'ajax/crea_inv_fisico_enc.php',
            data:{bod_id:bod_id,fecha:fecha,usuario_id:'<?php echo   $_SESSION[id_usuario] ?>'},
            success:function(data){
                if(data==='true'){
                    $('[name=envia]').attr('disabled',true);
                    $('[name=bodega]').attr('disabled',true);
                    $('[name=fecha]').attr('disabled',true);
                    $('#tabs').show();
                }
            }
            
        });
        
    });
    
        $('#referencia').on('change',function(){        
        unidad=$('#unidad');
        switch($(this).find('option:selected').attr('data-unidad')){
            case 'kg':
                unidad.html("<option value=''>seleccione</option>"+ "<option value='qq'>quintal</option>"        + "<option value='g'>gramos</option>"        + "<option value='kg'>kilogramos</option>"        +"<option value='oz'>onzas</option>"        + "<option value='lb'>libras</option>");
                break;
            case 'lt':
                unidad.html("<option value=''>seleccione</option>"+  "<option value='lt'>litros</option>"+      "<option value='ml'>mililitros</option>");
                break;
            case 'cc':
                unidad.html("<option value='cc'>cc</option>");
                break;
            case 'unidad':
                unidad.html("<option value='unidad'>unidad</option>");
                break;
        }
    });
    
    $('#add').on('click',function(){        
        unidad=$('#unidad').val();
        ref=$('#referencia').val();
        cant=$('#cantidad').val();
        if(unidad==='' || ref==='' || cant===''){
            alert('campos vacios');
            return false;
        }
        $.ajax({
            url:'ajax/add_producto.php',
            data:{unidad:unidad,ref:ref,cant:cant},
            dataType:'json',
            success:function(data){
                     lineas='   <thead>         <tr> <th>referencia</th>     <th>precio promedio</th>    <th>unidad</th> <th>cantidad</th> <th>eliminar</th>   </tr>    </thead>';
                _.each(data,function(v,k,l){
                    lineas+="<tr><td>"+v.nombre+"</td><td>"+v.precio_prom+"</td><td>"+v.unidad_elegida+"</td><td>"+v.cant+"</td><td><a href='#' class='eliminar' data-prod_id='"+k+"'>eliminar</a></td></tr>";
                    
                });
           $('#tabla').html(lineas);
            }
        });
    });
    
        $('#tabla').on('click','a.eliminar',function(e){
        e.preventDefault();
       x=$(this).attr('data-prod_id');
       $.ajax({
             url:'ajax/del_producto.php',
            data:{id_prod:x},
            dataType:'json',
             success:function(data){
                lineas='   <thead>         <tr> <th>referencia</th>     <th>precio promedio</th>    <th>unidad</th> <th>cantidad</th> <th>eliminar</th>   </tr>    </thead>';
                _.each(data,function(v,k,l){
                    lineas+="<tr><td>"+v.nombre+"</td><td>"+v.precio_prom+"</td><td>"+v.unidad_elegida+"</td><td>"+v.cant+"</td><td><a href='#' class='eliminar' data-prod_id='"+k+"'>eliminar</a></td></tr>";
                    
                });
           $('#tabla').html(lineas);
            }
       });
    });
    
    $('#aplicar').on('click',function(){
    $.ajax({
        url:'ajax/aplicacion_inv_fisico.php',
        data:{bod_id:$('[name=bodega]').val()},
        success:function(){
            //window.location.reload();
        }
        });
    });
</script>

<!--inventario_fisico_enc
    id
    fecha
    bodega_id
    usuario_id
    estatus
    fecha_diferencias_aplicadas
    fecha_ajustes_aplicados
    fecha_hora
                        bloqueada->tabla bodega
inventario_fisico_lns
    id
    bodega_id
    producto_id   
    existencia--cantidad teorica
    cantidad--cantidad real
    costo
    commentario ajuste
    cantidad_primera_aplicacion    
    enc_id
    -->
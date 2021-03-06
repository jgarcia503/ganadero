<?php 
include '../../plantilla.php';
$id_enc=$_GET[id];
$res_enc=$conex->query("select * from inventario_fisico_enc where id=$id_enc and en_proceso='true'")->fetchAll(PDO::FETCH_ASSOC)[0];

if(count($res_enc)===0){
         echo "<script>window.location='buscador_inv_fisico.php'</script>";
        //echo "<script>window.location='/ganadero/compras/compras.php'</script>";
}
$productos=$conex->query('select * from productos');
//$htmlsel="<option value=''>seleccione</option>";
//while($fila=$res->fetch()){
//  $htmlsel.="<option value='$fila[codigo]'>$fila[nombre]</option>";
//}
###########################
$prods="<option value=''>seleccione</option>";
while($fila=$productos->fetch()){
  $prods.="<option value='$fila[referencia]' data-unidad='$fila[unidad_standar]'>$fila[nombre]</option>";
  }
if(isset($_SESSION[inv_fisico])){  unset($_SESSION[inv_fisico]); }
?>
<div class="small-12 columns"> 
    <h2>inventario fisico</h2>
    <div class="row">
<!--        <div class="small-2 columns">

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
        </div>-->
        <div class="small-10 columns" id="tabs">
            <ul class="tabs" data-tab>
  <li class="tab-title active"><a href="#panel1">realizar conteo</a></li>
  <li class="tab-title"><a href="#panel2">ajustes de diferencias</a></li>
  <li class="tab-title"><a href="#panel3">reporte de diferencia</a></li>
  
</ul>
<div class="tabs-content">
  <div class="content active" id="panel1">
      <div class="row">
          <div class="small-3 columns">
              codigo producto
              <select name="cod_prod" id="referencia">                 
                  <?php
                                echo $prods
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
              <button type="button" id="add" data-enc_id="<?php echo $id_enc?>" data-bod_id="<?php echo $res_enc[bodega_id]?>">add</button>
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
                            <th width="50">cantidad convertida</th>                            

                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            $prod_lns="select a.*,b.* from inventario_fisico_lns a join productos b on a.producto_id=b.referencia where a.enc_id=$id_enc";
                            $res_prods=$conex->query($prod_lns);
                            while($fila=$res_prods->fetch(PDO::FETCH_ASSOC)){
                                echo "<tr>";
                                echo "<td>";
                                echo $fila[nombre];
                                echo "</td>";
                                echo "<td>";
                                echo $fila[costo];
                                echo "</td>";
                                echo "<td>";
                                echo $fila[unidad_standar];
                                echo "</td>";
                                echo "<td>";
                                echo $fila[cantidad_real];
                                echo "</td>";
                                echo "</tr>";
                                $_SESSION[inv_fisico][$fila[producto_id]]=array('nombre'=>$fila[nombre],'unidad_elegida'=>'kg','precio_prom'=>$fila[costo],'cant'=>$fila[cantidad_real]);
                            }
                                    ?>
                    </tbody>
                </table>
                <button type="button" id="aplicar">aplicar</button>
            </div>
      </div>
      
  </div>
  <div class="content" id="panel2">
      <div class="row">
          <div class="small-3 columns">
              codigo producto
              <select name="cod_prod" id="prod_id">                 
                  <?php
                                echo $prods
                  ?>
              </select>
          </div>
          <div class="small-3 columns">
              unidad <select id="unidad1"><option value="">seleccione</option></select>
          </div>
               <div class="small-3 columns">
                   cantidad<input type="text" id="cantidad1">
          </div>
               <div class="small-6 columns">
                   comentario ajuste<textarea id="coment_ajuste"></textarea>
          </div>
          <div class="small-3 end columns">
              <button type="button" id="add1" data-enc_id="<?php echo $id_enc?>" data-bod_id="<?php echo $res_enc[bodega_id]?>">add</button>
          </div>
      </div>
      </div>
  
  <div class="content" id="panel3">
      <table>
            <thead>
                        <tr>
                            <th width="400">producto</th>
                            <th width="100">cantidad teorica</th>
                            <th width="100">cantidad real</th>
                            <th width="100">unidad</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $sql_ajuste="select a.*,b.* from inventario_fisico_lns a join productos b on a.producto_id=b.referencia where a.enc_id=$id_enc";
                                $res_ajuste=$conex->query($sql_ajuste);
                                while($fila=$res_ajuste->fetch(PDO::FETCH_ASSOC)){
                                    echo "<tr>";
                                    echo "<td>";
                                    echo $fila[nombre];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $fila[cantidad_teorica];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $fila[cantidad_real];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $fila[unidad_standar];
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                    </tbody>
      </table>
    
  </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#referencia').select2();
    $('#prod_id').select2();
    //$('#tabs').hide();
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
            dataType:'json',
            success:function(data){
                if(_.has(data,'ok')){
                    $('#add').attr('data-enc_id',data.enc_id);
                    $('#add').attr('data-bod_id',bod_id);                    
                    ////////////////////////////////////////////////
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
    
        $('#prod_id').on('change',function(){        
        unidad=$('#unidad1');
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
        enc_id=$('#add').attr('data-enc_id');
        bod_id=$('#add').attr('data-bod_id');
        if(unidad==='' || ref==='' || cant===''){
            alert('campos vacios');
            return false;
        }
        $.ajax({
            url:'ajax/add_producto.php',
            data:{unidad:unidad,ref:ref,cant:cant,enc_id:enc_id,bod_id:bod_id},
            dataType:'json',
            success:function(data){
                     lineas='   <thead>         <tr> <th>referencia</th>     <th>precio promedio</th>    <th>unidad</th> <th>cantidad convertida</th>   </tr>    </thead>';
                _.each(data,function(v,k,l){
                    lineas+="<tr><td>"+v.nombre+"</td><td>"+v.precio_prom+"</td><td>"+v.unidad_elegida+"</td><td>"+v.cant+"</td></tr>";
                    
                });
           $('#tabla').html(lineas);
            }
        });
    });
    
        $('#add1').on('click',function(){        
        unidad=$('#unidad1').val();
        ref=$('#prod_id').val();
        cant=$('#cantidad1').val();
        enc_id=$('#add').attr('data-enc_id');
        bod_id=$('#add').attr('data-bod_id');
        coment_ajuste=$('#coment_ajuste').val();
        if(unidad==='' || ref==='' || cant===''){
            alert('campos vacios');
            return false;
        }
        $.ajax({
            url:'ajax/ajuste_diferencia.php',
            data:{unidad:unidad,ref:ref,cant:cant,enc_id:enc_id,bod_id:bod_id,coment_ajuste:coment_ajuste},            
            success:function(){                     
                window.location.reload();
//                    $('#coment_ajuste').val('');
//                    $('#unidad1').val('');
//                    $('#prod_id').val('');
//                    $('#cantidad1').val('');    
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
        data:{enc_id:$('#add').attr('data-enc_id'),fecha:'<?php echo $res_enc[fecha]?>'},
        success:function(){
            window.location.href='buscador_inv_fisico.php';
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
<?php   include '../plantilla.php';
$id=$_GET[id];
$res=$conex->query("select a.producto_id, b.nombre ,a.cantidad,a.unidad from plantilla_servicios_requisicion_lns a join productos b 
on b.referencia=a.producto_id
  where enc_id='$id'");
if(isset($_SESSION[productos_servicios])){  unset($_SESSION[productos_servicios]); }
while($fila=$res->fetch(PDO::FETCH_ASSOC)){
$_SESSION[productos_servicios][$fila[producto_id]]=   array('nombre'=>$fila[nombre],'cantidad'=>$fila[cantidad],'unidad'=>$fila[unidad]);
}

?>
<div class="small-12 columns">
    <h2>plantilla requisiciones servicios</h2>
    <a href="plantilla_productos.php" class="regresar">regresar</a>
    <span id="mensaje"></span>
    <input type="hidden" value="<?php echo $id?>" name="id_enc">
<!--            <div class="row">             
        
        <div class="small-3 columns ">
            <label>fecha<input type="text" name="fecha"></label>
         
        </div>
                <div class="small-3 columns ">
            <label>tipo
                <select name="tipo">
                  <option value="">seleccionar</option>
        <?php
//        while($fila=$cat_servicio->fetch()){
//            echo "<option value='$fila[id]'>$fila[nombre] </option>";
//        }
        ?>
                </select>
                
            </label>
         
        </div>
                   <div class="small-3 columns end ">
            <label>empleado
                <select name="empleado">
                    <option value="">seleccione</option>
                    <?php
//                    $empleado="select * from contactos where tipo='empleado'";
//                    $resemp=$conex->query($empleado);
//                    while($fila=$resemp->fetch()){
//                        echo "<option value='$fila[usuario]'>$fila[nombre]</option>";
//                    }
                        ?>
                </select>
            </label>
         
        </div>
        </div>-->
                
                <div class="row">
                <div class="small-3 columns">
                    <label>referencia
                        <select id="referencia" >
                            <option value="">seleccione</option>
                            <?php
                            $sql="select * from productos";
                            $res=$conex->query($sql);
                            while($fila=$res->fetch()){
                                echo "<option value='$fila[referencia]' data-unidad='$fila[unidad_standar]'>$fila[nombre]</option>";
                            }
                                ?>
                        </select>
                    </label>

                </div>

                <div class="small-3 columns">
                    <label>cantidad<input type="text" id="cantidad" ></label>

                </div>
                <div class="small-3 columns">
                    <label>unidad
                        <select id="unidad">
                           
                        </select>
                    </label>

                </div>
                <div class="small-3 columns">
                    <button id="add" >add</button>

                </div>
                </div>
                
        <div class="row">
        <div class="small-12 columns">
                            <table id="tabla" width='100%'>
                                <thead>
                                <tr>
                                    <th>referencia</th>
                                    <th>cantidad</th>
                                    <th>unidad</th>
                                    <th>eliminar</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                                                    foreach ($_SESSION[productos_servicios] as $k=>$v){
                                                                        echo "<tr><td>$v[nombre]</td><td>$v[cantidad]</td><td>$v[unidad]</td><td><a href='#' class='eliminar' data-prod_id='$k'>eliminar</a></td></tr>";
                                                                    }
                                            ?>
                                </tbody>
                            </table>    
        </div>
        </div>
<div class="row">
    <div class="small-3 columns end">
        <button type="submit" id="envia">crear registro</button>
        </div>
        </div>
    </div>

</div>
<script>
    $('[name=fecha]').datepicker({ dateFormat: "dd-mm-yy"    ,  changeMonth: true, yearRange: "2000:2050",changeYear: true});
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
    
//    $('#tblAppendGrid').appendGrid({
//        
//        initRows: 0,
//        idPrefix: 'linea',
//        columns: [
//            { name: 'nombre', display: 'nombre', type: 'text', ctrlAttr: { readonly: true },ctrlCss: { width: '450px'} },
//            { name: 'cantidad', display: 'cantidad', type: 'text', ctrlAttr: { readonly: true },ctrlCss: { width: '150px'} },
//            { name: 'unidad', display: 'unidad', type: 'text', ctrlAttr: { readonly: true }, ctrlCss: { width: '150px'} },            
//            { name: 'id_producto', type: 'hidden', value: 0 }
//        ],
//      hideButtons: {
//            moveDown:true,
//            removeLast: true,
//            moveUp:true,
//            insert:true,
//            remove:true,
//            append:true
//        }
//    });
            productos_list=[];

    $('#add').on('click',function(e){
        
        e.preventDefault();
    
        cant=$('#cantidad');
        unidad=$('#unidad');
        ref=$('#referencia');
        id_enc=$("[name=id_enc]").val();
        
        $.ajax({
            url:'ajax/sesion_lineas_productos_servicios.php',
            data:{id_prod:ref.val(),cant:cant.val(),unidad:unidad.val(),id_enc:id_enc,nombre:ref.find('option:selected').html()},
            dataType:'json',
            success:function(data){
                lineas='   <thead>         <tr> <th>referencia</th>     <th>cantidad</th>    <th>unidad</th> <th>eliminar</th>   </tr>    </thead>';
                _.each(data,function(v,k,l){
                    lineas+="<tr><td>"+v.nombre+"</td><td>"+v.cantidad+"</td><td>"+v.unidad+"</td><td><a href='#' class='eliminar' data-prod_id='"+k+"'>eliminar</a></td></tr>";
                    
                });
           $('#tabla').html(lineas);
            }
        });
    });
    
    $('#tabla').on('click','a.eliminar',function(e){
        e.preventDefault();
       x=$(this).attr('data-prod_id');
       $.ajax({
             url:'ajax/sesion_lineas_productos_servicios.php',
            data:{id_prod:x,remover:true,procesar:false},
            dataType:'json',
             success:function(data){
                lineas='   <thead>         <tr> <th>referencia</th>     <th>cantidad</th>    <th>unidad</th> <th>eliminar</th>   </tr>    </thead>';
                _.each(data,function(v,k,l){
                    lineas+="<tr><td>"+v.nombre+"</td><td>"+v.cantidad+"</td><td>"+v.unidad+"</td><td><a href='#' class='eliminar' data-prod_id='"+k+"'>eliminar</a></td></tr>";
                    
                });
           $('#tabla').html(lineas);
            }
       });
    });
    
    $('#envia').on('click',function(e){
        e.preventDefault();
        $.ajax({
             url:'ajax/sesion_lineas_productos_servicios.php',
            data:{id_enc:$('[name=id_enc]').val()},
            type:'post',
            success :function(data){
                alert('exito');
                setTimeout(function(){
                    window.location.reload()
                },1000);
                
            }
        });
    });
</script>
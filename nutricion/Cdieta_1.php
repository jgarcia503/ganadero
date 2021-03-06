<?php   include '../plantilla.php';

?>
<div class="small-12 columns">
    <h2>crear dieta</h2>
    <a href="dietas.php" class="regresar">regresar</a>
    <span id="mensaje"></span>
    
            <div class="row">             
        
        <div class="small-3 columns ">
            <label>fecha<input type="text" name="fecha"></label>
         
        </div>
                <div class="small-3 columns ">
            <label>nombre dieta<input type="text" name="nombre"></label>
         
        </div>
                   <div class="small-3 columns end ">
            <label>empleado
                <select name="empleado">
                    <?php
                    $empleado="select * from contactos where tipo='empleado'";
                    $resemp=$conex->query($empleado);
                    while($fila=$resemp->fetch()){
                        echo "<option value='$fila[usuario]'>$fila[nombre]</option>";
                    }
                        ?>
                </select>
            </label>
         
        </div>
        </div>
                
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
                            <table id="tblAppendGrid">
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
        
                switch($(this).find('option:selected').attr('data-unidad')){
                                    case 'kg':                
                                    case 'lt':                                
                                   case 'cc':                
                $("#cantidad").mask('000,000,000,000,000.00', {reverse: true});
                break;
                                    case 'unidad':
                $('#cantidad').mask('00000000');
                break;
                }
    });
    
    $('#tblAppendGrid').appendGrid({
        
        initRows: 0,
        idPrefix: 'linea',
        columns: [
            { name: 'nombre', display: 'nombre', type: 'text', ctrlAttr: { readonly: true },ctrlCss: { width: '450px'} },
            { name: 'cantidad', display: 'cantidad', type: 'text', ctrlAttr: { readonly: true },ctrlCss: { width: '150px'} },
            { name: 'unidad', display: 'unidad', type: 'text', ctrlAttr: { readonly: true }, ctrlCss: { width: '150px'} },            
            { name: 'id_producto', type: 'hidden', value: 0 }
        ],
      hideButtons: {
            moveDown:true,
            removeLast: true,
            moveUp:true,
            insert:true,
            remove:true,
            append:true
        }
    });
        productos_list=[];

    $('#add').on('click',function(e){
        
        e.preventDefault();
    
        cant=$('#cantidad');
        unidad=$('#unidad');
        ref=$('#referencia');
        if(cant.val()!=='' && unidad.val()!=='' && ref.val()!==''){
            if(_.indexOf(productos_list,ref.val()) === -1){
                     f_ret=$('#tblAppendGrid').appendGrid('appendRow', [   { nombre: ref.find('option:selected').html(), cantidad: cant.val(), unidad: unidad.val(),id_producto: ref.val() }    ]);
                     productos_list.push(ref.val());
                 }else{
                     
                 }
        }else{
            alert('complete todos los campos');
        }
    });
    
    $('#envia').on('click',function(e){
        e.preventDefault();
        datos={};
        datos.fecha=$('[name=fecha]').val();
        datos.empleado=$('[name=empleado]').val();
        datos.nombre=$('[name=nombre]').val();
        datos.lineas=$('#tblAppendGrid').appendGrid('getAllValue');
        $.ajax({
            url:'ajax/crea_dieta_1.php',
            data:datos,
            success :function(data){
                $('#mensaje').html(data);
                setTimeout(function(){
                    window.location.reload()
                },1000);
                
            }
        });
    });
</script>


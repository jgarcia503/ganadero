                  $(document).on('ready',inicio);
          
          
        function  inicio(){
                            setear_vals();
                    $('.flexdatalist').flexdatalist({minLength: 1, searchContain: true, focusFirstResult: true});
                    $('#envia').on('click', bot_envia);
        } 
        
        function setear_vals(){
                    $(".fecha").attr('readonly', true).datepicker({dateFormat: "dd-mm-yy"});


                    $('#tblAppendGrid').appendGrid({
                        caption: 'actividades',
                        initRows: 1,
                        columns: [
                            {name: 'actividad', display: 'actividad', type: 'text', ctrlAttr: {maxlength: 100, required: true}, ctrlCss: {width: '90%'}},
                            {name: 'tipo', display: 'tipo', type: 'select', ctrlOptions: {seleccione: '', trabajo: 'trabajo', material: 'material'}, ctrlCss: {width: '90%'}},
                            {name: 'costo', display: 'costo', type: 'text', ctrlAttr: {maxlength: 10}, ctrlCss: {width: '100px', 'text-align': 'right'}}
                        ]
                    });
}
        
function bot_envia() {
                var valido=true;
                var nombre=$('#nombre').val();
                var fecha_inicio=$('#fecha_inicio').val();
                var fecha_fin=$('#fecha_fin').val();
                var potrero=$('#potrero').val();
                var tipo_cultivo=$('#tipo_cultivo').val();
                var   datos={};
                
                if (nombre === '') {
                    $('#nombre').notify('nombre de etapa', {className: 'info', autoHideDelay: 1500});
                    return;
                }else{
                    datos.nombre=nombre;
                }

                if (potrero === '') {
                    $('#potrero').notify('escriba nombre de potrero', {className: 'info', autoHideDelay: 1500});
                    return;
                }else{
                    datos.potrero=potrero;
                }
                
                if (tipo_cultivo === '') {
                    $('#tipo_cultivo').notify('seleccione tipo de cultivo', {className: 'info', autoHideDelay: 1500});
                    return;
                }else{
                    datos.tipo_cultivo=tipo_cultivo;
                }

                if (fecha_inicio === '') {
                    $('#fecha_inicio').notify('elija fecha', {className: 'info', autoHideDelay: 1500});
                    return;
                }else{
                    datos.fecha_inicio=fecha_inicio;
                }


                if (fecha_fin ==='') {
                    $('#fecha_fin').notify('elija fecha', {className: 'info', autoHideDelay: 1500});
                    return;
                }else{
                    datos.fecha_fin=fecha_fin;
                }


//                $.each($('#tblAppendGrid tbody input,select'), function (index, elem) {
//
//                    if (elem.value === '') {
//
//                        if (elem.name.includes('costo')) {
//                            $(elem).notify("ingrese un costo", {className: 'info', autoHideDelay: 1500});
//                            valido=false;
//
//                        } else {
//                            $(elem).notify("ingrese una actividad", {className: 'info', autoHideDelay: 1500});
//                            valido=false;
//                        }
//
//                    }else{
//                                    
//                      
//                    }
//
//                    if (elem.value === 'seleccione') {
//                        $(elem).notify("seleccione tipo", {className: 'info', autoHideDelay: 1500});
//                        valido=false;
//                    }
//                        
//                });


      $('#tblAppendGrid').appendGrid('removeEmptyRows');
                
                          var lineas = $('#tblAppendGrid').appendGrid('getAllValue',true);
                          lineas=_.without(lineas,'_RowCount');
                          datos.lineas=lineas;
                            $.each(lineas,function (index,elem){
                                if(lineas[index]==''){
                                     $(elem).notify("seleccione tipo", {className: 'info', autoHideDelay: 1500});
                                }
                                console.log(lineas[index]);
                            });
//                $.ajax({
//                url:'CptierraAjax.php',
//                method:'post',
//                data:datos,
//                    success: function (data) {
//                        console.dir(lineas);
//                    }
//            });
    
}
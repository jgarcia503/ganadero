<?php   include '../plantilla.php'; ?>

<script>
$(document).on('ready',function(){
    $(".table").footable();
    $(".cuenta_id").on('click',function(e){
        //e.preventDefault();
       alert( $("#"+$(this).html()).val());
        
    });
    
    $("#nivel_id").on('change',function(){
         $('#cuenta').val('');
         $('#sumariza').val('');
 var nivel_id = $('#nivel_id option:selected').val();

 switch(nivel_id){
     case '1':
         $('#cuenta').attr('maxlength','1');
         break;
              case '2':
         $('#cuenta').attr('maxlength','2');
         break;
              case '3':
         $('#cuenta').attr('maxlength','4');
         break;
              case '4':
         $('#cuenta').attr('maxlength','6');
         break;
              case '5':
         $('#cuenta').attr('maxlength','8');
         break;          
              case '6':
         $('#cuenta').attr('maxlength','10');
         break;
              case '7':
         $('#cuenta').attr('maxlength','12');
         break;         
        }

    });
    
    $("#cuenta").on('blur',function(){
        if($(this).val().length <  $(this).attr('maxlength')){$(this).blur();}
        var x=$('#cuenta').val();
        if(x.length==1 || x.length==2){  $("#sumariza").val(x.substr(0,1));}
        
        if(x.length==4){  $("#sumariza").val(x.substr(0,2));}
        if(x.length==6){  $("#sumariza").val(x.substr(0,4));}
        if(x.length==8){  $("#sumariza").val(x.substr(0,6));}
        if(x.length==10){  $("#sumariza").val(x.substr(0,8));}
        if(x.length==12){  $("#sumariza").val(x.substr(0,10));}
        
    });
    //finaliza ready
});

</script>
<div style="width: 48%;float: left">

<?php
$res=$conex->query("select * from cn_catalogo");
?>


    
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
                    <a href="javascript:void(0)" class="cuenta_id"><?php  echo $fila[cuenta_id]?></a>
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
<!--    <div style="width: 48%; float: right">
        <form action="" method="post">
            <select id="nivel_id" class=""  name="nivel_id">
<option value="">- Seleccione el Nivel de Cuenta -</option>
<option value="1">NIVEL 1 RUBRO</option>
<option value="2">NIVEL 2 SUB RUBRO</option>
<option value="3">NIVEL 3 CUENTA DE MAYOR</option>
<option value="4">NIVEL 4 SUB CUENTA DE MAYOR</option>
<option value="5">NIVEL 5 CUENTA DE DETALLE</option>
<option value="6">NIVEL 6 SUB CUENTA DE DETALLE</option>
<option value="7">NIVEL 7 SUB SUB CUENTA DE DETALLE</option>
</select>
            <label for="">cuenta</label>
            <input type="text" name="cuenta"  id="cuenta">
            <label for="">sumariza</label>
            <input type="text" name="sumariza" id="sumariza" readonly="">
            <label for="">descripcion</label>
            <input type="text" name="descripcion">
            <label for="">posteable</label>
            <input type="checkbox" name="posteable">
            <label for="">acceso manual</label>
            <input type="checkbox" name="manual">
            <input type="submit" value="crear" class="button">
        </form>

</div>-->
<?php
if($_POST){
    
    var_dump($_POST);
}
?>


</div>
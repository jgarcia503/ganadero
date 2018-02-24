<?php    include '../plantilla.php'; ?>

<div class="small-12 columns">
    <h2>admon animales</h2>

<!--<a href="Canimal.php" class="button primary">crear animal</a>-->


<?php
echo check_permiso($_SESSION[permisos][$_SERVER[REQUEST_URI]],'Canimal.php','crear animal');
$res=$conex->query("select *,to_char(current_date,'DD MM YYYY')::date  - (select fecha from partos where animal=numero||'-'||nombre order by fecha::date desc limit 1)::date dias_lactancia from animales order by nombre");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>numero</th>
			<th>nombre</th>
			<th>sexo</th>
			<th>estado</th>
			<th>registro</th>
			<th>color</th>
			<th>procedencia</th>
                                                                  <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[numero]?></td>
                <td><?php  echo $fila[nombre]?></td>
                <td><?php  echo $fila[sexo]?></td>
                <td><?php  echo $fila[estado]?></td>
                <td><?php  echo $fila[registro]?></td>
                <td><?php  echo $fila[color]?></td>       
                <td><?php  echo $fila[procedencia]?></td>
                <td>
                    <a href="#" class="ver" data-id="<?php  echo base64_encode( $fila[id]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <?php echo check_permiso_for_update($_SESSION[permisos][$_SERVER[REQUEST_URI]], 'Uanimal.php', base64_encode($fila[id]),"target='_blank'") ?>
                    <!--<a href="Uanimal.php?<?php  echo  base64_encode( $fila[id])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->                    
                    <a href="Danimal.php?<?php  echo  base64_encode('animal='. $fila[id])?>" id="eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
            
    <?php
}
?>	

	</tbody>
</table>

</div>


<div id="mimodal" class="reveal-modal" data-reveal>
    <span>
        
            <img src="">
       
            <ul class="tabs" data-tab>
                <li class="tab-title active"><a href="#panel1">datos generales</a></li>
                <li class="tab-title"><a href="#panel2">genealogia</a></li>
                <li class="tab-title"><a href="#panel3">fenotipo</a></li>

            </ul>
            <div class="tabs-content">
                <div class="content active" id="panel1">
         
                </div>
                <div class="content" id="panel2">

                </div>
                <div class="content" id="panel3">

                </div>

            </div>
        <span></span>
    </span>

  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

</div>

<script>

    ////////////////////////////ver/////////////////////
    $(".table").on('click','a.ver',function(e){
        e.preventDefault();        
        $.ajax({
            url:"Ranimal.php?"+$(this).data('id'),
            success:function (datos){         
                
                //console.log(datos.split('|')[0].substr(datos.split('|')[0].indexOf('=')+1,datos.split('|')[0].indexOf('>')-1) );
                   //$('#mimodal span').html(datos);
                                    $('#mimodal span img').attr('src','../img_animales/'+datos.split('|')[0]);                                    
                                    $('#mimodal #panel1').html(datos.split('|')[1]);
                                    $('#mimodal #panel2').html(datos.split('|')[2]);
                                    $('#mimodal #panel3').html(datos.split('|')[3]);
                                    $('#mimodal span span').html(datos.split('|')[4]);
                   
            }
        });

     
        $('#mimodal').foundation('reveal', 'open');

    });
////////////////////////////ELIMINAR///////////////////    
    $("a#eliminar").on('click',function(e){
        
        e.preventDefault();
       if( confirm("desea eliminar?")){
           window.location=$(this).attr('href');
       }

    });

    $(".table").footable();   
</script>

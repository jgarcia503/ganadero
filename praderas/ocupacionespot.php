<?php   include '../plantilla.php'; ?>

<h2>admon ocupaciones potreros</h2>

<a href="Cocupacionespotreros.php" class="button primary">crear ocupaciones potreros</a>


<?php
$res=$conex->query("select * from contactos");
?>

<table class="table" data-filtering='true' data-paging="true">
	<thead>
		<tr>
			<th>ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Job Title</th>
			<th>Started On</th>
			<th>Date of Birth</th>
                        <th data-filterable="false"></th>
		</tr>
	</thead>
	<tbody>
<?php
while($fila=$res->fetch()){
    
    
    ?>
            <tr>
                <td><?php  echo $fila[id]?></td>
                <td><?php  echo $fila[identificacion]?></td>
                <td><?php  echo $fila[tipo]?></td>
                <td><?php  echo $fila[usuario]?></td>
                <td><?php  echo $fila[haciendas]?></td>
                <td><?php  echo $fila[telefonos]?></td>
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
<script>
    $(".table").footable();
        $("a#eliminar").on('click',function(e){
        
        e.preventDefault();
       if( confirm("desea eliminar?")){
           window.location=$(this).attr('href');
       }
    });

</script>
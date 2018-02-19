<?php
session_start();
include '../../conexion.php';
extract($_GET);
$sql_delete="delete from traslados_lns where enc_id='$id_enc' and producto='$ref'";

$conex->prepare($sql_delete)->execute();
unset($_SESSION['traslado_lns'][$ref]);
//echo $sql_delete;
echo json_encode($_SESSION['traslado_lns']);

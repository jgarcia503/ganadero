<?php
session_start();
include '../../conexion.php';
extract($_GET);
$prod_id=  explode('-', $ref)[0];
$sql_delete="delete from compras_lns where enc_id=$id_enc and referencia='$prod_id'";

$conex->prepare($sql_delete)->execute();
unset($_SESSION[lineas_fact][$ref]);

echo json_encode($_SESSION[lineas_fact]);

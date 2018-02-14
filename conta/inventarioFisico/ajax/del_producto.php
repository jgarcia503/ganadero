<?php
include '../../../conexion.php';
session_start();
extract($_GET);
    unset($_SESSION[inv_fisico][$id_prod]);
    
    echo json_encode($_SESSION[inv_fisico]);

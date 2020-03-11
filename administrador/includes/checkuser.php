<?php 

session_start(); 

if (!isset($_SESSION['type_user'])) {
    header('location: index.php'); //Redirige al inicio de sesion en caso de que no tengas la cookie
    exit;
}

?> 
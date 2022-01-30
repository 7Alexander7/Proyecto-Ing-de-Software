<?php

require ('./conexion.php');
error_reporting(E_ALL ^ E_NOTICE);

if (isset($_GET['login'])) {        
    session_start();
    $cedula = $_POST['cedula'];
    $clave = $_POST['clave'];
    $consulta = mysqli_query($enlace, "SELECT * FROM usuarios WHERE cedula='".$cedula."' AND clave='".$clave."'");
    while ($row = mysqli_fetch_assoc($consulta)) {
        if ($row['id']!="") {
            $_SESSION['cedula'] = $row['cedula'];
            echo "exito";
        } else if($row['id']=="") {
            echo "mal";
        }
    }
}

if (isset($_GET['verificarLogin'])){
    session_start();
    if ($_SESSION['cedula']!="" && isset($_SESSION)){
        echo "exito"; 
    }
    else{
        echo "mal";
    }
}

if (isset($_GET['cerrarSesion'])){
    session_start();
    session_destroy();
}
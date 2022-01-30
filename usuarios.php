<?php

require ('./conexion.php');
error_reporting(E_ALL ^ E_NOTICE);

if (isset($_GET['nuevoUsuario'])) {    
    $consulta = mysqli_query($enlace, "INSERT INTO usuarios(cedula,clave,privilegio) VALUES ('".$_POST['cedula']."','".$_POST['clave']."','".$_POST['estado']."')");
    if (mysqli_affected_rows($enlace) == "1") {
        echo "exito";
    }else{
        echo "mal";
    }
}

if (isset($_GET['listaUsuarios'])) {
    $consulta = mysqli_query($enlace, "SELECT * FROM usuarios");
    WHILE ($row = mysqli_fetch_assoc($consulta)) {        
        if($row['privilegio']==1){
            $row['privilegio'] = "Administrador";
        }else if($row['privilegio']==2){
            $row['privilegio'] = "Empleado";
        }
        $datos['data'][] = $row;
    }
    echo json_encode($datos);
}

if (isset($_GET['eliminarUsuario'])) {    
    $consulta = mysqli_query($enlace, "DELETE FROM usuarios WHERE id='".$_POST['id']."'");
    if (mysqli_affected_rows($enlace) == "1") {
        echo "exito";
    }else{
        echo "mal";
    }
}

if (isset($_GET['modificarUsuario'])) {    
    $consulta = mysqli_query($enlace, "UPDATE usuarios SET cedula='".$_POST['cedula']."', clave='".$_POST['clave']."', privilegio='".$_POST['privilegio']."' WHERE id='".$_POST['id']."'");
    if (mysqli_affected_rows($enlace) == "1") {
        echo "exito";
    }else{
        echo "mal";
    }
}
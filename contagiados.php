<?php

require ('./conexion.php');
error_reporting(E_ALL ^ E_NOTICE);

if (isset($_GET['nuevoContagiado'])) {    
    $consulta = mysqli_query($enlace, "INSERT INTO contagiados(nombres,apellidos,cedula,ciudad,fechaNacimiento,direccion,latitud,longitud,fechaInicio,dias) VALUES ('".$_POST['nombres']."','".$_POST['apellidos']."','".$_POST['cedula']."','".$_POST['ciudad']."','".$_POST['fechaNacimiento']."','".$_POST['direccion']."','".$_POST['latitud']."','".$_POST['longitud']."','".$_POST['fechaInicio']."','".$_POST['dias']."')");
    if (mysqli_affected_rows($enlace) == "1") {
        echo "exito";
    }else{
        echo "mal";
    }
}

if (isset($_GET['listaContagiados'])) {
    $consulta = mysqli_query($enlace, "SELECT
    contagiados.id,
    contagiados.nombres,
    contagiados.apellidos,
    contagiados.cedula,
    YEAR(NOW())-YEAR(contagiados.fechaNacimiento) as edad,
    contagiados.fechaNacimiento,
    contagiados.ciudad,
    contagiados.direccion,
    contagiados.fechaInicio,
    contagiados.dias,
    contagiados.latitud,
    contagiados.longitud
    FROM
    contagiados");
    WHILE ($row = mysqli_fetch_assoc($consulta)) {       
        $datos['data'][] = $row;
    }
    echo json_encode($datos);
}

if (isset($_GET['eliminarContagiado'])) {    
    $consulta = mysqli_query($enlace, "DELETE FROM contagiados WHERE id='".$_POST['id']."'");
    if (mysqli_affected_rows($enlace) == "1") {
        echo "exito";
    }else{
        echo "mal";
    }
}

if (isset($_GET['modificarContagiado'])) {    
    $consulta = mysqli_query($enlace, "UPDATE contagiados SET cedula='".$_POST['cedula']."', nombres='".$_POST['nombres']."', apellidos='".$_POST['apellidos']."', ciudad='".$_POST['ciudad']."', fechaNacimiento='".$_POST['fechaNacimiento']."', direccion='".$_POST['direccion']."', latitud='".$_POST['latitud']."', longitud='".$_POST['longitud']."', fechaInicio='".$_POST['fechaInicio']."', dias='".$_POST['dias']."' WHERE id='".$_POST['id']."'");
    if (mysqli_affected_rows($enlace) == "1") {
        echo "exito";
    }else{
        echo "mal";
    }
}

if (isset($_GET['ubicacionesObjeto'])) {    
    $consulta = mysqli_query($enlace, "SELECT * FROM contagiados");
    while($row=mysqli_fetch_assoc($consulta)){
        $row['nombre'] = $row['nombres']." ".$row['apellidos'];
        $datos[]=$row; 
    }   
    echo json_encode($datos);
}

if (isset($_GET['listaControldias'])) {
    $consulta = mysqli_query($enlace, "SELECT
    CONCAT_WS(' ',contagiados.nombres,contagiados.apellidos) as paciente,
    contagiados.fechaInicio,
    DATE_ADD(contagiados.fechaInicio, INTERVAL contagiados.dias DAY) as fechaFin,
    DAY(DATE_ADD(contagiados.fechaInicio, INTERVAL contagiados.dias DAY))-DAY(NOW()) as dias
    FROM
    contagiados");
    WHILE ($row = mysqli_fetch_assoc($consulta)) {       
        $datos['data'][] = $row;
    }
    echo json_encode($datos);
}
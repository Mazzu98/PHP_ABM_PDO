<?php

$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : '';
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$clave = isset($_POST['clave']) ? $_POST['clave'] : '';

$host = "localhost";
$user = "id16597207_mazzu";
$pass = "&5OIGZ#BA~tMb%}^";
$base = "id16597207_usuarios_test";

$con = @mysqli_connect($host, $user, $pass, $base);

if (!$con) {
    echo "No se pudo conectar a la base de datos";
    return;
}

switch ($opcion) {
    case 'LOGIN':
        $encontrado = false;
        $sql = "SELECT * FROM usuarios where correo = '$correo' AND clave = '$clave'";
        $rs = $con->query($sql);
        while ($row = $rs->fetch_object()){
            $user_arr[] = $row;
        }
        if(isset($user_arr)){
             if (true) {
                 $rs = $con->query("SELECT descripcion FROM perfiles WHERE id = " . $user_arr[0]->perfil);
                 $perfil = $rs->fetch_object();
                 echo $user_arr[0]->nombre . " " . $perfil->descripcion;
                 $encontrado = true;
                 break;
             }
        }
        
        if (!$encontrado) {
            echo "No se pudo loguear";
        }
        break;
    case 'MOSTRAR':
        $sql = "SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.perfil, perfiles.descripcion FROM usuarios INNER JOIN perfiles ON perfiles.id = usuarios.perfil where 1";
        $rs = $con->query($sql);
        while ($row = $rs->fetch_object()) {
            $usuarios[] = $row;
        }

        foreach ($usuarios as $usuario) {
            echo $usuario->id . " - " . $usuario->correo . " - " . $usuario->clave . " - " . $usuario->nombre . " - " . $usuario->perfil . " - " . $usuario->descripcion . "<br>";
        }
}

mysqli_close($con);

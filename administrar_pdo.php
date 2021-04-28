<?php

require_once ("AccesoDatos.php");
require_once ("usuario.php");

$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : '';
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$clave = isset($_POST['clave']) ? $_POST['clave'] : '';
$userJson = isset($_POST['OBJ_JSON']) ? $_POST['OBJ_JSON'] : '';
$id = isset($_POST['ID']) ? $_POST['ID'] : '';


try{

    switch($opcion){
        case 'LOGIN':
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            $query = $accesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.perfil, perfiles.descripcion FROM usuarios INNER JOIN perfiles ON perfiles.id = usuarios.perfil WHERE (correo = :correo AND clave = :clave)");
            $query->bindValue(':correo',$correo,PDO::PARAM_STR);
            $query->bindValue(':clave',$clave,PDO::PARAM_STR);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_INTO, new Usuario);

            foreach ($query as $usuario) {
                print_r($usuario->nombre . " - " . $usuario->descripcion);
            }
            break;

        case 'MOSTRAR':
            $query = Usuario::mostrarUsuarios();

            foreach ($query as $usuario) {
                print_r($usuario->MostrarDatos()."<br>");
            }
            break;
            
        case 'ALTA':
            if($userJson != ''){
                $newUser = json_decode($userJson);
                if(Usuario::agregarUsuario($newUser->correo,$newUser->clave,$newUser->nombre,$newUser->perfil)){
                    echo "Agregado correctamente";
                }
                else
                {
                    echo "No se pudo agregar";
                }
            }
            break;

        case 'MODIFICACION':
            if($userJson != '' && $id != ''){
                $newUser = json_decode($userJson);
                if(Usuario::modificarUsuario($id,$newUser->correo,$newUser->clave,$newUser->nombre,$newUser->perfil)){
                    echo "Modificado correctamente";
                }
                else
                {
                    echo "No se pudo modificar";
                }
            }
            break;
        case 'BAJA':
            if($id!=''){
                if(Usuario::eliminarUsuario($id)){
                    echo "Modificado correctamente";
                }
                else
                {
                    echo "No se pudo modificar";
                }
            }
            break;
    }


}
catch (PDOException $e){
    echo "Error " . $e->getMessage() . "<br/>";
}

/* try{
    $conStr = "mysql:host=$host; dbname=$base";
    $pdo = new PDO($conStr,$user,$pass);

    switch($opcion){
        case 'LOGIN':
            $query = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :correo AND clave = :clave");
            $query->bindValue(':correo',$correo,PDO::PARAM_STR);
            $query->bindValue(':clave',$clave,PDO::PARAM_INT);
            $query->execute();
            $obj = $query->fetchObject();
            if($obj){
               
                $query = $pdo->prepare("SELECT descripcion FROM perfiles WHERE id = :perfil");
                $query->bindValue(':perfil',$obj->perfil,PDO::PARAM_INT);
                $query->execute();
                $perfil = $query->fetchObject();
                echo $obj->nombre . " " . $perfil->descripcion;
                $encontrado = true;
                break;
            }
           if (!$encontrado) {
               echo "No se pudo loguear";
           } 
            break;

        case 'MOSTRAR':
            $query = $pdo->prepare("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.perfil, perfiles.descripcion FROM usuarios INNER JOIN perfiles ON perfiles.id = usuarios.perfil where 1");
            $query->execute();

            while ($fila = $query->fetchObject()) {
                $usuarios[] = $fila;
            }

            foreach ($usuarios as $usuario) {
                echo $usuario->id . " - " . $usuario->correo . " - " . $usuario->clave . " - " . $usuario->nombre . " - " . $usuario->perfil . " - " . $usuario->descripcion . "<br>";
            }
            break;
            
        case 'ALTA':

    }


}
catch (PDOException $e){
    echo "Error " . $e->getMessage() . "<br/>";
} */



//----------------------------------------------------------------------------------------

/* $con = @mysqli_connect($host, $user, $pass, $base);

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
 */
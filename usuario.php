<?php
require_once ("AccesoDatos.php");

class Usuario
{
    public $id;
    public $nombre;
    public $correo;
    public $clave;
    public $perfil;
    public $descripcion;

    public function MostrarDatos()
    {
            return $this->id." - ".$this->correo ." - ". $this->clave ." - ". $this->nombre ." - ". $this->descripcion;
    }

    public static function mostrarUsuarios(){
        try{
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            $query = $accesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.perfil, perfiles.descripcion FROM usuarios INNER JOIN perfiles ON perfiles.id = usuarios.perfil where 1");
            $query->execute();
            $query->setFetchMode(PDO::FETCH_INTO, new usuario);
        }
        catch (Exception $e)
        {
            
        }

        return $query;
    }
    
    public static function agregarUsuario($correo,$clave,$nombre,$perfil){
        $retValue = true;
        try{
            $conex = AccesoDatos::DameUnObjetoAcceso();
            $query = $conex->RetornarConsulta("INSERT INTO usuarios (correo,clave,nombre,perfil) VALUES (:correo, :clave, :nombre, :perfil)");
            $query->bindValue(':correo',$correo,PDO::PARAM_STR);
            $query->bindValue(':clave',$clave,PDO::PARAM_STR);
            $query->bindValue(':nombre',$nombre,PDO::PARAM_STR);
            $query->bindValue(':perfil',$perfil,PDO::PARAM_INT);
            if(!$query->execute()){
                $retValue = false;
            }

        }
        catch(Exception $e){
            $retValue = false;
        }

        return $retValue;
    }

    public static function modificarUsuario($id,$correo,$clave,$nombre,$perfil){
        $retValue = true;
        try{
            $conex = AccesoDatos::DameUnObjetoAcceso();
            $query = $conex->RetornarConsulta("UPDATE usuarios SET correo = :correo, clave = :clave, nombre = :nombre ,perfil = :perfil WHERE id = :id");
            $query->bindValue(':id',$id,PDO::PARAM_INT);
            $query->bindValue(':correo',$correo,PDO::PARAM_STR);
            $query->bindValue(':clave',$clave,PDO::PARAM_STR);
            $query->bindValue(':nombre',$nombre,PDO::PARAM_STR);
            $query->bindValue(':perfil',$perfil,PDO::PARAM_INT);
            if(!$query->execute()){
                $retValue = false;
            }
        }
        catch(Exception $e){
            $retValue = false;
        }
        return $retValue;
    }

    public static function eliminarUsuario($id){
        $retValue = true;
        try{
            $conex = AccesoDatos::DameUnObjetoAcceso();
            $query = $conex->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");
            $query->bindValue(':id',$id,PDO::PARAM_INT);
            if(!$query->execute()){
                $retValue = false;
            }
        }
        catch(Exception $e){
            $retValue = false;
        }
        return $retValue;
    }

}
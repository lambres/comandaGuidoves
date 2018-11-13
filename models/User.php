<?php
require_once 'AccesoDatos.php';

class User{

    public $id;
    public $user_name;
    public $password;
    public $role;
    public $created;
    public $updated;
    public $is_activated;

    public function new_user(){
        $role = $this->role;
        $pass = sha1($this->password);
        $created = date("j F, Y, g:i a");
        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into users (user_name, password, role, created, is_activated)values('$this->user_name','$pass','$this->role','$created','1')");
        $consulta->execute();
        
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
        
    }

    public static function update($user){
        $updated = date("j F, Y, g:i a");
        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();        
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE users set user_name=:name, role=:role, is_activated=:state, updated=:updated WHERE id=:id");
        $consulta->bindValue(':id', $user->id, PDO::PARAM_INT);
        $consulta->bindValue(':name', $user->user_name, PDO::PARAM_STR);
        $consulta->bindValue(':role', $user->role, PDO::PARAM_STR);
        $consulta->bindValue(':state', $user->is_activated, PDO::PARAM_INT);
        $consulta->bindValue(':updated', $updated, PDO::PARAM_STR);
        $consulta->execute();

        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function update_password($id, $password){
        $pass = sha1($this->password);
        $updated = date("j F, Y, g:i a");
        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();        
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE users set password=:password, updated=:updated WHERE id=:id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':password', $pass, PDO::PARAM_STR);
        $consulta->bindValue(':updated', $updated, PDO::PARAM_STR);
        
        return $consulta->execute();
    }

    public static function all(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT id, user_name, role, created, updated FROM users WHERE is_activated=:status ");
        $consulta->bindValue(':status', 1, PDO::PARAM_INT);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS,"User");
    }

    public static function find_by_id($id){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id, user_name, role, created, updated FROM empleado WHERE id=:id");
        $consulta->bindValue(':id',$id,PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS,"User");
    }




}



?>
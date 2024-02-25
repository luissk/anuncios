<?php 
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{
    
    public function registrarUsuario($datos, $hash, $codigou){
        $query = "insert into usuario(us_codusuario,us_email,us_pass,us_nombre_razon,idtipo_usuario,us_status,us_telefono) 
        values(?,?,?,?,?,?,?)";
        $this->db->query($query, [$codigou, $datos['email'], $hash, $datos['nombre'], 2, 1, $datos['telefono']]);

        return $this->db->insertID();
    }

    public function validarLogin($email){
        $query = "select idusuario, us_codusuario, us_email, us_pass, us_nombre_razon, idtipo_usuario from usuario where LOWER(us_email) = LOWER(?) and us_status = ?";
        $st = $this->db->query($query, [$email, 1]);

        return $st->getRowArray();
    }

    public function getUsuarioPorId($idusuario){
        $query = "select idusuario, us_codusuario, us_email, us_nombre_razon, us_ruc, us_telefono, us_avatar, idtipo_usuario from usuario where idusuario = ?";
        $st = $this->db->query($query, [$idusuario]);

        return $st->getRowArray();
    }



    public function tiposDeUsuario(){
        $query = "select * from tipousuario where status=1";
        $st = $this->db->query($query);

        return $st->getResultArray();
    }

}
<?php 
namespace App\Models;

use CodeIgniter\Model;

class AnuncioModel extends Model{
    
    public function registrarUsuario($datos, $hash, $codigou){
        $query = "insert into usuario(us_codusuario,us_email,us_pass,us_nombre_razon,idtipo_usuario,us_status,us_telefono) 
        values(?,?,?,?,?,?,?)";
        $this->db->query($query, [$codigou, $datos['email'], $hash, $datos['nombre'], 2, 1, $datos['telefono']]);

        return $this->db->insertID();
    
    }

}
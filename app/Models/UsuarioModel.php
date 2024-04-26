<?php 
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{
    
    public function registrarUsuario($datos, $hash, $codigou){
        $query = "insert into usuario(us_codusuario,us_email,us_pass,us_nombre_razon,idtipo_usuario,us_status,us_telefono,us_linkact) 
        values(?,?,?,?,?,?,?,?)";
        $this->db->query($query, [$codigou, $datos['email'], $hash, $datos['nombre'], 2, 2, $datos['telefono'], $datos['linkact']]);

        return $this->db->insertID();
    }

    public function validarLogin($email){
        $query = "select idusuario, us_codusuario, us_email, us_pass, us_nombre_razon, idtipo_usuario, us_status from usuario where LOWER(us_email) = LOWER(?)";
        $st = $this->db->query($query, [$email]);

        return $st->getRowArray();
    }

    public function getUsuarioPorId($idusuario){
        $query = "select us.idusuario, us.us_codusuario, us.us_email, us.us_pass, us.us_nombre_razon, us.us_ruc, us.us_telefono, us.us_avatar, us.idtipo_usuario,
        us.us_whatsapp, us.us_website, us.us_facebook, us.us_instagram, us.us_tiktok, us.us_youtube, us.us_ubigeo, us.us_direccion,
        tu.tu_tipo, ub.iddepa, ub.idprov, ub.iddist
        from usuario us 
        inner join tipo_usuario tu on us.idtipo_usuario = tu.idtipo_usuario 
        left join ubigeo ub on us.us_ubigeo = ub.idubigeo
        where us.idusuario = ?";
        $st = $this->db->query($query, [$idusuario]);

        return $st->getRowArray();
    }

    public function modificarDatosUsuario($idusuario, $data){
        $query = "update usuario set us_nombre_razon = ?, us_ruc = ?, us_telefono= ?, us_pass = ?, us_whatsapp = ?, us_website = ?, us_facebook = ?, us_instagram = ?,
            us_youtube = ?, us_tiktok = ?, us_direccion = ?, us_ubigeo = ?, us_avatar = ? where idusuario = ? and us_status = 1";
        $st = $this->db->query($query, [$data['nombre'], $data['dniruc'], $data['telefono'], $data['password'], $data['whatsapp'], $data['web'], 
            $data['facebook'], $data['instagram'], $data['youtube'], $data['tiktok'], $data['direccion'], $data['ubigeo'], $data['ava_nombre'], $idusuario]);

        return $st;
    }

    public function eliminarAvatar($idusuario){
        $query = "update usuario set us_avatar = ? where idusuario = ? and us_status = 1";
        $st = $this->db->query($query,['', $idusuario]);

        return $st;
    }

    public function getUser_x_linkact($link){
        $query = "select idusuario, us_codusuario, us_email, us_pass, us_nombre_razon, idtipo_usuario, us_status from usuario where us_linkact = ?";
        $st = $this->db->query($query, [$link]);

        return $st->getRowArray();
    }

    public function activaCuenta_x_linkact($idusuario){
        $query = "update usuario set us_status = 1 where idusuario = ? and us_status = 2";
        $st = $this->db->query($query,[$idusuario]);

        return $st;
    }

    public function existeEmail($email){
        $query = "select idusuario, us_codusuario, us_email, us_pass, us_nombre_razon, idtipo_usuario, us_status, us_linkrecup from usuario where LOWER(us_email) = LOWER(?)";
        $st = $this->db->query($query, [$email]);

        return $st->getRowArray();
    }





    public function tiposDeUsuario(){
        $query = "select * from tipousuario where status=1";
        $st = $this->db->query($query);

        return $st->getResultArray();
    }

}
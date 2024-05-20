<?php 
namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model{
    
    public function listarAnuncios($estados = [2,4,5]){
        $query = "select anu.idanuncio, anu.an_nombre, anu.an_fechacreacion, anu.idusuario,
        anu.codanuncio, anu.an_status,
        DATEDIFF(anu.hastafecha, now()) diasactivo,
        anu.an_activo,anu.activadofecha, anu.hastafecha, anu.activousuario, anu.observadopor, anu.estado_ant, anu.levanta_obs,
        ean.estado,
        anu.iddestacado, des.tipo as tipodes, date_format(des.fechadesde, '%d/%m/%Y') as fechad_ini, date_format(des.fechahasta, '%d/%m/%Y') as fechad_fin, DATEDIFF(des.fechahasta, des.fechadesde) diasdestacado,
        DATEDIFF(des.fechahasta, now()) diasactivodestacado
        from anuncio anu
        inner join estados_anuncio ean on anu.an_status = ean.idestado 
        left join destacado des on anu.iddestacado=des.iddestacado
        where anu.an_status in ?";
        $st = $this->db->query($query, [$estados]);

        return $st->getResultArray();
    }

    /* public function cambiarEstadoAnuncioDestacado($idanuncio, $idestado){
        $query = "update anuncio set an_status = ?, iddestacado = NULL where idanuncio = ?";
        $st = $this->db->query($query, [$idestado, $idanuncio]);

        return $st;
    }

    public function cambiarEstadoDeDestacado($idanuncio, $iddestacado, $idestado){
        $query = "update destacado set estado = ? where iddestacado = ? and idanuncio = ?";
        $st = $this->db->query($query, [$idestado, $iddestacado, $idanuncio]);

        return $st;
    } */

}
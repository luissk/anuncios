<?php 
namespace App\Models;

use CodeIgniter\Model;

class UbigeoModel extends Model{
    
    public function listarProvincias($iddepa = 13){
        $query = "select DISTINCT(prov) as provincia, idprov from ubigeo where iddepa = ? and prov != '' order by prov";
        $st = $this->db->query($query, [$iddepa]);

        return $st->getResultArray();
    }

    public function listarDistritos($idprov, $iddepa = 13){
        $query = "select idubigeo, iddist, dist from ubigeo where iddepa = ? and idprov = ? and dist != '' order by dist";
        $st = $this->db->query($query, [$iddepa, $idprov]);

        return $st->getResultArray();
    }

    public function getUbigeo($iddist, $idprov, $iddepa = 13){
        $query = "select idubigeo, iddepa, idprov, iddist, lat, lng from ubigeo where iddepa = ? and idprov = ? and iddist = ?";
        $st = $this->db->query($query, [$iddepa, $idprov, $iddist]);

        return $st->getRowArray();
    }

    public function getUbigeo_x_Id($idubigeo){
        $query = "select idubigeo, iddepa, idprov, iddist, depa, prov, dist from ubigeo where idubigeo = ?";
        $st = $this->db->query($query, [$idubigeo]);

        return $st->getRowArray();
    }

    public function getUbigeo_x_Ubigeo($ubigeo, $iddepa = 13){
        $query = "select idubigeo, iddepa, idprov, iddist, depa, prov, dist from ubigeo where iddepa = ? and seotexto2 = ? and seotexto2 <> ''";
        $st = $this->db->query($query, [$iddepa, $ubigeo]);

        return $st->getRowArray();
    }

}
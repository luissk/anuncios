<?php 
namespace App\Models;

use CodeIgniter\Model;

class AnuncioModel extends Model{
    
    public function listarTipos(){
        $query = "select idtipo_anuncio, ta_tipo, ta_status from tipo_anuncio where ta_status = ?";
        $st = $this->db->query($query, [1]);

        return $st->getResultArray();    
    }

    public function listarCategorias(){
        $query = "select idcate, categoria, status from cat_anuncio where status = ?";
        $st = $this->db->query($query, [1]);

        return $st->getResultArray();  
    }

}
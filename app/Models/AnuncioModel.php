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
        $query = "select idcate, categoria, status from cat_anuncio where status = ? order by categoria";
        $st = $this->db->query($query, [1]);

        return $st->getResultArray();  
    }

    public function crearAnuncio($idusuario, $data){
        $query = "insert into anuncio(an_nombre,an_descripcion,idtipo_anuncio,idusuario,idcate,precio,precio_mostrar,caracteristicas,url_video,ubigeo,
        direccion,contact_email,contact_fono,contact_whatsapp,codanuncio,an_status,an_fechacreacion) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now())";

        $st = $this->db->query($query, [$data['nombre'],$data['descripcion'],$data['tipo'],$idusuario,$data['categoria'],$data['precio'],$data['nomostrar'],
            $data['caracteristicas'],$data['video'],$data['ubigeo'],$data['direccion'],$data['email'],$data['telefono'],$data['whatsapp'],$data['codanuncio'],1]);

        return $this->db->insertID();
    }

    public function insertarImagenes($idanuncio, $nombre_img, $nombre_img_thumb, $check_principal){
        $query = "insert into images(idanuncio,img,img_thumb,principal,status) values(?,?,?,?,?)";
        $st = $this->db->query($query,[$idanuncio,$nombre_img,$nombre_img_thumb,$check_principal,1]);

        return $st;
    }

    public function listarAnunciosUsuario($idusuario, $status){
        $query = "select anu.idanuncio, anu.an_nombre, anu.an_fechacreacion, anu.idtipo_anuncio, anu.idusuario, anu.idcate, anu.precio, anu.precio_mostrar,
        anu.codanuncio, anu.an_status,
        tan.ta_tipo, can.categoria,
        img.idimages, img.img, img.img_thumb,
        ean.estado
        from anuncio anu
        inner join tipo_anuncio tan on anu.idtipo_anuncio=tan.idtipo_anuncio 
        inner join cat_anuncio can on anu.idcate=can.idcate 
        inner join images img on anu.idanuncio=img.idanuncio 
        inner join estados_anuncio ean on anu.an_status = ean.idestado
        where anu.idusuario = ? and img.principal = ?";
        $st = $this->db->query($query, [$idusuario, $status]);

        return $st->getResultArray();  
    }

}
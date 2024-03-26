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

    public function modificarAnuncio($idusuario, $idanuncio_post, $data){
        $query = "update anuncio set an_nombre=?,an_descripcion=?,idtipo_anuncio=?,idcate=?,precio=?,precio_mostrar=?,caracteristicas=?,url_video=?,ubigeo=?,
        direccion=?,contact_email=?,contact_fono=?,contact_whatsapp=?, levanta_obs = ? WHERE idanuncio=? and idusuario=?";

        $st = $this->db->query($query, [$data['nombre'],$data['descripcion'],$data['tipo'],$data['categoria'],$data['precio'],$data['nomostrar'],
            $data['caracteristicas'],$data['video'],$data['ubigeo'],$data['direccion'],$data['email'],$data['telefono'],$data['whatsapp'],$data['levantaobs'],$idanuncio_post, $idusuario]);

        return $st;
    }

    public function insertarImagenes($idanuncio, $nombre_img, $nombre_img_thumb, $check_principal){
        $query = "insert into images(idanuncio,img,img_thumb,principal,status) values(?,?,?,?,?)";
        $st = $this->db->query($query,[$idanuncio,$nombre_img,$nombre_img_thumb,$check_principal,1]);

        return $st;
    }

    public function listarAnunciosUsuario($idusuario, $desde, $hasta, $nombre = '', $status = ''){
        $sql = $nombre != '' ? " and anu.an_nombre LIKE '%" . $this->db->escapeLikeString($nombre) . "%' " : '';
        //date_format(anu.an_fechacreacion, '%d/%m/%Y %h:%m %p') fechac

        $query = "select anu.idanuncio, anu.an_nombre, anu.an_fechacreacion, anu.idtipo_anuncio, anu.idusuario, anu.idcate, anu.precio, anu.precio_mostrar,
        anu.codanuncio, anu.an_status,date_format(anu.an_fechacreacion, '%d/%m/%Y') fechac,
        DATEDIFF(anu.hastafecha, now()) diasactivo,
        anu.levanta_obs,
        tan.ta_tipo, can.categoria,
        img.idimages, img.img, img.img_thumb,
        ean.estado
        from anuncio anu
        inner join tipo_anuncio tan on anu.idtipo_anuncio=tan.idtipo_anuncio 
        inner join cat_anuncio can on anu.idcate=can.idcate 
        inner join images img on anu.idanuncio=img.idanuncio 
        inner join estados_anuncio ean on anu.an_status = ean.idestado
        where anu.idusuario = ? and img.principal = ? $sql order by anu.idanuncio desc limit ?,?";
        
        $st = $this->db->query($query, [$idusuario, 1, $desde, $hasta]);

        return $st->getResultArray();  
    }

    public function countListarAnunciosUsuario($idusuario, $nombre = '', $status = ''){
        $sql = $nombre != '' ? " and anu.an_nombre LIKE '%" . $nombre . "%' " : '';

        $query = "select count(anu.idanuncio) as total
        from anuncio anu 
        where anu.idusuario = ? $sql";
        
        $st = $this->db->query($query, [$idusuario]);

        return $st->getRowArray();
    }

    public function getAnu_idanu_idusu($idusuario, $idanuncio){
        $query = "select anu.idanuncio, anu.an_nombre, anu.an_fechacreacion, anu.idtipo_anuncio, anu.idusuario, anu.idcate, anu.precio, anu.precio_mostrar,
        anu.codanuncio, anu.an_status, anu.caracteristicas, anu.an_descripcion, anu.url_video, anu.direccion,
        anu.contact_email, anu.contact_fono, anu.contact_whatsapp,
        anu.an_activo,anu.activadofecha, anu.hastafecha, anu.activousuario, anu.observadopor, anu.estado_ant, anu.levanta_obs,
        tan.ta_tipo, can.categoria,
        img.idimages, img.img, img.img_thumb,
        ubi.iddepa, ubi.idprov, ubi.iddist, ubi.prov, ubi.dist,
        ean.estado
        from anuncio anu
        inner join tipo_anuncio tan on anu.idtipo_anuncio=tan.idtipo_anuncio 
        inner join cat_anuncio can on anu.idcate=can.idcate 
        inner join images img on anu.idanuncio=img.idanuncio 
        inner join estados_anuncio ean on anu.an_status = ean.idestado 
        inner join ubigeo ubi on anu.ubigeo = ubi.idubigeo
        where anu.idanuncio = ? and anu.idusuario = ? and img.principal = 1";
        $st = $this->db->query($query, [$idanuncio, $idusuario]);

        return $st->getRowArray();  
    }

    public function getImages($idnuncio){
        $query = "select idimages,idanuncio,img,img_thumb,principal,status from images where idanuncio = ?";
        $st = $this->db->query($query, [$idnuncio]);

        return $st->getResultArray();
    }

    public function eliminarImgPorId($idimg, $idanuncio){
        $query = "delete from images where idimages=? and idanuncio = ?";
        $st = $this->db->query($query, [$idimg, $idanuncio]);

        return $st;
    }

    public function eliminarImgPorIdAnuncio($idanuncio){
        $query = "delete from images where idanuncio = ?";
        $st = $this->db->query($query, [$idanuncio]);

        return $st;
    }

    public function quitarPrincipalesImg_IdAnuncio($idanuncio){
        $query = "update images set principal = 0 where idanuncio = ?";
        $st = $this->db->query($query, [$idanuncio]);

        return $st;
    }

    public function hacerPrincipalImg_idImg_idAnu($idimg, $idanuncio, $principal = 1){
        $query = "update images set principal = ? where idimages=? and idanuncio = ?";
        $st = $this->db->query($query, [$principal, $idimg, $idanuncio]);

        return $st;
    }

    public function eliminarAnuncio($idanuncio){
        $query = "delete from anuncio where idanuncio = ?";
        $st = $this->db->query($query, [$idanuncio]);

        return $st;
    }


    public function listarAnunciosAdmin($desde, $hasta, $nombre = '', $status = [1,2,3,4,5,6,7]){
        $sql = $nombre != '' ? " and anu.an_nombre LIKE '%" . $this->db->escapeLikeString($nombre) . "%' " : '';
        //date_format(anu.an_fechacreacion, '%d/%m/%Y %h:%m %p') fechac

        $query = "select anu.idanuncio, anu.an_nombre, anu.an_fechacreacion, anu.idtipo_anuncio, anu.idusuario, anu.idcate, anu.precio, anu.precio_mostrar,
        anu.codanuncio, anu.an_status,date_format(anu.an_fechacreacion, '%d/%m/%Y') fechac,
        DATEDIFF(anu.hastafecha, now()) diasactivo,
        anu.an_activo,anu.activadofecha, anu.hastafecha, anu.activousuario, anu.observadopor, anu.estado_ant, anu.levanta_obs,
        tan.ta_tipo, can.categoria,
        img.idimages, img.img, img.img_thumb,
        ean.estado
        from anuncio anu
        inner join tipo_anuncio tan on anu.idtipo_anuncio=tan.idtipo_anuncio 
        inner join cat_anuncio can on anu.idcate=can.idcate 
        inner join images img on anu.idanuncio=img.idanuncio 
        inner join estados_anuncio ean on anu.an_status = ean.idestado
        where img.principal = ? and anu.an_status in ? $sql order by anu.idanuncio desc limit ?,?";
        
        $st = $this->db->query($query, [1, $status, $desde, $hasta]);

        return $st->getResultArray();  
    }

    public function countListarAnunciosAdmin($nombre = '', $status = [1,2,3,4,5,6,7]){
        $sql = $nombre != '' ? " and anu.an_nombre LIKE '%" . $nombre . "%' " : '';

        $query = "select count(anu.idanuncio) as total
        from anuncio anu 
        where anu.an_status in ? $sql";
        
        $st = $this->db->query($query, [$status]);

        return $st->getRowArray();
    }

    public function getAnu_idanu($idanuncio){
        $query = "select anu.idanuncio, anu.an_nombre, anu.an_fechacreacion, anu.idtipo_anuncio, anu.idusuario, anu.idcate, anu.precio, anu.precio_mostrar,
        anu.codanuncio, anu.an_status, anu.caracteristicas, anu.an_descripcion, anu.url_video, anu.direccion,
        anu.contact_email, anu.contact_fono, anu.contact_whatsapp,
        date_format(anu.an_fechacreacion, '%d/%m/%Y') fechac,
        DATEDIFF(anu.hastafecha, now()) diasactivo,
        anu.an_activo,anu.activadofecha, anu.hastafecha, anu.activousuario, anu.observadopor, anu.estado_ant, anu.levanta_obs,
        tan.ta_tipo, can.categoria,
        tan.ta_tipo, can.categoria,
        img.idimages, img.img, img.img_thumb,
        ubi.iddepa, ubi.idprov, ubi.iddist, ubi.prov, ubi.dist,
        ean.estado,
        usu.us_email, usu.us_nombre_razon
        from anuncio anu
        inner join tipo_anuncio tan on anu.idtipo_anuncio=tan.idtipo_anuncio 
        inner join cat_anuncio can on anu.idcate=can.idcate 
        inner join images img on anu.idanuncio=img.idanuncio 
        inner join estados_anuncio ean on anu.an_status = ean.idestado 
        inner join ubigeo ubi on anu.ubigeo = ubi.idubigeo 
        inner join usuario usu on anu.idusuario=usu.idusuario
        where anu.idanuncio = ? and img.principal = 1";
        $st = $this->db->query($query, [$idanuncio]);

        return $st->getRowArray();  
    }

    public function activarAnuncio($idanuncio, $estado, $activo, $idusuarioactivador){
        if( $activo == 1 ){
            $query = "update anuncio set an_status = ?, observadopor = ?, estado_ant = ?, activousuario = ?  where idanuncio = ?";
            $st = $this->db->query($query, [$estado, '', '', $idusuarioactivador, $idanuncio]);
        }else if( $activo != 1 ){
            $query = "update anuncio set an_status = ?, observadopor = ?, estado_ant = ?, activousuario = ?, an_activo = ?, activadofecha = now(), 
                hastafecha = DATE_ADD(now(), INTERVAL 30 DAY)  where idanuncio = ?";
            $st = $this->db->query($query, [$estado, '', '', $idusuarioactivador, 1, $idanuncio]);
        }  

        return $st;
    }

    public function observarAnuncio($idanuncio, $estado, $motivo, $estado_ant){
        $query = "update anuncio set an_status = ?, observadopor = ?, estado_ant = ?, levanta_obs = ?  where idanuncio = ?";
        $st = $this->db->query($query, [$estado, $motivo, $estado_ant, 0, $idanuncio]);

        return $st;
    }

}
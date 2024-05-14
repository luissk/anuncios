<?php

namespace App\Controllers;

class Favorito extends BaseController
{
    protected $modeloUsuario;
    protected $modeloUbigeo;
    protected $modeloAnuncio;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->modeloUbigeo  = model('UbigeoModel');
        $this->modeloAnuncio = model('AnuncioModel');
        $this->session;
    }

    public function index(){
        if( !session('idusuario') ){
            return redirect()->to('ingresar');
        }

        if( session('idtipousu') == 1 ){
            return redirect()->to('panel-usuario');
        }

        $data['title']        = 'Anuncios favoritos';
        $data['opt_favorite'] = 1;

        $favoritos = $this->modeloAnuncio->getFavoritos_x_Usuario(session('idusuario'));

        $data['favoritos'] = $favoritos;

        return view('panel/usuario/favoritos', $data);
    }

    public function borrarFavorito  (){
        if( $this->request->isAJAX() ){
            if(!session('idusuario')){
                exit();
            }

            $idfavorito = $this->request->getVar('id');

            if( $this->modeloAnuncio->borrarFavorito($idfavorito, session('idusuario')) ){
                echo '<script>
                    Swal.fire({
                        title: "Anuncio favorito eliminado",
                        text: "",
                        icon: "success",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                    });
                    setTimeout(function(){ location.reload()},1500);
                </script>';
            }
        }
    }


}
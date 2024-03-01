<?php

namespace App\Controllers;

class Anuncio extends BaseController
{
    protected $modeloUsuario;
    protected $modeloUbigeo;
    protected $modeloAnuncio;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->modeloUbigeo  = model('UbigeoModel');
        $this->modeloAnuncio  = model('AnuncioModel');
        $this->session;
    }

    public function index(){}

    public function misAnuncios(){
        if( !session('idusuario') ){
            return redirect()->to('/');
        }

        if( session('idtipousu') == 1 ){
            $view = 'panel/administrador/anuncios';
        }else if( session('idtipousu') == 2 ){
            $view = 'panel/usuario/anuncios';
        }

        $data['title']        = 'Mis Anuncios';
        $data['opt_anuncios'] = 1;

        return view($view, $data);
    }

    public function publicarAnuncio(){
        if( !session('idusuario') ){
            return redirect()->to('ingresar');
        }

        if( session('idtipousu') == 1 ){
            return redirect()->to('panel-usuario');
        }

        $tipos      = $this->modeloAnuncio->listarTipos();
        $categorias = $this->modeloAnuncio->listarCategorias();

        $data['title']        = 'Nuevo Anuncio';
        $data['opt_anuncios'] = 1;
        $data['tipos']        = $tipos;
        $data['categorias']   = $categorias;

        return view('panel/usuario/anuncio_new', $data);
    }


}
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->group('/', ['namespace' => 'App\Controllers'], static function ($routes) {
    $routes->get('', 'Inicio::index');

    /* $routes->get('busca-(:any)-de-(:any)-en-(:any)', 'Inicio::busqueda/$1/$2/$3');
    $routes->get('busca-(:any)-de-(:any)', 'Inicio::busqueda/$1/$2');
    $routes->get('busca-(:any)', 'Inicio::busqueda/$1'); */

    $routes->get('busca-(:any)-de-(:any)-en-(:any)', 'Inicio::busqueda/$1/$2/$3');
    $routes->get('busca-(:any)-en-(:any)', 'Inicio::busqueda/$1/$2');
    $routes->get('busca-(:any)-de-(:any)', 'Inicio::busqueda/$1/$2');
    $routes->get('busca-(:any)', 'Inicio::busqueda/$1');

    $routes->get('anuncio-(:any)', 'Inicio::detalleAnuncio/$1');
    $routes->get('ingresar', 'Inicio::loginRegister');
    $routes->post('ingresar', 'Inicio::loginRegister');
    $routes->get('salir', 'Inicio::salir');
    $routes->get('panel-usuario', 'Inicio::panel');

    $routes->get('gcaptcha-mensaje', 'Inicio::captchaMensaje');
    $routes->post('enviar-mensaje', 'Inicio::enviarMensaje');

    $routes->get('sendmail', 'Inicio::sendmail');//PARA PROBAR
    $routes->get('activarcuenta/(:any)', 'Inicio::activarcuenta/$1');

    $routes->get('nuevopassword-(:any)', 'Inicio::nuevopassword/$1');
    //ajax
    $routes->post('recuperapassword', 'Inicio::recuperarPassword');
    $routes->post('guardarnuevopass', 'Inicio::guardarNuevoPassword');

    $routes->post('agregarfavorito', 'Inicio::agregarFavorito');
});

$routes->group('/', ['namespace' => 'App\Controllers'], static function ($routes) {
    $routes->get('mi-cuenta', 'Usuario::micuenta');
    //parte paginas principales
    $routes->get('anunciante-(:any)-(:num)', 'Usuario::verAnunciosUsuario/$1/$2');
    $routes->get('anunciantes', 'Usuario::mostrarAnunciantes');
    //AJAX
    $routes->post('modificarDatosUsu', 'Usuario::modificarDatosUsuario');
    $routes->post('distritosUsu', 'Usuario::listarDistritosUsuario');
    $routes->post('eliminarAvaUsu', 'Usuario::eliminarAvatarUsuario');
});

$routes->group('/', ['namespace' => 'App\Controllers'], static function ($routes) {
    $routes->get('mis-anuncios', 'Anuncio::misAnuncios');
    $routes->get('mis-anuncios-(:num)', 'Anuncio::misAnuncios/$1'); //para paginar
    $routes->get('publicar-anuncio', 'Anuncio::publicarAnuncio');
    $routes->get('modificar-anuncio-(:num)', 'Anuncio::publicarAnuncio/$1');
    //AJAX
    $routes->post('distritosAnu', 'Anuncio::listarDistritosAnuncio');
    $routes->post('crearAnuncio', 'Anuncio::CrearAnuncio');
    $routes->post('eliminarAnuncioUsuario', 'Anuncio::eliminarAnuncioPorUsuario');
    $routes->post('desactivarAnuncioUsuario', 'Anuncio::desactivarAnuncioPorUsuario');
    
    //ADMIN
    $routes->get('detalle-anuncio-admin-(:num)', 'Anuncio::detalleAnuncioAdmin/$1');
    //AJAX
    $routes->post('activarObservar', 'Anuncio::activarObservarAnuncio');
});

$routes->group('/', ['namespace' => 'App\Controllers'], static function ($routes) {
    $routes->get('favoritos', 'Favorito::index');
    //AJAX
    $routes->post('deletefavorite', 'Favorito::borrarFavorito');
});

//$routes->get('users/(:num)/gallery/(:num)', 'Galleries::showUserGallery/$1/$2', ['as' => 'user_gallery']);

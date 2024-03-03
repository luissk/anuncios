<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->group('/', ['namespace' => 'App\Controllers'], static function ($routes) {
    $routes->get('', 'Inicio::index');
    $routes->get('ingresar', 'Inicio::loginRegister');
    $routes->post('ingresar', 'Inicio::loginRegister');
    $routes->get('salir', 'Inicio::salir');
    $routes->get('panel-usuario', 'Inicio::panel');
});

$routes->group('/', ['namespace' => 'App\Controllers'], static function ($routes) {
    $routes->get('mi-cuenta', 'Usuario::micuenta');
    //AJAX
    $routes->post('modificarDatosUsu', 'Usuario::modificarDatosUsuario');
    $routes->post('distritosUsu', 'Usuario::listarDistritosUsuario');
    $routes->post('eliminarAvaUsu', 'Usuario::eliminarAvatarUsuario');    
});

$routes->group('/', ['namespace' => 'App\Controllers'], static function ($routes) {
    $routes->get('mis-anuncios', 'Anuncio::misAnuncios');
    $routes->get('publicar-anuncio', 'Anuncio::publicarAnuncio');
    //AJAX
    $routes->post('distritosAnu', 'Anuncio::listarDistritosAnuncio');
});

//$routes->get('users/(:num)/gallery/(:num)', 'Galleries::showUserGallery/$1/$2', ['as' => 'user_gallery']);

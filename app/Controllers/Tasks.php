<?php

namespace App\Controllers;

class Tasks extends BaseController
{
    protected $modeloTasks;
    protected $modeloAnuncio;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloTasks = model('TasksModel');
        $this->modeloAnuncio = model('AnuncioModel');
        $this->session;
    }

    public function index(){}

    public function desactivarAnuncios(){
        
        if( $anuncios = $this->modeloTasks->listarAnuncios() ){
            /* echo "<pre>";
            print_r($anuncios);
            echo "</pre>"; */
            foreach( $anuncios as $anu ){
                $idanuncio           = $anu['idanuncio'];
                $an_nombrne          = $anu['an_nombre'];
                $idusuario           = $anu['idusuario'];
                $codanuncio          = $anu['codanuncio'];
                $an_status           = $anu['an_status'];
                $diasactivo          = $anu['diasactivo'];
                $iddestacado         = $anu['iddestacado'];
                $diasactivodestacado = $anu['diasactivodestacado'];

                //cuando vence sus días de destacado, pero aun tiene diás como activo. Solo se quita el estado de destacado del anuncioy el id de destacado, y se cambia el estado de la tabla destacado a 2 (finalizado)
                if( $diasactivodestacado < 0 ){
                    if( $this->modeloAnuncio->cambiarEstadoDeDestacado($idanuncio, $iddestacado, 2) && $this->modeloTasks->cambiarEstadoAnuncioDestacado($idanuncio, 2) ){
                        echo "$idanuncio - anuncio destacado a activo";
                    }
                }

                //cuando vence sus dias de activo, pasa a inactivo
                if( $diasactivo < 0 ){
                    if( $this->modeloAnuncio->cambiarEstadoAnuncioUsu($idanuncio, 3) ){
                        echo "$idanuncio - anuncio activo a inactivo<br>";
                    }
                }

            }
        }
    }

}
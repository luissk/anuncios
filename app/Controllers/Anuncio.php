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

        $provincias = $this->modeloUbigeo->listarProvincias();

        $us = $this->modeloUsuario->getUsuarioPorId(session('idusuario'));

        $data['title']        = 'Nuevo Anuncio';
        $data['opt_anuncios'] = 1;
        $data['tipos']        = $tipos;
        $data['categorias']   = $categorias;
        $data['provincias']   = $provincias;
        $data['usuario']      = $us;

        return view('panel/usuario/anuncio_new', $data);
    }

    public function listarDistritosAnuncio(){
        if( $this->request->isAJAX() ){
            if(!session('idusuario')){
                exit();
            }

            $idprov    = trim($this->request->getVar('idprov'));

            if( $distritos = $this->modeloUbigeo->listarDistritos($idprov) ){
                echo "<option value = ''>Seleccione</option>";
                foreach($distritos as $dist){
                    $iddist   = $dist['iddist'];
                    $distrito = $dist['dist'];

                    echo "<option value = '$iddist'>$distrito</option>";
                }
            }else{
                echo "<option value = ''>Seleccione</option>";
            }
        }
    }

    public function CrearAnuncio(){
        if( $this->request->isAJAX() ){
            if(!session('idusuario')){
                exit();
            }

            $codanuncio = stringAleatorio(15);
            
            $validation = \Config\Services::validation();

            $data = [
                'tipo'            => trim($this->request->getVar('tipo')),
                'categoria'       => trim($this->request->getVar('categoria')),
                'nombre'          => trim($this->request->getVar('nombre')),
                'precio'          => trim($this->request->getVar('precio')),
                'nomostrar'       => $this->request->getVar('nomostrar'),
                'caracteristicas' => trim($this->request->getVar('caracteristicas')),
                'descripcion'     => trim($this->request->getVar('descripcion')),
                'video'           => trim($this->request->getVar('video')),
                'principal'       => $this->request->getVar('principal'),
                'provincia'       => trim($this->request->getVar('provincia')),
                'distrito'        => trim($this->request->getVar('distrito')),
                'direccion'       => trim($this->request->getVar('direccion')),
                'email'           => trim($this->request->getVar('email')),
                'telefono'        => trim($this->request->getVar('telefono')),
                'whatsapp'        => trim($this->request->getVar('whatsapp')),
                'imagenes'        => $this->request->getFiles('imagenes'),
            ];

            $validation->setRules([
                'tipo' => [
                    'label' => 'Tipo de Anuncio', 
                    'rules' => 'required|integer|max_length[2]',
                    'errors' => [
                        'required'   => '* El {field} es requerido.',
                        'integer'    => '* La {field} no es válido.',
                        'max_length' => '* La {field} debe contener máximo 2 caracteres.'
                    ]
                ],
                'categoria' => [
                    'label' => 'Categoría', 
                    'rules' => 'required|integer|max_length[2]',
                    'errors' => [
                        'required'   => '* El {field} es requerido.',
                        'integer'    => '* La {field} no es válido.',
                        'max_length' => '* La {field} debe contener máximo 2 caracteres.'
                    ]
                ],
                'nombre' => [
                    'label' => 'Nombre', 
                    'rules' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9]+$/]|max_length[100]',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'regex_match' => '* El {field} no es válido.',
                        'max_length'  => '* El {field} debe contener máximo 100 caracteres.'
                    ]
                ],
                'precio' => [
                    'label' => 'Precio', 
                    'rules' => 'permit_empty|required_without[nomostrar]|decimal|max_length[11]',
                    'errors' => [
                        'required_without' => '* El {field} es requerido.',
                        'decimal'          => '* El {field} sólo contiene números y punto decimal',
                        'max_length'       => '* El {field} debe contener máximo 11 caracteres.'
                    ]
                ],
                'nomostrar' => [
                    'label' => 'No Mostrar Precio', 
                    'rules' => 'permit_empty|integer|max_length[1]',
                    'errors' => [
                        'integer'    => '* El {field} sólo contiene números.',
                        'max_length' => '* El {field} debe contener máximo 1 caracteres.'
                    ]
                ],
                'caracteristicas' => [
                    'label' => 'Características', 
                    'rules' => 'permit_empty|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9\r\n]+$/]|max_length[255]',
                    'errors' => [
                        'regex_match' => '* Las {field} sólo letras y números',
                        'max_length'  => '* Las {field} debe contener máximo 255 caracteres.'
                    ]
                ],
                'descripcion' => [
                    'label' => 'Descripción', 
                    'rules' => 'required|max_length[4000]',
                    'errors' => [
                        'required' => '* La {field} es requerido.',
                        'max_length'  => '* Las {field} debe contener máximo 4000 caracteres.'
                    ]
                ],
                'video' => [
                    'label' => 'URL Youtube', 
                    'rules' => 'permit_empty|valid_url_strict|max_length[150]',
                    'errors' => [
                        'max_length'       => '* Máximo 150 caracteres.',
                        'valid_url_strict' => '* La URL es inválida.',
                    ]
                ],
                'direccion' => [
                    'label' => 'Dirección', 
                    'rules' => 'permit_empty|alpha_numeric_punct|max_length[150]',
                    'errors' => [
                        'alpha_numeric_punct' => '* La {field} no es válida.',
                        'max_length'          => '* La {field} debe contener máximo 150 caracteres.'
                    ]
                ],
                'provincia' => [
                    'label' => 'Provincia', 
                    'rules' => 'required|alpha_numeric|max_length[2]',
                    'errors' => [
                        'required' => '* La {field} es requerido.',
                        'alpha_numeric' => '* La {field} no es válido.',
                        'max_length'    => '* La {field} debe contener máximo 2 caracteres.'
                    ]
                ],
                'distrito' => [
                    'label' => 'Distrito', 
                    'rules' => 'required|alpha_numeric|max_length[2]',
                    'errors' => [
                        'required'      => '* El {field} es requerido.',
                        'max_length'    => '* El {field} debe contener máximo 2 caracteres.',
                        'alpha_numeric' => '* El {field} no es válido.',
                    ]
                ],
                'email' => [
                    'label' => 'Email', 
                    'rules' => 'permit_empty|valid_email|max_length[150]',
                    'errors' => [
                        'valid_email' => '* El {field} no es válido.',
                        'max_length'  => '* Como máximo 150 caracteres para el {field}.',
                    ]
                ],
                'telefono' => [
                    'label' => 'Teléfono', 
                    'rules' => 'permit_empty|regex_match[/^[0-9]+$/]|max_length[12]',
                    'errors' => [
                        'max_length' => '* Como máximo 12 caracteres para el {field}.',
                        'regex_match' => '* El {field} sólo contiene números.'
                    ]
                ],
                'whatsapp' => [
                    'label' => 'Whatsapp', 
                    'rules' => 'permit_empty|regex_match[/^[0-9]+$/]|min_length[9]|max_length[9]',
                    'errors' => [
                        'min_length'  => '* El {field} debe tener 9 caracteres.',
                        'max_length'  => '* El {field} debe tener 9 caracteres.',
                        'regex_match' => '* El {field} sólo contiene números.'
                    ]
                ],
            ]);

            if (!$validation->run($data)) {
                return $this->response->setJson(['errors' => $validation->getErrors()]); 
            }

            print_r($_POST);
            //print_r($this->request->getFiles('imagenes'));
        }
    }


}
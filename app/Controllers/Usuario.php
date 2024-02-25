<?php

namespace App\Controllers;

class Usuario extends BaseController
{
    protected $modeloUsuario;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->session;
    }

    public function index(){}

    public function micuenta(){
        if( !session('idusuario') ){
            return redirect()->to('/');
        }

        $usuario = $this->modeloUsuario->getUsuarioPorId(session('idusuario'));

        $data['title']       = 'Mi Cuenta';
        $data['opt_account'] = 1;
        $data['usuario']     = $usuario;

        return view('panel/micuenta', $data);
    }

    public function modificarDatosUsuario(){
        if( $this->request->isAJAX() ){
            if(!session('idusuario')){
                exit();
            }

            $validation = \Config\Services::validation();
            $validation->setRules([
                'nombre' => [
                    'label' => 'Nombre', 
                    'rules' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/]|max_length[100]',
                    'errors' => [
                        'required' => '* El {field} es requerido.',
                        'regex_match' => '* El {field} no es válido.',
                        'max_length' => '* El {field} debe contener máximo 100 caracteres.'
                    ]
                ],
                'dniruc' => [
                    'label' => 'DNI / RUC', 
                    'rules' => 'permit_empty|regex_match[/^[0-9]+$/]|min_length[8]|max_length[11]',
                    'errors' => [
                        'regex_match' => '* El {field} sólo contiene números.',
                        'min_length' => '* El {field} debe contener mínimo 8 caracteres.',
                        'max_length' => '* El {field} debe contener máximo 11 caracteres.'
                    ]
                ],
                'telefono' => [
                    'label' => 'Teléfono', 
                    'rules' => 'required|regex_match[/^[0-9]+$/]|max_length[12]',
                    'errors' => [
                        'required' => '* El {field} es requerido.',
                        'max_length' => '* Como máximo 12 caracteres para el {field}.',
                        'regex_match' => '* El {field} sólo contiene números.'
                    ]
                ],
                'password' => [
                    'label' => 'Contraseña', 
                    'rules' => 'permit_empty|min_length[8]|max_length[15]',
                    'errors' => [
                        'min_length' => '* La {field} debe tener al menos 8 caracteres.',
                        'max_length' => '* La {field} debe tener hasta 15 caracteres.'
                    ]
                ],
            ]);

            $data = [
                'nombre'   => trim($this->request->getVar('nombre')),
                'dniruc'   => trim($this->request->getVar('dniruc')),
                'telefono' => trim($this->request->getVar('telefono')),
                'password' => trim($this->request->getVar('password'))
            ];

            if (!$validation->run($data)) {
                //return redirect()->back()->with('errors', $validation->getErrors())->withInput();
                return $this->response->setJson(['errors' => $validation->getErrors()]); 
            }

            print_r($_POST);
        }
    }

}

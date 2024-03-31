<?php

namespace App\Controllers;
use App\Models\UsuarioModel;

class Inicio extends BaseController
{
    protected $modeloAnuncio;
    protected $modeloUsuario;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->modeloAnuncio = model('AnuncioModel');
        $this->session;
    }

    public function index(): string
    {
        $data['title']          = 'Inicio pe';
        $data['act_menuinicio'] = 1;

        $anuncios = $this->modeloAnuncio->listarAnunciosAdmin(0, 19, '', [2,4,5]);
        $data['anuncios'] = $anuncios;

        return view('general/index', $data);
    }

    public function detalleAnuncio($a)
    {   
        if( $this->request->is('get') ){
            $split = explode("-", $a);
            $id    = (int)$split[count($split) - 1];

            if( !is_int($id) ) exit();

            $anuncio = $this->modeloAnuncio->getAnu_idanu($id);

            if( !$anuncio ) return redirect()->to('/');

            $nombreAnun = $anuncio['an_nombre'];

            $data['title']    = $nombreAnun;
            $data['anuncio']  = $anuncio;
            $data['imagenes'] = $this->modeloAnuncio->getImages($id);

            return view('general/detalle', $data);
        }        
    }

    public function loginRegister()
    {   
        if( session('idusuario') ){
            return redirect()->to('/');
        }

        if( $this->request->is('post') ){
            $secretkey_captcha = '6Ld-2nUpAAAAABR9MPxHSQyxX1F3JELX94Rm7i_w'; // Para Captcha

            $token  = $this->request->getPost('token');
            $action = $this->request->getPost('action');

            if( $action === 'login' ){
                $vars['email']    = trim($this->request->getVar('loginEmail'));
                $vars['password'] = trim($this->request->getVar('loginPassword'));           
                $this->_login( $secretkey_captcha, $token, $vars );
            }else if( $action === 'register' ){
                $vars['nombre']    = trim($this->request->getVar('regNombre'));
                $vars['telefono']  = trim($this->request->getVar('regFono'));
                $vars['email']     = trim($this->request->getVar('regEmail'));
                $vars['password']  = trim($this->request->getVar('regPassword'));
                $vars['rpassword'] = trim($this->request->getVar('regConfPassword'));
                $vars['politica']  = trim($this->request->getVar('regPolitica'));
                $this->_register( $secretkey_captcha, $token, $vars );
                /* echo "<pre>";
                print_r($_POST);
                print_r($vars);
                echo "</pre>"; */
            }
        }
        
        $data['title'] = 'Ingresa o Regístrate';

        return view('general/login_register', $data);
    }

    private function _login($secretkey_captcha, $token, $vars){

        $cu = curl_init();
        curl_setopt($cu, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($cu, CURLOPT_POST, 1);
        curl_setopt($cu, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $secretkey_captcha, 'response' => $token)));
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
        $response     = curl_exec($cu);
        $resp_captcha = json_decode($response, true);

        if( $resp_captcha['success'] == 1 && $resp_captcha['score'] >= 0.5 ){
            if( $resp_captcha['action'] == 'LOGIN' ){
                //$validation = service('validation');
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'loginEmail' => [
                        'label' => 'Email', 
                        'rules' => 'required|valid_email',
                        'errors' => [
                            'required' => '* El {field} es requerido.',
                            'valid_email' => '* El {field} no es válido.'
                        ]
                    ],
                    'loginPassword' => [
                        'label' => 'Contraseña', 
                        'rules' => 'required',
                        'errors' => [
                            'required' => '* La {field} es requerida.'
                        ]
                    ]
                ]);

                $data = [
                    'loginEmail'    => $vars['email'],
                    'loginPassword' => $vars['password'],
                ];

                if (!$validation->run($data)) {
                    return redirect()->back()->with('errors', $validation->getErrors())->withInput();
                }

                $hash = '$2a$12$YmtIBS/VsxVywSQHV4A2.upBWJxS2VSqFzUwo1eMU5.tIGOgne6YG';
                $password = crypt($vars['password'], $hash);

                $result = $this->modeloUsuario->validarLogin($vars['email']);

                if( $result && $result['us_pass'] == $password ){
                   /*  echo "<pre>";
                    print_r($result)             ;
                    echo "</pre>"; */
                    $datasession = [
                        'idusuario' => $result['idusuario'],
                        'email'     => $result['us_email'],
                        'idtipousu' => $result['idtipo_usuario'],
                        'codigous'  => $result['us_codusuario']
                    ];
                    $this->session->set($datasession);

                    return $this->response->redirect(site_url('panel-usuario'));
                    //echo "<script>location.href='panel-usuario'</script>";
                }else{
                    $this->session->remove('errors');
                    return redirect()->route('ingresar')->with('msg_login', 'Usuario y/o Contraseña inválidos.');
                }               
            }            
        }else{
            echo "ALGO PASO CON EL CAPTCHA";
        }
    }

    private function _register($secretkey_captcha, $token, $vars){
        $cu = curl_init();
        curl_setopt($cu, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($cu, CURLOPT_POST, 1);
        curl_setopt($cu, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $secretkey_captcha, 'response' => $token)));
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
        $response     = curl_exec($cu);
        $resp_captcha = json_decode($response, true);

        if( $resp_captcha['success'] == 1 && $resp_captcha['score'] >= 0.5 ){
            if( $resp_captcha['action'] == 'REGISTER' ){
                //$validation = service('validation');
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'regNombre' => [
                        'label'  => 'Nombre Completo', 
                        'rules'  => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/]|max_length[100]',
                        'errors' => [
                            'required'    => '* El {field} es requerido.',
                            'regex_match' => '* El {field} no es válido.',
                            'max_length'  => '* Como máximo 100 caracteres para el {field}.'
                        ]
                    ],
                    'regFono' => [
                        'label' => 'Nombre Completo', 
                        'rules' => 'required|numeric|max_length[12]',
                        'errors' => [
                            'required' => '* El {field} es requerido.',
                            'max_length' => '* Como máximo 12 caracteres para el {field}.',
                            'numeric' => '* El {field} sólo contiene números.'
                        ]
                    ],
                    'regEmail' => [
                        'label' => 'Email', 
                        'rules' => 'required|valid_email|max_length[100]|is_unique[usuario.us_email]',
                        'errors' => [
                            'required'    => '* El {field} es requerido.',
                            'valid_email' => '* El {field} no es válido.',
                            'max_length'  => '* Como máximo 100 caracteres para el {field}.',
                            'is_unique'   => '* Y existe un usuario con ese email.'
                        ]
                    ],
                    'regPassword' => [
                        'label' => 'Contraseña', 
                        'rules' => 'required|min_length[8]|max_length[15]',
                        'errors' => [
                            'required' => '* La {field} es requerida.',
                            'min_length' => '* La {field} debe tener al menos 8 caracteres.',
                            'max_length' => '* La {field} debe tener hasta 15 caracteres.'
                        ]
                    ],
                    'regConfPassword' => [
                        'label' => 'Contraseña', 
                        'rules' => 'required|matches[regPassword]',
                        'errors' => [
                            'required' => '* La {field} es requerida.',
                            'matches' => '* Las {field}s deben coincidir.'
                        ]
                    ],
                    'regPolitica' => [
                        'label' => 'Política de Privacidad', 
                        'rules' => 'required|if_exist',
                        'errors' => [
                            'required' => '* La {field} es requerida.',
                        ]
                    ]
                ]);

                $data = [
                    'regNombre'    => $vars['nombre'],
                    'regFono' => $vars['telefono'],
                    'regEmail' => $vars['email'],
                    'regPassword' => $vars['password'],
                    'regConfPassword' => $vars['rpassword'],
                    'regPolitica' => $vars['politica'],
                ];

                if (!$validation->run($data)) {
                    return redirect()->back()->with('errors', $validation->getErrors())->withInput();
                }

                $hash = '$2a$12$YmtIBS/VsxVywSQHV4A2.upBWJxS2VSqFzUwo1eMU5.tIGOgne6YG';
                $password = crypt($vars['password'], $hash);
                //GUARDAR REGISTRO
                //if ( $id = $this->modeloUsuario->registrarUsuario($validation->getValidated(), $hash) ){
                if ( $id = $this->modeloUsuario->registrarUsuario($vars, $password, stringAleatorio(10)) ){
                    $this->session->remove('errors');
                    return redirect()->to(current_url())->with('msg_register', 1);
                    //echo "REGISTRO CORRECTO: ".$id;
                }
                /* print_r($validation->getValidated());
                echo "FORMULARIO REGISTRO CORRECTO"; */
            }            
        }else{
            echo "ALGO PASO CON EL CAPTCHA";
        }
    }


    public function salir(){
        $this->session->destroy();
        return redirect()->to('/');
    }


    public function panel()
    {
        if( !session('idusuario') ){
            return redirect()->to('/');
        }

        $data['title']    = 'Tu panel';
        $data['opt_dash'] = 1;

        if( session('idtipousu') == 1 ){
            return view('panel/administrador/index', $data);
        }else if( session('idtipousu') == 2 ){
            return view('panel/usuario/index', $data);
        }        
    }
}

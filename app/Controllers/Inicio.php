<?php

namespace App\Controllers;
use App\Models\UsuarioModel;

class Inicio extends BaseController
{
    protected $modeloAnuncio;
    protected $modeloUsuario;
    protected $modeloUbigeo;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->modeloAnuncio = model('AnuncioModel');
        $this->modeloUbigeo  = model('UbigeoModel');
        $this->session;
    }

    public function index()
    {
        if( $this->request->getGet('ini') == 1 ){//del formulario de inicio
            $txtSearch = trim($this->request->getVar('txtSearch'));
            $idubigeo  = $this->request->getGet('idubigeo');

            if( $idubigeo != '' ){
                $ubigeo = $this->modeloUbigeo->getUbigeo_x_Id($idubigeo);
                if( $ubigeo ){
                    $prov = help_reemplazaCaracterUrl($ubigeo['prov']);
                    $dist = $ubigeo['dist'] != '' ? "-".help_reemplazaCaracterUrl($ubigeo['dist']): '';
                    
                    $url = "busca-anuncios-en$dist-$prov";
                    return redirect()->to($url);
                }
            }else if( $txtSearch != '' ){
                return redirect()->to('busca-anuncios?keyword='.$txtSearch);
            }else{
                return redirect()->to('busca-anuncios');
            }
        }

        $data['title']          = 'Inicio pe';
        $data['act_menuinicio'] = 1;

        $anuncios = $this->modeloAnuncio->listarAnunciosAdmin(0, 19, '', [2,4,5]);
        $data['anuncios'] = $anuncios;

        return view('general/index', $data);
    }

    public function busqueda($t = '', $c = '', $u = ''){
        $tipo_get      = trim($t);
        $categoria_get = trim($c);
        $ubigeo_get    = trim($u);

        //echo "$tipo_get / $categoria_get / $ubigeo_get <br>";

        $query_bd = "";
        $param_bd = [];
        $title = "Busca";

        $uri = new \CodeIgniter\HTTP\URI(current_url(). ($_SERVER['QUERY_STRING'] != '' ? "?".$_SERVER['QUERY_STRING'] : ''));
        $remove_filters = [
            'tipo'    => ['busca-anuncios', ''],
            'cate'    => ['', ''],
            'ubi'     => ['',''],
            'order'   => ['',''],
            'keyword' => ['','']
        ];

        $idtipo = 0;
        if( $tipo_get == 'anuncios' ){
            $idtipo = 0;
            $title .= ' anuncios';
        }else{
            $tipobd = $this->modeloAnuncio->getTipo_x_Tipo($tipo_get);
            if( $tipobd ){
                $idtipo     = $tipobd['idtipo_anuncio'];
                $title     .= " ".$tipobd['ta_tipo'];
                $query_bd  .= " and anu.idtipo_anuncio = ?";
                $param_bd[] = $idtipo;

                $rf = str_replace('busca-'.$tipo_get, 'busca-anuncios', (string) $uri);
                $remove_filters['tipo'] = [$rf, 'Tipo: '.$tipobd['ta_tipo']];
            }
        }

        $idcategoria = 0;
        $idubigeo    = 0;
        if( $categoria_get == '' ){
            $idcategoria = 0;
            $idubigeo    = 0;
        }else{
            $categoriabd = $this->modeloAnuncio->getCategoria_x_Cat($categoria_get);
            $ubigeobd    = $this->modeloUbigeo->getUbigeo_x_Ubigeo($categoria_get);
            if( $categoriabd ){
                $idcategoria = $categoriabd['idcate'];
                $title     .= " de ".$categoriabd['categoria'];
                $query_bd  .= " and anu.idcate = ?";
                $param_bd[] = $idcategoria;

                $rf = str_replace('-de-'.$categoria_get, '', (string) $uri);
                $remove_filters['cate'] = [$rf, 'Categoría: '.$categoriabd['categoria']];
            }
            if( $ubigeobd ){
                $idubigeo = $ubigeobd['idubigeo'];
                $title     .= " en ".$ubigeobd['dist']." ".$ubigeobd['prov'];
                $query_bd  .= " and ubi.seotexto2 LIKE '%".$categoria_get."%'";
                //$param_bd[] = $categoria_get;

                $rf = str_replace('-en-'.$categoria_get, '', (string) $uri);
                $remove_filters['ubi'] = [$rf, 'En: '.$ubigeobd['dist']." ".$ubigeobd['prov']];
            }
        }

        if( $idubigeo == 0 ){
            if( $ubigeo_get == '' ){
                $idubigeo = 0;
            }else{
                $ubigeobd    = $this->modeloUbigeo->getUbigeo_x_Ubigeo($ubigeo_get);
                if( $ubigeobd ){
                    $idubigeo = $ubigeobd['idubigeo'];
                    $title     .= " en ".$ubigeobd['dist']." ".$ubigeobd['prov'];
                    $query_bd  .= " and ubi.seotexto2 LIKE '%".$ubigeo_get."%'";

                    $rf = str_replace('-en-'.$ubigeo_get, '', (string) $uri);
                    $remove_filters['ubi'] = [$rf, 'En: '.$ubigeobd['dist']." ".$ubigeobd['prov']];
                }
            }
        }

        $order = '';
        if( trim($this->request->getVar('order')) ){
            $order = $this->request->getVar('order');

            $rf = (string) $uri->stripQuery('order');
            $remove_filters['order'] = [$rf, 'Orden: '.($order == 'asc' ? 'Precio menor' : 'Precio mayor')];
        }

        $keyword = '';
        if( trim($this->request->getVar('keyword')) ){
            $keyword = trim($this->request->getVar('keyword'));

            $rf = (string) $uri->stripQuery('keyword');
            $remove_filters['keyword'] = [$rf, 'Palabra: '.$keyword];
        }

        $page = 1;
        if( trim($this->request->getVar('page')) ){
            $page = $this->request->getVar('page');
        }

        $desde        = $page * 25 - 25;
        $hasta        = 25;
        $data['page'] = $page;


        //echo "<br>$idtipo -- $idcategoria -- $idubigeo -- $keyword -- $order -- $page";

        $title = "$title | ".help_nombreWeb(); 

        $data['title']    = $title;
        $data['act_menuanuncios'] = 1;

        $anuncios = $this->modeloAnuncio->busqueda($desde, $hasta, $query_bd, $param_bd, $keyword, $order);
        $data['totalRegistros'] = $this->modeloAnuncio->countBusqueda($query_bd, $param_bd, $keyword)['total'];
        $data['anuncios']       = $anuncios;

        $tipos      = $this->modeloAnuncio->listarTipos();
        $categorias = $this->modeloAnuncio->listarCategorias();

        $data['tipos']      = $tipos;
        $data['categorias'] = $categorias;

        $data['filters'] = $remove_filters;

        return view('general/busqueda', $data);
    }

    public function captchaMensaje(){
        $codigo = stringAleatorio(5);
        $this->session->setFlashdata('codigoCaptcha', sha1($codigo));
        help_Captcha($codigo);
    }

    public function enviarMensaje(){
        if( $this->request->isAJAX() ){
            //print_r($_POST);
            //echo session('codigoCaptcha');

            $validation = \Config\Services::validation();

            $data = [
                'txtMail'    => trim($this->request->getVar('txtMail')),
                'txtNombre'  => trim($this->request->getVar('txtNombre')),
                'txtFono'    => trim($this->request->getVar('txtFono')),
                'txtMensaje' => trim($this->request->getVar('txtMensaje')),
                'txtCaptcha' => trim($this->request->getVar('txtCaptcha')),
                'idanuncio'  => $this->request->getVar('idanuncio'),
            ];

            $rules = [
                'txtMail' => [
                    'label' => 'Correo', 
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'valid_email' => '* El {field} no es válido.'
                    ]
                ],
                'txtNombre' => [
                    'label' => 'Nombre', 
                    'rules'  => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/]|max_length[100]',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'regex_match' => '* El {field} no es válido.',
                        'max_length'  => '* Como máximo 100 caracteres para el {field}.'
                    ]
                ],
                'txtFono' => [
                    'label' => 'Teléfono', 
                    'rules' => 'required|numeric|max_length[12]',
                    'errors' => [
                        'required'   => '* El {field} es requerido.',
                        'max_length' => '* Como máximo 12 caracteres para el {field}.',
                        'numeric'    => '* El {field} sólo contiene números.'
                    ]
                ],
                'txtMensaje' => [
                    'label' => 'Mensaje', 
                    'rules' => 'required|max_length[200]',
                    'errors' => [
                        'required'   => '* El {field} es requerido.',
                        'max_length' => '* El {field} debe contener máximo 200 caracteres.'
                    ]
                ],
                'txtCaptcha' => [
                    'label' => 'Captcha', 
                    'rules' => 'required|max_length[5]|regex_match[/^[A-Z0-9]+$/]',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'max_length'  => '* El {field} debe contener máximo 5 caracteres.',
                        'regex_match' => '* El {field} no es válido.',
                    ]
                ],
            ];

            if( session('codigoCaptcha') !== sha1($data['txtCaptcha']) ){
                $validation->setError('txtCaptcha', 'No coincide con el captcha.');
            }

            $validation->setRules($rules);
            
            if (!$validation->run($data)) {                
                return $this->response->setJson(['errors' => $validation->getErrors()]); 
            }

            $anuncio = $this->modeloAnuncio->getAnu_idanu($data['idanuncio']);
            if( $anuncio ){
                $nombre_anu    = $anuncio['an_nombre'];
                $contact_email = $anuncio['contact_email'] == '' ? $anuncio['us_email'] : $anuncio['contact_email'];

                $url = help_reemplazaCaracterUrl($nombre_anu)."-".$data['idanuncio'];

                $dataMail['mensaje']     = $data;
                $dataMail['linkanuncio'] = base_url('anuncio-'.$url.'');
                $dataMail['nombre_anu']  = $nombre_anu;
                $dataMail['email']       = $contact_email;

                if( help_sendMail(['anunciosdelvalle2024@gmail.com', 'Anuncios del Valle (ADV)'], $contact_email, 'Tienes 1 mensaje de tu anuncio', view('general/mailmensaje', $dataMail)) ){
                    echo '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        <b>¡Mensaje enviado!.</b>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    echo "<script>$('#frmMensaje')[0].reset()</script>";
                }else{
                    echo '<div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                        <b>Por favor inténtelo más tarde.</b>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }              
            }

        }
    }
    
    public function sendmail(){
        //help_sendMail(['avd@gmail.com', 'Anuncios del Valle (ADV)'], 'lushito88@gmail.com', 'Tienes un correo nuevo', view('general/mailregistro'));
        
        /* $link_act = stringAleatorio(30);
        $dataMail['link_act'] = $link_act;
        $dataMail['email'] = 'micorreo@gmail.com';
        return view('general/mailregistro', $dataMail); */

        //return view('general/mailmensaje');
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

    private function _loginGmail(){

        $clientID = '';
        $clientSecret = '';
        $redirectUri = '';

        // create Client Request to access Google API
        $client = new \Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");

        // authenticate code from Google OAuth Flow
        if (isset($_GET['code']) && $_GET['code'] ) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            $google_oauth = new \Google\Service\Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            $email =  $google_account_info->email;
            $name =  $google_account_info->name;
            
            /* echo "$email - $name";
            echo "<pre>";
            print_r($google_account_info);
            echo "</pre>"; */
            return array( 'tipo' => 'datosGoogle', 'datos' => [$email, $name] );
        } else {
            //echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
            return array( 'tipo' => 'linkGoogle', 'link' => $client->createAuthUrl() );
        }
    }

    private function loginConGoogle($arr){
        $email  = $arr[0];
        $nombre = $arr[1];

        if( $u = $this->modeloUsuario->validarLogin($email) ){
            if( $u['us_status'] == 2 ){
                $this->modeloUsuario->activaCuenta_x_linkact($u['idusuario']);
            }

            $datasession = [
                'idusuario' => $u['idusuario'],
                'email'     => $u['us_email'],
                'idtipousu' => $u['idtipo_usuario'],
                'codigous'  => $u['us_codusuario']
            ];
            $this->session->set($datasession);

            return $this->response->redirect(site_url('panel-usuario'));
        }else{
            if( $this->modeloUsuario->registrarUsuario_x_Google($email, $nombre, stringAleatorio(10, 0)) ){
                if( $u = $this->modeloUsuario->validarLogin($email) ){       
                    $datasession = [
                        'idusuario' => $u['idusuario'],
                        'email'     => $u['us_email'],
                        'idtipousu' => $u['idtipo_usuario'],
                        'codigous'  => $u['us_codusuario']
                    ];
                    $this->session->set($datasession);
        
                    return $this->response->redirect(site_url('panel-usuario'));
                }
            }
        }
    }

    public function loginRegister()
    {   
        if( session('idusuario') ){
            return redirect()->to('/');
        }

        $google = $this->_loginGmail();
        if( $google['tipo'] == 'datosGoogle' ){
            $this->loginConGoogle($google['datos']);
        }else if( $google['tipo'] == 'linkGoogle' ){
            $data['linkGoogle'] = $google['link'];
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
                    if( $result['us_status'] == 2 ){
                        return redirect()->route('ingresar')->with('msg_login', 'Su cuenta esta pendiente de activación.<br>Por favor revise su correo.');
                        exit();
                    }

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
            //echo "ALGO PASO CON EL CAPTCHA";
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
                        'label' => 'Teléfono', 
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
                $link_act = stringAleatorio(30, 0);
                $dataMail['link_act'] = base_url('activarcuenta')."/".$link_act;
                $dataMail['email']    = $vars['email'];
                if( help_sendMail(['anunciosdelvalle2024@gmail.com', 'Anuncios del Valle (ADV)'], $vars['email'], 'Felicidades te has registrado en nuestra web, activa tu cuenta.', view('general/mailregistro', $dataMail)) ){

                    $vars['linkact'] = $link_act;
                    if ( $id = $this->modeloUsuario->registrarUsuario($vars, $password, stringAleatorio(10, 0)) ){
                        $this->session->remove('errors');
                        return redirect()->to(current_url())->with('msg_register', ['success','<strong>Registro Correcto</strong>. Revisa tu correo (si no se encuentra, revisa en tus spam) y activa tu cuenta.']);
                    }
                }else{
                    return redirect()->to(current_url())->with('msg_register', ['danger','<strong>Hubo un problema en el envío de correo., inténtelo de nuevo.</strong>']);
                }
                /* print_r($validation->getValidated());
                echo "FORMULARIO REGISTRO CORRECTO"; */
            }            
        }else{
            /* echo "<script>
                alert('Inténtelo de nuevo');
            </script>"; */
        }
    }

    public function activarcuenta($link){
        $validation = \Config\Services::validation();

        $data = [
            'linkact' => trim($link)
        ];

        $rules = [
            'linkact' => [
                'label' => 'Link de Activación', 
                'rules' => 'required|alpha_numeric',
                'errors' => [
                    'required'    => '* El {field} es requerido.',
                    'alpha_numeric' => '* El {field} no es válido.'
                ]
            ]
        ];

        $validation->setRules($rules);

        if( !$validation->run($data) ) {
            //return print_r($validation->getErrors());
            return redirect()->route('ingresar')->with('msg_activacion', ['danger', $validation->getErrors()['linkact']]);
        }

        if( $usuario = $this->modeloUsuario->getUser_x_linkact($link) ){

            //print_r($usuario);exit();

            if( $usuario['us_status'] == 1 ){
                return redirect()->route('ingresar')->with('msg_activacion', ['warning', 'Su cuenta ya ha sido activada.']);
            }else if( $usuario['us_status'] == 2 ){
                if( $this->modeloUsuario->activaCuenta_x_linkact($usuario['idusuario']) ){
                    return redirect()->route('ingresar')->with('msg_activacion', ['success', '<b>Felicidades!</b>. Su cuenta ha sido activada, ya puede iniciar sesión']);
                }
            }
        }else{
            return redirect()->route('ingresar')->with('msg_activacion', ['danger', 'No existen datos con ese link.']);
        }        
    }

    public function recuperarPassword(){
        if( $this->request->isAJAX() ){
            $validation = \Config\Services::validation();

            $data = [
                'txtMailRec' => trim($this->request->getVar('txtMailRec'))
            ];

            $rules = [
                'txtMailRec' => [
                    'label' => 'Email', 
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'valid_email' => '* El {field} no es válido.'
                    ]
                ],
            ];

            $validation->setRules($rules);

            $msj = [];

            if( !$validation->run($data) ) {
                //print_r($validation->getErrors());
                $msj = ['danger', $validation->getErrors()['txtMailRec'] ];
            }else{
                if( !$this->modeloUsuario->existeEmail($data['txtMailRec']) ){
                    $msj = ['danger', 'El email no existe.' ];
                }else{
                    $usuario = $this->modeloUsuario->existeEmail($data['txtMailRec']);
                    if( $usuario['us_status'] == 2 ){
                        $msj = ['warning', 'Si cuenta aun no ha sido activada, revise correo.' ];
                    }else if( $usuario['us_status'] == 1 ){
                        $link_rec             = stringAleatorio(30, 0);
                        $dataMail['link_rec'] = base_url('nuevopassword')."-".$link_rec;
                        $dataMail['email']    = $usuario['us_email'];
                        if( help_sendMail(['anunciosdelvalle2024@gmail.com', 'Anuncios del Valle (ADV)'], $usuario['us_email'], 'Recupera tu contraseña', view('general/mailrecpass', $dataMail)) ){
                            if( $this->modeloUsuario->insert_link_rec($link_rec, $usuario['idusuario']) ){
                                $msj = ['success', 'Se le ha enviado un correo de recuperación a: <br>'.$data['txtMailRec'] ];
                                echo "<script>$('#txtMailRec').val('')</script>";
                            }                            
                        }
                    }                    
                }
            }

            echo '<div class="alert alert-'.$msj[0].' alert-dismissible fade show mt-2" role="alert">
                '.$msj[1].'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

        }
    }

    public function nuevopassword($link){
        $validation = \Config\Services::validation();

        $data = [
            'linkrec' => trim($link)
        ];

        $rules = [
            'linkrec' => [
                'label' => 'Link de Recuperación', 
                'rules' => 'required|alpha_numeric',
                'errors' => [
                    'required'    => '* El {field} es requerido.',
                    'alpha_numeric' => '* El {field} no es válido.'
                ]
            ]
        ];

        $validation->setRules($rules);
        
        $this->session->remove('msg_recup');

        if( !$validation->run($data) ) {
            //return print_r($validation->getErrors());
            //return redirect()->to(current_url())->with('msg_recup', ['danger', $validation->getErrors()['linkrec']]);
            $this->session->setFlashdata('msg_recup', ['danger', $validation->getErrors()['linkrec']]);
        }else{
            if( $usuario = $this->modeloUsuario->getUser_x_linkrec($link) ){
                $data['linkrec'] = $link;
                $data['usuario'] = $usuario;
            }else{
                $this->session->setFlashdata('msg_recup', ['danger', 'Ya no existe un link de recuperación.']);
            }
        }       

        $data['title']    = 'Nueva Contraseña';

        return view('general/formnuevopass', $data);

    }

    public function guardarNuevoPassword(){
        if( $this->request->isAJAX() ){
            $validation = \Config\Services::validation();
            //print_r($_POST);
            $data = [
                'nvoPass'     => trim($this->request->getVar('nvoPass')),
                'nvoPassConf' => trim($this->request->getVar('nvoPassConf')),
                'linkRec'     => trim($this->request->getVar('linkRec'))
            ];

            $rules = [
                'nvoPass' => [
                    'label' => 'Contraseña', 
                    'rules' => 'required|min_length[8]|max_length[15]',
                    'errors' => [
                        'required' => '* La {field} es requerida.',
                        'min_length' => '* La {field} debe tener al menos 8 caracteres.',
                        'max_length' => '* La {field} debe tener hasta 15 caracteres.'
                    ]
                ],
                'nvoPassConf' => [
                    'label' => 'Contraseña', 
                    'rules' => 'required|matches[nvoPass]',
                    'errors' => [
                        'required' => '* La {field} es requerida.',
                        'matches' => '* Las {field}s deben coincidir.'
                    ]
                ],
                'linkRec' => [
                    'label' => 'Link de Recuperación', 
                    'rules' => 'required|alpha_numeric',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'alpha_numeric' => '* El {field} no es válido.'
                    ]
                ]
            ];

            $validation->setRules($rules);

            if (!$validation->run($data)) {
                return $this->response->setJson(['errors' => $validation->getErrors()]); 
            }

            $hash = '$2a$12$YmtIBS/VsxVywSQHV4A2.upBWJxS2VSqFzUwo1eMU5.tIGOgne6YG';
            $password = crypt($data['nvoPass'], $hash);

            if( $usuario = $this->modeloUsuario->getUser_x_linkrec($data['linkRec']) ){
                if( $this->modeloUsuario->actualizarPassword_x_quitaLinkRec($usuario['idusuario'], $password) ){
                    echo '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        <b>Su contraseña fue actualizada.</b> Ya puede iniciar sesión.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            }else{
                echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    Usted ya ha actualizado su contraseña.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }

        }
    }

    public function agregarFavorito(){
        if( $this->request->isAJAX() ){
            //$validation = \Config\Services::validation();
            //print_r($_POST);
            if( !session('idusuario') ){
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <b>Tiene que iniciar sesión.</b>
                </div>';
                exit();
            }

            $idanuncio = $this->request->getVar('id');

            $fav = $this->modeloAnuncio->existeFavorito(session('idusuario'), $idanuncio);
            if( $fav['total'] > 0 ){
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <b>Ud. Ya agregó éste anuncio como favorito.</b>
                </div>';
                exit();
            }

            if( $this->modeloAnuncio->agregarFavorito(session('idusuario'), $idanuncio) ){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <b>Anuncio agregado como favorito.</b>
                </div>';
            }
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
            $anunciosDisponiblesUsados = $this->modeloAnuncio->countAnunciosDisponiblesUsados(session('idusuario'));
            $anunciosenLista           = $this->modeloAnuncio->countAnunciosUsuarioPorEstados(session('idusuario'),[1,2,3,4,5,6])['total'];
            $anunciosEliminados        = $this->modeloAnuncio->countAnunciosUsuarioPorEstados(session('idusuario'),[7])['total'];

            $data['anunciosDisponiblesUsados'] = $anunciosDisponiblesUsados;
            $data['anunciosEliminados']        = $anunciosEliminados;
            $data['anunciosenLista']           = $anunciosenLista;

            $listPrecios = $this->modeloAnuncio->listPrecios('anu');
            $data['preciosAnuncios'] = $listPrecios;

            return view('panel/usuario/index', $data);
        }        
    }
}

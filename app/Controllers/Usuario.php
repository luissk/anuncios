<?php

namespace App\Controllers;

class Usuario extends BaseController
{
    protected $modeloUsuario;
    protected $modeloUbigeo;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->modeloUbigeo  = model('UbigeoModel');
        $this->session;
    }

    public function index(){}

    public function micuenta(){ //PARA ADMIN Y USUARIO
        if( !session('idusuario') ){
            return redirect()->to('/');
        }

        $usuario    = $this->modeloUsuario->getUsuarioPorId(session('idusuario'));
        $provincias = $this->modeloUbigeo->listarProvincias();

        $data['title']       = 'Mi Cuenta';
        $data['opt_account'] = 1;
        $data['usuario']     = $usuario;
        $data['provincias']  = $provincias;

        return view('panel/micuenta', $data);
    }

    public function listarDistritosUsuario(){
        if( $this->request->isAJAX() ){
            if(!session('idusuario')){
                exit();
            }

            $idprov    = trim($this->request->getVar('idprov'));
            $iddist_bd = trim($this->request->getVar('iddist_bd'));

            if( $distritos = $this->modeloUbigeo->listarDistritos($idprov) ){
                echo "<option value = ''>Seleccione</option>";
                foreach($distritos as $dist){
                    $iddist   = $dist['iddist'];
                    $distrito = $dist['dist'];

                    $selected_dist = $iddist == $iddist_bd ? 'selected' : '';
                    echo "<option value = '$iddist' $selected_dist>$distrito</option>";
                }
            }else{
                echo "<option value = ''>Seleccione</option>";
            }
        }
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
                        'min_length' => '* El {field} debe tener al menos 8 caracteres.',
                        'max_length' => '* El {field} debe tener hasta 15 caracteres.'
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
                    'rules' => 'permit_empty|alpha_numeric|max_length[2]',
                    'errors' => [
                        'alpha_numeric' => '* La {field} no es válido.',
                        'max_length'    => '* La {field} debe contener máximo 2 caracteres.'
                    ]
                ],
                'distrito' => [
                    'label' => 'Distrito', 
                    'rules' => 'permit_empty|required_with[provincia]|alpha_numeric|max_length[2]',
                    'errors' => [
                        'alpha_numeric' => '* El {field} no es válido.',
                        'max_length'    => '* El {field} debe contener máximo 2 caracteres.',
                        'required_with' => '* El {field} es requerido.',
                    ]
                ],
                'web' => [
                    'label' => 'Sito Web', 
                    'rules' => 'permit_empty|valid_url_strict|max_length[150]',
                    'errors' => [
                        'max_length'       => '* Máximo 150 caracteres.',
                        'valid_url_strict' => '* La URL es inválida.',
                    ]
                ],
                'instagram' => [
                    'label' => 'Instagram', 
                    'rules' => 'permit_empty|valid_url_strict|max_length[150]',
                    'errors' => [
                        'max_length'       => '* Máximo 150 caracteres.',
                        'valid_url_strict' => '* La URL es inválida.',
                    ]
                ],
                'facebook' => [
                    'label' => 'Facebook', 
                    'rules' => 'permit_empty|valid_url_strict|max_length[150]',
                    'errors' => [
                        'max_length'       => '* Máximo 150 caracteres.',
                        'valid_url_strict' => '* La URL es inválida.',
                    ]
                ],
                'youtube' => [
                    'label' => 'Youtube', 
                    'rules' => 'permit_empty|valid_url_strict|max_length[150]',
                    'errors' => [
                        'max_length'       => '* Máximo 150 caracteres.',
                        'valid_url_strict' => '* La URL es inválida.',
                    ]
                ],
                'tiktok' => [
                    'label' => 'Tiktok', 
                    'rules' => 'permit_empty|valid_url_strict|max_length[150]',
                    'errors' => [
                        'max_length'       => '* Máximo 150 caracteres.',
                        'valid_url_strict' => '* La URL es inválida.',
                    ]
                ],
                'avatar' => [
                    'label' => 'Avatar', 
                    'rules' => 'permit_empty|uploaded[avatar]|max_size[avatar,2048]|mime_in[avatar,image/jpg,image/jpeg]',
                    'errors' => [
                        'max_size' => '* La imagen no deber ser mayor a 2 MB.',
                        'mime_in'  => '* La extensión es inválida.',
                    ]
                ]
            ]);

            $data = [
                'nombre'    => trim($this->request->getVar('nombre')),
                'dniruc'    => trim($this->request->getVar('dniruc')),
                'telefono'  => trim($this->request->getVar('telefono')),
                'password'  => trim($this->request->getVar('password')),
                'whatsapp'  => trim($this->request->getVar('whatsapp')),
                'direccion' => trim($this->request->getVar('direccion')),
                'provincia' => trim($this->request->getVar('provincia')),
                'distrito'  => trim($this->request->getVar('distrito')),
                'web'       => trim($this->request->getVar('web')),
                'facebook'  => trim($this->request->getVar('facebook')),
                'youtube'   => trim($this->request->getVar('youtube')),
                'instagram' => trim($this->request->getVar('instagram')),
                'tiktok'    => trim($this->request->getVar('tiktok')),
                'avatar'    => $this->request->getFile('avatar'),
            ];

            if (!$validation->run($data)) {
                return $this->response->setJson(['errors' => $validation->getErrors()]); 
            }

            $us = $this->modeloUsuario->getUsuarioPorId(session('idusuario'));

            //password
            if( $data['password'] != '' ){
                $hash = '$2a$12$YmtIBS/VsxVywSQHV4A2.upBWJxS2VSqFzUwo1eMU5.tIGOgne6YG';
                $password = crypt($data['password'], $hash);
            }else{                
                $password = $us['us_pass'];
            }
            $data['password'] = $password;               
            
            //ubigeo
            $data['ubigeo'] = '';
            if( $data['provincia'] != '' && $data['distrito'] != '' ){
                $ubi = $this->modeloUbigeo->getUbigeo($data['distrito'], $data['provincia']);
                $data['ubigeo'] = $ubi['idubigeo'];
            }

            //avatar
            $ava_nombre = $us['us_avatar'];
            if( $data['avatar']->getError() === 0 ){
                $avatar = $data['avatar'];

                //$ava_nombre = $avatar->getRandomName();
                $ava_ext    = $avatar->getClientExtension();
                $ava_nombre = $us['us_codusuario'].'.'.$ava_ext;
                $ava_folder = "public/images/avatar/";

                $image = \Config\Services::image();
                $image->withFile($avatar)
                    ->resize(200, 200, true, 'width')
                    ->save($ava_folder.$ava_nombre);
            }
            $data['ava_nombre'] = $ava_nombre;

            if( $this->modeloUsuario->modificarDatosUsuario(session('idusuario'), $data) ){
                echo '<script>
                    Swal.fire({
                        title: "Datos Actualizados.",
                        text: "",
                        icon: "success",
                        showConfirmButton: false,
                    });
                    setTimeout(function(){ location.reload() },1500);
                </script>';
            }else{
                echo '<script>
                    Swal.fire({
                        title: "Algo salió mal",
                        icon: "error"
                    });
                </script>';
            }
        }
    }

    public function eliminarAvatarUsuario(){
        if( $this->request->isAJAX() ){
            if(!session('idusuario')){
                exit();
            }

            $ava_folder = "public/images/avatar/";
            $ava_nombre = trim($this->request->getVar('avatar'));

            if( $this->modeloUsuario->eliminarAvatar(session('idusuario')) ){
                if( unlink($ava_folder.$ava_nombre) ){
                    echo '<script>
                        Swal.fire({
                            text: "Se eliminó el avatar",
                            icon: "success",
                            showConfirmButton: false,
                        });
                        setTimeout(function(){ location.reload() },1500);
                    </script>';
                } 
            }
        }
    }

}

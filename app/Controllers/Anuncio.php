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
        $this->modeloAnuncio = model('AnuncioModel');
        $this->session;
    }

    public function index(){}

    public function misAnuncios($page = 1){
        if( !session('idusuario') ){
            return redirect()->to('/');
        }

        if( session('idtipousu') == 1 ){
            $nombre = '';
            if( $this->request->is('get') && $this->request->getGet('nombre') ){ 
                //if( !is_int($page) ) return redirect()->to('/');
                //print_r($this->request->getGet('nombre'));
                $dato = [
                    'nombre' => trim($this->request->getVar('nombre'))
                ];
                $validation = \Config\Services::validation();
                $rules = [
                    'nombre' => [
                        'label' => 'Nombre', 
                        'rules' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ. 0-9]+$/]|max_length[100]',
                        'errors' => [
                            'required'    => '* El {field} es requerido.',
                            'regex_match' => '* El {field} no es válido.',
                            'max_length'  => '* El {field} debe contener máximo 100 caracteres.'
                        ]
                    ],
                ];
                $validation->setRules($rules);
                if (!$validation->run($dato)) {
                    return redirect()->back()->with('errors', $validation->getErrors())->withInput();
                }
            }
            $nombre = trim($this->request->getVar('nombre'));
            /* $uri = service('uri'); 
            print_r( $uri->getSegments() ); */

            $desde        = $page * 10 - 10;
            $hasta        = 10;
            $data['page'] = $page;

            $data['anuncios']       = $this->modeloAnuncio->listarAnunciosAdmin($desde, $hasta, $nombre);
            $data['totalRegistros'] = $this->modeloAnuncio->countListarAnunciosAdmin($nombre)['total'];

            $view = 'panel/administrador/anuncios';
        }else if( session('idtipousu') == 2 ){
            $nombre = '';
            if( $this->request->is('get') && $this->request->getGet('nombre') ){ 
                //if( !is_int($page) ) return redirect()->to('/');
                //print_r($this->request->getGet('nombre'));
                $dato = [
                    'nombre' => trim($this->request->getVar('nombre'))
                ];
                $validation = \Config\Services::validation();
                $rules = [
                    'nombre' => [
                        'label' => 'Nombre', 
                        'rules' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ. 0-9]+$/]|max_length[100]',
                        'errors' => [
                            'required'    => '* El {field} es requerido.',
                            'regex_match' => '* El {field} no es válido.',
                            'max_length'  => '* El {field} debe contener máximo 100 caracteres.'
                        ]
                    ],
                ];
                $validation->setRules($rules);
                if (!$validation->run($dato)) {
                    return redirect()->back()->with('errors', $validation->getErrors())->withInput();
                }
            }
            $nombre = trim($this->request->getVar('nombre'));
            /* $uri = service('uri'); 
            print_r( $uri->getSegments() ); */

            $desde        = $page * 10 - 10;
            $hasta        = 10;
            $data['page'] = $page;

            $data['anuncios']       = $this->modeloAnuncio->listarAnunciosUsuario(session('idusuario'), $desde, $hasta, $nombre);
            $data['totalRegistros'] = $this->modeloAnuncio->countListarAnunciosUsuario(session('idusuario'), $nombre)['total'];
            $view = 'panel/usuario/anuncios';
        }

        $data['title']        = 'Mis Anuncios';
        $data['opt_anuncios'] = 1;

        return view($view, $data);
    }

    public function publicarAnuncio($idanuncio = ''){
        if( !session('idusuario') ){
            return redirect()->to('ingresar');
        }

        if( session('idtipousu') == 1 ){
            return redirect()->to('panel-usuario');
        }

        $data['title'] = 'Nuevo Anuncio';

        if( $idanuncio != '' ){
            if( $anuncio = $this->modeloAnuncio->getAnu_idanu_idusu(session('idusuario'), $idanuncio) ){
                $data['anuncio'] = $anuncio;
                $data['images']  = $this->modeloAnuncio->getImages($idanuncio);
                $data['title']   = 'Modificar Anuncio';
            }else{
                return redirect()->to('panel-usuario');
            }
        }

        $tipos      = $this->modeloAnuncio->listarTipos();
        $categorias = $this->modeloAnuncio->listarCategorias();

        $provincias = $this->modeloUbigeo->listarProvincias();

        $us = $this->modeloUsuario->getUsuarioPorId(session('idusuario'));

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

    public function CrearAnuncio(){
        if( $this->request->isAJAX() ){
            if(!session('idusuario')){
                exit();
            }

            $codanuncio = stringAleatorio(10);

            //para editar
            $idanuncio_post = $this->request->getVar('idanuncio');
            if( $idanuncio_post != '' && $this->modeloAnuncio->getAnu_idanu_idusu(session('idusuario'), $idanuncio_post) ){
                $bd_anuncio = $this->modeloAnuncio->getAnu_idanu_idusu(session('idusuario'), $idanuncio_post);
                $codanuncio = $bd_anuncio['codanuncio']; //reemplazamos codigo anuncio
            }else if( $idanuncio_post != '' && !$this->modeloAnuncio->getAnu_idanu_idusu(session('idusuario'), $idanuncio_post) ){
                echo '<script>
                    Swal.fire({
                        title: "EL ANUNCIO NO EXISTE",
                        text: "",
                        icon: "error",
                        showConfirmButton: false,
                    });
                    setTimeout(function(){ location.href="'.base_url('mis-anuncios').'" },1500);
                </script>';
                exit();
            }
            //fin para editar           
            
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
                'imagenes'        => $this->request->getFileMultiple('imagenes'),
                'idanuncio'       => trim($this->request->getVar('idanuncio')),
            ];

            $rules = [
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
                    'rules' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ. 0-9]+$/]|max_length[100]',
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
                        'max_length'  => '* La {field} debe contener máximo 4000 caracteres.'
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
                'imagenes[]' => [
                    'label' => 'Imágenes', 
                    'rules' => 'uploaded[imagenes.0]|max_size[imagenes,3072]|mime_in[imagenes,image/jpg,image/jpeg]',
                    'errors' => [
                        'uploaded' => '* Debe seleccionar al menos 1 imagen.',
                        'max_size' => '* La imagen no deber ser mayor a 3 MB.',
                        'mime_in'  => '* La extensión es inválida.',
                    ]
                ]
            ];            
            
            $countFiles = count(array_filter($_FILES['imagenes']['name']));
            if( $countFiles > 5 ){//agregar validación para las imágenes
                $validation->setError('imagenes[]', 'Máximo 5 Imágenes.');
            }

            //validación solo cuando de edita
            if( isset($bd_anuncio) && $bd_anuncio ){
                $arr_images = $this->request->getVar('arr_images');
                if( $arr_images != '' ){
                    $arr_img = json_decode($arr_images, true);
                    if( count($arr_img) > 5 ){//agregar validación para las imágenes
                        $validation->setError('imagenes[]', 'Máximo 5 Imágenes.');
                    }

                    if( count($arr_img) > 0 ){//si en el array no esta vacío no es obligatorio (uploaded)
                        $rules['imagenes[]']['rules'] = 'max_size[imagenes,3072]|mime_in[imagenes,image/jpg,image/jpeg]';
                    }
                }
            }
            //fin de validación cuando se edita

            $validation->setRules($rules);
            
            if (!$validation->run($data)) {                
                return $this->response->setJson(['errors' => $validation->getErrors()]); 
            }

            //PRECIO
            if( $data['nomostrar'] ){
                $data['nomostrar'] = 1;
            }else{
                $data['nomostrar'] = 0;
            }

            //CARACTERISTICAS
            /* echo nl2br($data['caracteristicas'])."<hr>";
            $arr_caract = explode("\r\n", $data['caracteristicas']);*/

            //UBIGEO
            $data['ubigeo'] = '';
            if( $data['provincia'] != '' && $data['distrito'] != '' ){
                $ubi = $this->modeloUbigeo->getUbigeo($data['distrito'], $data['provincia']);
                $data['ubigeo'] = $ubi['idubigeo'];
            }

            //CODIGO ANUNCIO
            $data['codanuncio'] = $codanuncio;

            if( isset($bd_anuncio) && $bd_anuncio ){ //EDITAR

                if( $this->modeloAnuncio->modificarAnuncio(session('idusuario'), $idanuncio_post, $data) ){
                    $ready = FALSE;
                    
                    $images_bd = $this->modeloAnuncio->getImages($idanuncio_post);
                   /*  print_r($arr_img);
                    print_r($images_bd);
                    print_r($data['imagenes']); */

                    //0. Define un contador de las img que quedaran, para sacar su indice y colocar como principal
                    $cont_imgs = 0;
                    //0.1 Obtenemos en que indice del array de imagenes, esta la img principal
                    $idx_principal = 0;
                    foreach( $arr_img as $k => $v ){
                        if( $v['principal'] == 1 )
                            $idx_principal = $k;
                    }

                    $micarpeta = help_folderAnuncio().$codanuncio;
                    //1. verificamos si las img de la base de datos aun se mantienen en el array de iamgenes, sino las borramos
                    foreach( $images_bd as  $imbd ){
                        if( !in_array($imbd['idimages'], array_column($arr_img, 'id')) ){
                            if( $this->modeloAnuncio->eliminarImgPorId($imbd['idimages'], $idanuncio_post) ){
                                unlink($micarpeta."/".$imbd['img']);
                                unlink($micarpeta."/".$imbd['img_thumb']);
                            }
                        }else{
                            if( $cont_imgs == $idx_principal ){ //verificar si es principal
                                $this->modeloAnuncio->quitarPrincipalesImg_IdAnuncio($idanuncio_post);
                                $this->modeloAnuncio->hacerPrincipalImg_idImg_idAnu($imbd['idimages'], $idanuncio_post);
                            }
                            $cont_imgs++;
                        }
                        $ready = TRUE;
                    }

                    //2. vemos si hay nuevas imagenes para agregar
                    if( $countFiles > 0 ){
                        foreach( $data['imagenes'] as $i => $img ){
                            /* echo $i." Subir imágen<br>\n";
                            echo $cont_imgs == $idx_principal ? "Es Principal<br>\n": ''; */
                            $rnd_name         = $img->getRandomName();
                            $nombre_img       = $rnd_name;
                            $nombre_img_thumb = "thumb_".$rnd_name;
        
                            $ruta_completa       = "$micarpeta/$nombre_img";
                            $ruta_completa_thumb = "$micarpeta/$nombre_img_thumb";
        
        
                            $image = \Config\Services::image();
                            $image->withFile($img)
                                ->resize(700, 600, true, 'height')
                                ->save($ruta_completa);
        
                            $image->withFile($img)
                                ->resize(350, 350, true, 'width')
                                ->save($ruta_completa_thumb);
        
                            $check_principal = 0;
                            if( $cont_imgs == $idx_principal ){
                                $check_principal = 1;
                            }
                            
                            if( $this->modeloAnuncio->insertarImagenes($idanuncio_post, $nombre_img, $nombre_img_thumb, $check_principal) )
                                $ready = TRUE;

                            $cont_imgs++;
                        }
                    }
                    //echo $cont_imgs." - ".$idx_principal;
                    if( $ready ){
                        echo '<script>
                            Swal.fire({
                                title: "ANUNCIO MODIFICADO.",
                                text: "",
                                icon: "success",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            setTimeout(function(){ location.href="'.base_url('mis-anuncios').'" },1500);
                        </script>';
                    }
                    
                }

            }else{// INSERTAR

                if( $idanuncio = $this->modeloAnuncio->crearAnuncio(session('idusuario'), $data) ){

                    //IMAGENES            
                    //IMAGEN PRINCIPAL
                    $image_principal = $this->request->getVar('arr_images');
                    $arr_img = json_decode($image_principal, true);
    
                    $idx_principal = 0; //para marcar que imagen es la principal por el orden, sacando el indice
                    foreach( $arr_img as $k => $v ){
                        if( $v['principal'] == 1 )
                            $idx_principal = $k;
                    }
    
                    $micarpeta = help_folderAnuncio().$codanuncio;
                    if (!file_exists($micarpeta)) {
                        mkdir($micarpeta, 0777, true);
                    }
                    
                    $ready = FALSE;
                    foreach( $data['imagenes'] as $i => $img ){
                        $rnd_name         = $img->getRandomName();
                        $nombre_img       = $rnd_name;
                        $nombre_img_thumb = "thumb_".$rnd_name;
    
                        $ruta_completa       = "$micarpeta/$nombre_img";
                        $ruta_completa_thumb = "$micarpeta/$nombre_img_thumb";
    
    
                        $image = \Config\Services::image();
                        $image->withFile($img)
                            ->resize(700, 600, true, 'height')
                            ->save($ruta_completa);
    
                        $image->withFile($img)
                            ->resize(350, 350, true, 'width')
                            ->save($ruta_completa_thumb);
    
                        $check_principal = 0;
                        if( $i == $idx_principal ){
                            $check_principal = 1;
                        }
                        
                        if( $this->modeloAnuncio->insertarImagenes($idanuncio, $nombre_img, $nombre_img_thumb, $check_principal) )
                            $ready = TRUE;
                    }
    
                    if( $ready ){
                        echo '<script>
                            Swal.fire({
                                title: "ANUNCIO CREADO.",
                                text: "",
                                icon: "success",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            setTimeout(function(){ location.href="'.base_url('mis-anuncios').'" },1500);
                        </script>';
                    }
                }

            }        

            //print_r($data);
            //print_r($_POST);
            //print_r($this->request->getFiles('imagenes'));
        }
    }

    public function eliminarAnuncioPorUsuario(){
        if( $this->request->isAJAX() ){
            if(!session('idusuario')){
                exit();
            }

            $idanuncio_post = $this->request->getVar('id');
            if( $idanuncio_post != '' && $this->modeloAnuncio->getAnu_idanu_idusu(session('idusuario'), $idanuncio_post) ){
                $bd_anuncio = $this->modeloAnuncio->getAnu_idanu_idusu(session('idusuario'), $idanuncio_post);
                $codanuncio = $bd_anuncio['codanuncio'];

                //PENDIENTE: VALIDAR SI ES QUE NO TIENE PAGOS (DESTACADO)
                
                $micarpeta = help_folderAnuncio().$codanuncio;

                //eliminar imagenes
                $images_bd = $this->modeloAnuncio->getImages($idanuncio_post);
                foreach( $images_bd as $im){
                    $idimg = $im['idimages'];
                    $img   = $micarpeta."/".$im['img'];
                    $thumb = $micarpeta."/".$im['img_thumb'];

                    if( file_exists($img) ) unlink($img);
                    if( file_exists($thumb) ) unlink($thumb);
                }
                $this->modeloAnuncio->eliminarImgPorIdAnuncio($idanuncio_post); //eliminar de la bd
                //eliminar carpeta
                if( file_exists($micarpeta) ){
                    rmdir($micarpeta);
                }

                if( $this->modeloAnuncio->eliminarAnuncio($idanuncio_post) ){
                    echo '<script>
                        Swal.fire({
                            title: "ANUNCIO ELIMINADO.",
                            text: "",
                            icon: "success",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        });
                        setTimeout(function(){ location.href="'.base_url('mis-anuncios').'" },1500);
                    </script>';
                }
            }else{
                echo '<script>
                    Swal.fire({
                        title: "EL ANUNCIO NO EXISTE",
                        text: "",
                        icon: "error",
                        showConfirmButton: false,
                    });
                </script>';
                exit();
            }
        }
    }

    

    public function detalleAnuncioAdmin($idanuncio){
        if( !session('idusuario') ){
            return redirect()->to('/');
        }

        if( session('idtipousu') != 1 ){
            return redirect()->to('/');
        }

        if( $anuncio = $this->modeloAnuncio->getAnu_idanu($idanuncio) ){

            $images_bd = $this->modeloAnuncio->getImages($idanuncio);

            $data['title']        = 'Detalle del anuncio';
            $data['opt_anuncios'] = 1;
            $data['anuncio']      = $anuncio;
            $data['imagenes']     = $images_bd;

            return view('panel/administrador/anuncio_detalle', $data);
        }else{
            return redirect()->to('mis-anuncios')->with('msj_detalle', 'No existe el anuncio');
        }
    }

    public function activarObservarAnuncio(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ){
                exit();
            }
    
            if( session('idtipousu') != 1 ){
                exit();
            }

            $idanuncio = trim($this->request->getVar('id'));
            $opt       = trim($this->request->getVar('opt'));
            $motivo    = trim($this->request->getVar('motivo'));

            if( $opt == 2 && $motivo == '' ){
                echo "*Ingrese un motivo.";
            }else{
                if( $anuncio = $this->modeloAnuncio->getAnu_idanu($idanuncio) ){

                    $idestado   = $anuncio['an_status'];
                    $activo     = $anuncio['an_activo']; //si es que ya ha sido activado
                    $estado_ant = $anuncio['estado_ant'];//estado anterior, esto es cuando el admin ya lo observó antes

                    if( $opt == 1 ){//Activar
                        //si ya ha sido activado, cambiar de estado, borrar observacion y borrar estado anterior
                        if( $idestado == 6 && $activo == 1 ){
                            //echo "solo activar y borrar observacion";
                            if( $this->modeloAnuncio->activarAnuncio($idanuncio, $estado_ant, $activo, session('idusuario')) ){
                                echo '<script>
                                    Swal.fire({
                                        title: "ANUNCIO ACTIVADO.",
                                        text: "",
                                        icon: "success",
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                    });
                                    setTimeout(function(){ location.reload() },1500);
                                </script>';
                            }
                            exit();
                        }
                        //si no estaba activado, cambiar de estado, borrar observacion, borrar estado anterior y agregarle su fecha de activo y hasta la fecha que esta activo 30 días
                        if( in_array($idestado, [1, 6]) && $activo != 1 ){
                            //echo "activar por primera vez";
                            if( $this->modeloAnuncio->activarAnuncio($idanuncio, 2, $activo, session('idusuario')) ){
                                echo '<script>
                                    Swal.fire({
                                        title: "ANUNCIO ACTIVADO.",
                                        text: "",
                                        icon: "success",
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                    });
                                    setTimeout(function(){ location.reload() },1500);
                                </script>';
                            }
                            exit();
                        }

                        echo "NADA QUE HACER";
                    }else if( $opt == 2 ){//Observar
                        //echo "observar joder";
                        if( in_array($idestado, [1, 2, 4, 5]) ){
                            if( $this->modeloAnuncio->observarAnuncio($idanuncio, 6, $motivo, $idestado) ){
                                echo '<script>
                                    Swal.fire({
                                        title: "ANUNCIO OBSERVADO.",
                                        text: "",
                                        icon: "success",
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                    });
                                    setTimeout(function(){ location.reload() },1500);
                                </script>';
                            }
                        }
                        exit();
                    }
                }else{
                    echo "* EL ANUNCIO NO EXISTE!";
                }
            }
        }
    }


}
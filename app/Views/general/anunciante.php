<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

<?php
/* echo "<pre>";
print_r($usuario);
echo "</pre>"; */

$idusuario   = $usuario['idusuario'];
$codusuario  = $usuario['us_codusuario'];
$email       = $usuario['us_email'];
$nombrerazon = $usuario['us_nombre_razon'];
$ruc         = $usuario['us_ruc'];
$telefono    = $usuario['us_telefono'];
$avatar      = $usuario['us_avatar'];
$whatsapp    = $usuario['us_whatsapp'];
$website     = $usuario['us_website'];
$facebook    = $usuario['us_facebook'];
$instagram   = $usuario['us_instagram'];
$tiktok      = $usuario['us_tiktok'];
$youtube     = $usuario['us_youtube'];
$direccion   = $usuario['us_direccion'];

$img_avatar = $avatar == '' ? 'default.jpg': $avatar;


$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$nombre_page = $nombre != '' ? "?nombre=".$nombre : '';

$uri = new \CodeIgniter\HTTP\URI(current_url(). ($_SERVER['QUERY_STRING'] != '' ? "?".$_SERVER['QUERY_STRING'] : ''));
//echo $uri;

if( isset($_GET['page']) ){
    $uri->stripQuery('page');
}
?>

<div class="container my-3">
    <div class="row">
        <div class="col-sm-12 mt-2 pb-2">
            <div class="card mb-3 border-0 border-bottom">
                <div class="d-flex flex-wrap">
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="anunciante-<?=help_reemplazaCaracterUrl($nombrerazon)?>-<?=$idusuario?>" target="_blank"><img src="public/images/avatar/<?=$img_avatar?>" class="object-fit-cover" alt="avatar" style="max-width: 150px; max-height: 100%"></a>
                    </div>
                    <div class="">
                        <div class="card-body">
                            <h5 class="card-title"><?=$nombrerazon?></h5>
                            <p class="card-text">
                                <small class="fs-6">
                                    <?php if($whatsapp != ''){?><i class="fab fa-whatsapp-square"></i> <?=$whatsapp?> &nbsp;<?php }?>
                                    <?php if($telefono != ''){?><i class="fas fa-phone-square-alt"></i> <?=$telefono?><?php }?>
                                </small><br>
                                <small class="fs-6">
                                    <?php if($website != ''){?><a href="<?=$website?>" target="_blank" class="text-decoration-none text-body"><i class="fas fa-globe"></i> sitio web</a> &nbsp;<?php }?>
                                    <?php if($facebook != ''){?><a href="<?=$facebook?>" target="_blank" class="text-decoration-none text-body"><i class="fab fa-facebook-square"></i> facebook</a> &nbsp;<?php }?>
                                    <?php if($instagram != ''){?><a href="<?=$instagram?>" target="_blank" class="text-decoration-none text-body"><i class="fab fa-instagram-square"></i> instagram</a> &nbsp;<?php }?>
                                    <?php if($tiktok != ''){?><a href="<?=$tiktok?>" target="_blank" class="text-decoration-none text-body"><i class="fab fa-tiktok"></i> tiktok</a> &nbsp;<?php }?>
                                    <?php if($youtube != ''){?><a href="<?=$youtube?>" target="_blank" class="text-decoration-none text-body"><i class="fab fa-youtube-square"></i> Youtube</a> &nbsp;<?php }?>
                                </small><br>
                                <?php if($direccion != ''){?><small class="text-body"><i class="fas fa-map-marker-alt"></i> <?=$direccion?></small><br><?php }?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-sm-12">
            <h4 class="text-center">Anuncios</h4>
        </div>
    </div> -->
    <div class="row mt-3">
        <div class="col-sm-12 col-md-6">
            <form method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control rounded-0" placeholder="Buscar por nombre de anuncio" id="txtBuscarMiAviso" name="nombre" value="<?=$nombre?>" autocomplete="off">
                    <button class="btn btn-success rounded-0" id="btnBuscarMiAviso" >BUSCAR</button>
                </div>
            </form>
            <p class="text-danger" id="msj-nombre"><?=session('errors.nombre')?></p>
        </div>
        <div class="col-sm-12 col-md-6 text-end">
            Avisos: <span class="badge text-bg-secondary"><?=$totalRegistros?></span>
        </div>
    </div>
</div>

<section class="container resultado">
    <?php
    /* echo "<pre>"; 
    print_r($anuncios);
    echo "</pre>"; */
    if( $anuncios ){
        foreach( $anuncios as $anu ){
            $idanuncio   = $anu['idanuncio'];
            $codanuncio  = $anu['codanuncio'];
            $anunciodesc = $anu['anunciodesc'];
            $nombre      = $anu['an_nombre'];
            $idcate      = $anu['idcate'];
            $categoria   = $anu['categoria'];
            $img_thumb   = $anu['img_thumb']; 
            $idtipo      = $anu['idtipo_anuncio'];
            $tipo        = $anu['ta_tipo'];
            $direccion   = $anu['direccion'];
            $prov        = $anu['prov'];
            $dist        = $anu['dist'];
            $precio      = $anu['precio'];

            $img = help_folderAnuncio().$codanuncio."/".$img_thumb;

            $url = help_reemplazaCaracterUrl($nombre)."-".$idanuncio;
    ?>

    <div class="resultado__item mb-4">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 resultado__item--img text-center">
                <a  target="_blank"href="<?=base_url('anuncio-'.$url.'')?>"><img src="<?=$img?>" alt="<?=$nombre?>" class=""></a>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-9 resultado__item--content py-2 px-3">
                <div class="resultado__item--title fw-bolder text-success">
                    <a  target="_blank"href="<?=base_url('anuncio-'.$url.'')?>" class="text-decoration-none text-primary"><?=$nombre?></a>
                </div>
                <div class="resultado__item--desc pt-2 text-secondary">
                    <?=strlen($anunciodesc) > 200 ? $anunciodesc."..." : $anunciodesc?>
                </div>
                <div class="resultado__item--ubi text-truncate text-secondary pt-2 fs-12px">
                    <span> <?=$direccion?></span>
                    <br>
                    <span class="fs-12px fst-italic"><i class="fas fa-map-marker-alt"></i> <?=$dist?>, <?=$prov?></span>
                </div>
                <div class="row">
                    <div class="col-sm-4 resultado__item--aditional text-secondary pt-2 fs-12px">
                        <i class="fas fa-angle-right"></i> <?=$tipo?> <i class="fas fa-caret-right"></i> <?=$categoria?>
                    </div>
               
                    <div class="col-sm-4 text-secondary text-center fw-bolder">
                        <?=$precio > 0 ? "S/. ".number_format($precio, 2) : ''?>
                    </div>
                    <div class="col-sm-4 text-end pe-4">
                        <a target="_blank" href="<?=base_url('anuncio-'.$url.'')?>" class="btn btn-success rounded-0" title="ver detalle">Detalle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        }

        $RegistrosAMostrar = 20;
        $PaginasIntervalo  = 2;
        $PagAct            = $page;

        $PagUlt = $totalRegistros / $RegistrosAMostrar;
        $res    = $totalRegistros % $RegistrosAMostrar;
        if( $res > 0 ) $PagUlt = floor($PagUlt) + 1;
        ?>

        <nav>
            <ul class="pagination justify-content-end <?=$totalRegistros <= 20 ? 'd-none' : ''?>">
                <li class="page-item <?=$PagAct > ($PaginasIntervalo + 1) ? '' : 'd-none'?>">
                    <a class="page-link" href="<?=$uri->addQuery('page', '1')?>">Primer</a>
                </li>
                <?php
                for ( $i = ($PagAct - $PaginasIntervalo) ; $i <= ($PagAct - 1) ; $i ++) {
                    if($i >= 1) {
                        echo "<li class='page-item'><a class='page-link' href='".$uri->addQuery('page', $i)."'>$i</a></li>";
                    }
                }
                ?>
                <li class="page-item"><a class="page-link active"><?=$PagAct?></a></li>
                <?php
                for ( $i = ($PagAct + 1) ; $i <= ($PagAct + $PaginasIntervalo) ; $i ++) {
                    if( $i <= $PagUlt) {
                        echo "<li class='page-item'><a class='page-link' href='".$uri->addQuery('page', $i)."'>$i</a></li>";
                    }
                }
                ?>          
                <li class="page-item <?=$PagAct < ($PagUlt - $PaginasIntervalo) ? '' : 'd-none'?>">
                    <a class="page-link" href="<?=$uri->addQuery('page', $PagUlt)?>">Ultimo</a>
                </li>
            </ul>
        </nav>


    <?php
    }
    ?>
</section>


<?php echo $this->endSection();?>
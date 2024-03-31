<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

<?php
/* echo "<pre>"; 
print_r($anuncio);
print_r($imagenes);
echo "</pre>"; */
$bd_idanuncio       = $anuncio['idanuncio'];
$bd_nombre          = $anuncio['an_nombre'];
$bd_idtipo          = $anuncio['idtipo_anuncio'];
$bd_idcate          = $anuncio['idcate'];
$bd_precio          = $anuncio['precio'];
$bd_mostrar         = $anuncio['precio_mostrar'];
$bd_codanuncio      = $anuncio['codanuncio'];
$bd_caracteristicas = $anuncio['caracteristicas'];
$bd_descripcion     = $anuncio['an_descripcion'];
$bd_urlvideo        = $anuncio['url_video'];
$bd_direccion       = $anuncio['direccion'];
$bd_contactemail    = $anuncio['contact_email'];
$bd_contactfono     = $anuncio['contact_fono'];
$bd_contactwhatsapp = $anuncio['contact_whatsapp'];
$bd_idprov          = $anuncio['idprov'];
$bd_iddist          = $anuncio['iddist'];
$bd_prov            = $anuncio['prov'];
$bd_dist            = $anuncio['dist'];
$bd_idestado        = $anuncio['an_status'];
$bd_estado          = $anuncio['estado'];
$bd_observadopor    = $anuncio['observadopor'];
$bd_usuemail        = $anuncio['us_email'];
$bd_usunombre       = $anuncio['us_nombre_razon'];
$bd_levantaobs      = $anuncio['levanta_obs'];
$bd_img             = $anuncio['img'];
$bd_imgthumb        = $anuncio['img_thumb'];

$bd_tipo        = $anuncio['ta_tipo'];
$bd_cate        = $anuncio['categoria'];

$carpeta = help_folderAnuncio().$bd_codanuncio."/";

$imgprincipal = $carpeta.$bd_img;
?>

<div class="container detalle my-3">
    <div class="row">
        <div class="col-sm-12 mt-2 pb-2">
            <h1 class="fs-4"><?=$bd_nombre;?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 pb-2">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Compartir <i class="fas fa-share-alt"></i>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?=current_url();?>"><i class="far fa-copy"></i> Copiar link </a></li>
                <li><a class="dropdown-item" href="<?=current_url();?>"><i class="fab fa-facebook-square"></i> Facebook</a></li>
                <li><a class="dropdown-item" href="<?=current_url();?>"><i class="fab fa-whatsapp"></i> Whatsapp</a></li>
            </ul>

            <a href="#" class="btn btn-outline-secondary">Favorito <i class="far fa-heart"></i></a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-9">
            <div class="multimedia">
                <div class="multimedia__images">
                    <div class="big">
                        <a data-bs-toggle="modal" data-bs-target="#modalMultimedia" data-bs-slide-to="0">
                            <img src="<?=$imgprincipal?>" alt="">
                        </a>
                    </div>                
                    <div class="littles <?=count($imagenes) == 1 ? 'd-none' : ''?>">
                        <?php 
                        $cont = 0;
                        foreach($imagenes as $im){
                            
                            $idimages  = $im['idimages'];
                            $img       = $im['img'];
                            $img_thumb = $im['img_thumb'];
                            $principal = $im['principal'];

                            $url_thumb = $carpeta.$img_thumb;

                            if( $principal == 1 ) continue; 

                            $cont++;

                            echo '<a data-bs-toggle="modal" data-bs-target="#modalMultimedia" data-bs-slide-to="'.$cont.'">';
                            echo '<img src="'.$url_thumb.'" alt="">';
                            echo "</a>";
                        }
                        ?>
                    </div>                            
                </div>
                
                <?php
                if( $bd_urlvideo != '' ){
                ?>
                <div class="text-end pt-2">
                    <a class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalMultimedia" data-bs-slide-to="<?=$cont + 1?>"><i class="fas fa-play-circle"></i> ver video</a>
                </div>
                <?php
                }
                ?>
                
                <div class="modal fade" id="modalMultimedia" tabindex="-1" aria-labelledby="modalMultimediaLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div id="carouselMultimedia" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                <div class="carousel-inner overflow-hidden">
                                    <div class="carousel-item active">
                                        <img src="<?=$imgprincipal?>" class="d-block w-100" alt="">
                                    </div>
                                    <?php 
                                    foreach($imagenes as $im){
                                        
                                        $idimages  = $im['idimages'];
                                        $img       = $im['img'];
                                        $img_thumb = $im['img_thumb'];
                                        $principal = $im['principal'];

                                        $url_img   = $carpeta.$img;

                                        if( $principal == 1 ) continue; 

                                        echo '<div class="carousel-item">';
                                        echo '<img src="'.$url_img.'" class="d-block w-100" alt="...">';
                                        echo "</div>";
                                    }
                                    ?>
                                    <?php
                                    if( $bd_urlvideo != '' ){
                                        $iframe = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<iframe width=\"100%\" height=\"640\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>", $bd_urlvideo);
                                        echo '<div class="carousel-item">';
                                        echo $iframe;
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselMultimedia" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselMultimedia" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var myCarousel = document.querySelector('#carouselMultimedia')
                    var myModalEl = document.getElementById('modalMultimedia')

                    myModalEl.addEventListener('show.bs.modal', function (event) {
                        const trigger = event.relatedTarget
                        var bsCarousel = bootstrap.Carousel.getInstance(myCarousel)
                        bsCarousel.to(trigger.dataset.bsSlideTo)
                        
                    })

                    myModalEl.addEventListener('hide.bs.modal', function (event) {
                        document.querySelectorAll('iframe').forEach(v => { v.src = v.src });
                    })
                </script>
            </div>

            <div class="desc mt-5">
                <h4>Descripción</h4>

                <p><?=$bd_descripcion?></p>
            </div>

            <div class="desc mt-5">
                <h4>Características</h4>

                <p><?=nl2br($bd_caracteristicas)?></p>
            </div>
        </div>

        <div class="d-none d-sm-none d-md-block col-md-3 col-lg-3 col-xl-3 col-xxl-3 text-center bg-light">
            <a href="#">
                <img src="public/img/banner/banner-h.png" alt="" class="img-fluid">
            </a>
        </div>
    </div>

</div>

<?php echo $this->endSection();?>
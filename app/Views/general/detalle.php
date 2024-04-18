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
        <div class="col-sm-12 col-md-8">
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
            
            <?php if($bd_mostrar == 0){?>
            <div class="mt-4 text-light-emphasis">
                <h4>S/. <?=$bd_precio?></h4>
            </div>
            <?php }?>

            <div class="mt-4 text-light-emphasis">
                <p class="m-0 fw-semibold"><?=$bd_dist?>, <?=$bd_prov?></p>
                <p class="m-0 fst-italic"><?=$bd_direccion != '' ? $bd_direccion : ''?></p>
            </div>
            
            <div class="desc mt-4">
                <h5 class="bg-light py-3 px-1 border-bottom border-secondary">Descripción</h4>

                <p><?=nl2br($bd_descripcion)?></p>
            </div>

            <div class="desc mt-5">
                <h5 class="bg-light py-3 px-1 border-bottom border-secondary">Características</h4>

                <p><?=nl2br($bd_caracteristicas)?></p>
            </div>
        </div>

        <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 text-center">
            <div class="card text-bg-white mb-3 rounded-0">
                <div class="card-header bg-light fw-semibold">Usuario</div>
                <div class="card-body">
                    <div class="card-title"><?=$bd_usunombre?></div>
                    <p class="card-text text-right"><a class="btn btn-sm btn-outline-primary" href="#">Ver anuncios</a></p>
                </div>
            </div>

            <div class="card text-bg-white mb-3 rounded-0">
                <div class="card-header bg-light fw-semibold">Contacto</div>
                <div class="card-body">
                    <div class="card-title fs-4"><i class="fas fa-phone-square-alt text-primary"></i> <?=$bd_contactfono?></div>
                    <div class="card-title fs-4"><i class="fab fa-whatsapp text-success"></i> <?=$bd_contactwhatsapp?></div>
                    <hr>
                    
                    <form id="frmMensaje" class="text-secondary">
                        <div class="form-group pb-1 text-start">
                            <label for="txtMail" class="mb-2">Tu correo</label>
                            <input type="email" class="form-control rounded-0" maxlength="100" name="txtMail" id="txtMail">
                            <p class="text-danger" id="msj-txtMail"></p>
                        </div>
                        <div class="form-group pb-1 text-start">
                            <label for="" class="mb-2">Tu nombre</label>
                            <input type="text" class="form-control rounded-0" maxlength="100" name="txtNombre" id="txtNombre">
                            <p class="text-danger" id="msj-txtNombre"></p>
                        </div>
                        <div class="form-group pb-1 text-start">
                            <label for="txtFono" class="mb-2">Tu teléfono</label>
                            <input type="text" class="form-control rounded-0" maxlength="12" name="txtFono" id="txtFono">
                            <p class="text-danger" id="msj-txtFono"></p>
                        </div>
                        <div class="form-group pb-1 text-start">
                            <label for="txtMensaje" class="mb-2">Tu mensaje</label>
                            <textarea class="form-control rounded-0" name="txtMensaje" id="txtMensaje" cols="30" rows="3" maxlength="200"></textarea>
                            <p class="text-danger" id="msj-txtMensaje"></p>
                        </div>

                        <div class="form-group pb-1 text-start">
                            <label for="txtCaptcha" class="mb-2">Ingrese el captcha</label>
                            <input type="text" class="form-control rounded-0" maxlength="6" name="txtCaptcha" id="txtCaptcha">
                            <p class="text-danger" id="msj-txtCaptcha"></p>
                            <div class="d-flex align-items-center">
                                <img src="<?=base_url('gcaptcha-mensaje')?>" alt="captcha" id="img-captcha">
                                <a class="btn ms-2 text-decoration-none" title="Otro captcha" id="refreshCaptcha"><i class="fas fa-sync-alt fs-4"></i>recargar Captcha</a>
                            </div>
                        </div>

                        <button class="btn btn-danger mt-2 d-block px-5 w-100" id="btnMensaje">Enviar Mensaje</button>
                    </form>
                    <div id="msjMensaje"></div>
                </div>
            </div>

            <a href="#">
                <img src="public/img/banner/banner-h.png" alt="" class="img-fluid">
            </a>
        </div>
    </div>

</div>

<?php echo $this->endSection();?>

<?php echo $this->section('scripts');?>

<script>
$(function(){
    $("#refreshCaptcha").on('click', function(){
        let imgCaptcha = document.querySelector("#img-captcha"),
            _this = $(this);
        _this.addClass('pe-none');
        fetch('gcaptcha-mensaje')
            .then(response => response.blob())
            .then(data => {
                if (data) {
                    imgCaptcha.src = URL.createObjectURL(data);
                    _this.removeClass('pe-none');
                }
            });
    });

    $("#frmMensaje").on('submit', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnMensaje'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;

        $.ajax({
            method: 'POST',
            url: 'enviar-mensaje',
            data: $(this).serialize(),
            success: function(data){
                $('[id^="msj-"').text("");
                if( data.errors ){                    
                    let errors = data.errors;
                    for( let err in errors ){
                        /* if( err === 'imagenes[]' ){
                            $('#msj-imagenes').text(errors[err]);
                            continue;
                        } */
                        $('#msj-' + err).text(errors[err]);
                    }
                }
                $("#msjMensaje").html(data);
                btn.removeAttribute('disabled');
                btn.innerHTML = txtbtn;
            }
        });
        /* $.post('enviar-mensaje', $(this).serialize(), function(data){
            console.log(data);
            $("#msjMensaje").html(data);
            btn.removeAttribute('disabled');
            btn.innerHTML = txtbtn;

            $("#refreshCaptcha").click();
        }) */
    })
});
</script>

<?php echo $this->endSection();?>
<?php echo $this->extend('plantilla/layout_panel')?>

<?php echo $this->section('contenido_panel');?>

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

$bd_tipo        = $anuncio['ta_tipo'];
$bd_cate        = $anuncio['categoria'];
?>

<div class="card rounded-0">
    <div class="card-header p-2 mb-3 bg-success text-white bg-gradient fw-bolder rounded-0">Detalle del anuncio</div>
    <div class="card-body create_anuncio">
        <div class="row">
            <div class="col-sm-4 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i>  Tipo</div>
                <p class="p-2"><?=$bd_tipo?></p>
            </div>
            <div class="col-sm-4 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i>  Categoría</div>
                <p class="p-2"><?=$bd_cate?></p>
            </div>
            <div class="col-sm-4 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i>  Precio</div>
                <p class="p-2"><?=$bd_mostrar != 1 ? $bd_precio : 'No mostrar'?></p>
            </div>
            <div class="col-sm-12 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i>  Nombre</div>
                <p class="p-2"><?=$bd_nombre?></p>
            </div>
            <div class="col-sm-12 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i>  Descripción</div>
                <p class="p-2"><?=$bd_descripcion?></p>
            </div>
            <div class="col-sm-12 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i>  Características</div>
                <p class="p-2" class="p-2"><?=nl2br($bd_caracteristicas)?></p>
                <?php
                //$arr_caract = explode("\r\n", $bd_caracteristicas);
                ?>
            </div>
            <div class="col-sm-12 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i>  Link Youtube</div>
                <?php
                if( $bd_urlvideo != '' ){
                    $iframe = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<iframe width=\"100%\" height=\"480\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>", $bd_urlvideo);
                    echo '<div>';
                    echo $iframe;
                    echo '</div>';
                }else
                    echo "sin url";
                ?>
            </div>
            <div class="col-sm-12 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i> Dirección</div>
                <p class="p-2"><?=$bd_direccion ? $bd_direccion : 'Sin dirección'?></p>
            </div>
            <div class="col-sm-4 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i> Provincia</div>
                <p class="p-2"><?=$bd_prov?></p>
            </div>
            <div class="col-sm-4 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i> Distrito</div>
                <p class="p-2"><?=$bd_dist?></p>
            </div>
            <div class="col-sm-4 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i> Whatsapp</div>
                <p class="p-2"><?=$bd_contactwhatsapp?></p>
            </div>
            <div class="col-sm-4 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i> Telefono</div>
                <p class="p-2"><?=$bd_contactfono?></p>
            </div>
            <div class="col-sm-8 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i> Email</div>
                <p class="p-2"><?=$bd_contactemail?></p>
            </div>
            <div class="col-sm-12 pb-2">
                <div class="bg-light fw-bold p-1"><i class="fas fa-check"></i> Imágenes</div>
                <div class="d-flex justify-content-start flex-wrap">
                    <?php 
                    $carpeta = help_folderAnuncio().$bd_codanuncio."/";
                    foreach($imagenes as $im){
                        $idimages  = $im['idimages'];
                        $img       = $im['img'];
                        $img_thumb = $im['img_thumb'];
                        $principal = $im['principal'];

                        $url_img   = $carpeta.$img;
                        $url_thumb = $carpeta.$img_thumb;

                        echo "<div>";
                        echo "<img src='".$url_thumb."' style='object-fit: cover; height: 150px; width:150px; cursor:pointer' class='border' onclick=\"verImg('".$url_img."')\"/>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

            <div class="col-sm-6 pb-2">
                <div class="bg-secondary p-1"><i class="fas fa-check"></i> Estado</div>
                <p class="p-2"><?=$bd_estado?></p>
            </div>
            <div class="col-sm-6 pb-2">
                <div class="bg-secondary p-1"><i class="fas fa-check"></i> Observado</div>
                <p class="p-2"><?=$bd_observadopor?></p>
            </div>

            <div class="col-sm-6 pb-2">
                <div class="bg-secondary p-1"><i class="fas fa-check"></i> Usuario</div>
                <p class="p-2"><?=$bd_usuemail?></p>
            </div>
            <div class="col-sm-6 pb-2">
                <div class="bg-secondary p-1"><i class="fas fa-check"></i> Nombre</div>
                <p class="p-2"><?=$bd_usunombre?></p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-12">
                <?php 
                if( $bd_idestado == 1 || $bd_idestado == 6 ){ //si esta como pendiente u observado
                    echo '<a class="btn btn-success botones" data-id='.$bd_idanuncio.' data-opt="1">Activar</a>';
                }
                ?>                
                <a class="btn btn-danger botones" data-id="<?=$bd_idanuncio?>" data-opt="2">Observar</a> 
                <input type="text" class="form-control mt-2" placeholder="Motivo de observación" maxlength="250" value="<?=$bd_observadopor?>" id="txtMotivo">
                <?php
                if( $bd_idestado == 6 && $bd_levantaobs == 1 ){
                    echo "<p class='text-success fw-semibold'>El usuario ha levantado la observación.</p>";
                }else if( $bd_idestado == 6 && $bd_levantaobs != 1 ){
                    echo "<p class='text-danger fw-semibold'>El usuario no ha levantado la observación.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalImg" tabindex="-1" aria-labelledby="modalImgLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-12 text-center">
                <img src="public/img/anuncios/campaña.jpg" alt="images" id="imgModalShow" style="max-width: 100%;">
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="msjdetalle"></div>

<?php echo $this->endSection();?>

<?php echo $this->section('scriptsPanel');?>

<script>
function verImg(img){
    $('#imgModalShow').attr('src', img);
    $('#modalImg').modal('show');
}

$(function(){
    $('.botones').on('click', function(e){
        let id = $(this).data('id'),
            opt = $(this).data('opt'),
            motivo = $('#txtMotivo').val().trim();

        if( opt == 2 && motivo == ''){
            Swal.fire({text: "Ingrese un motivo", icon: "error"});
        }else{
            let titulo = opt == 1 ? 'activar' : 'observar';

            Swal.fire({
                title: `¿Vas a ${titulo} el anuncio?`,
                showCancelButton: true,
                confirmButtonText: "Confirmar",
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('activarObservar', {
                        id, opt, motivo
                    }, function(data){
                        console.log(data);
                        $('#msjdetalle').html(data);
                    });
                }
            });
        }
    });
})
</script>

<?php echo $this->endSection();?>
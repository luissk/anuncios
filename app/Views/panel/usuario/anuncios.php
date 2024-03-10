<?php echo $this->extend('plantilla/layout_panel')?>

<?php echo $this->section('contenido_panel');?>

<?php
/* echo "<pre>"; 
print_r($anuncios);
echo "</pre>"; */
?>

<div class="col-sm-12 text-end">
    <a class="btn btn-outline-danger" href="publicar-anuncio">Nuevo Anuncio</a>
</div>

<div class="mis-anuncios mt-4">
    <?php
    if( $anuncios ){
        foreach( $anuncios as $anu ){
            $idanuncio      = $anu['idanuncio'];
            $nombre         = $anu['an_nombre'];
            $fechacreacion  = $anu['an_fechacreacion'];
            $idtipo         = $anu['idtipo_anuncio'];
            $idcate         = $anu['idcate'];
            $precio         = $anu['precio'];
            $precio_mostrar = $anu['precio_mostrar'];
            $codanuncio     = $anu['codanuncio'];
            $tipo           = $anu['ta_tipo'];
            $categoria      = $anu['categoria'];
            $img_thumb      = $anu['img_thumb'];
            $idestado       = $anu['an_status'];
            $estado         = $anu['estado'];

            $img = help_folderAnuncio().$codanuncio."/".$img_thumb;

            $tagprecio = $precio_mostrar == 1 ? 'No mostrar precio' : $precio;

            ?>
            <div class='card mb-3'>
                <div class='row g-0'>
                    <div class='col-lg-3 col-xxl-2 text-center mis-anuncios__img'>
                        <img src='<?=$img?>' class='' alt='<?=$nombre?>'>
                    </div>
                    <div class='col-lg-9 col-xxl-10'>
                    <div class='card-body'>
                        <h6 class='card-title bg-success p-2 text-white'><?=$nombre?></h6>
                        <div class='row'>
                            <div class='col-sm-3 text-secondary'>
                                <i class='fas fa-hand-point-right'></i> <?=$tipo?>
                            </div>
                            <div class='col-sm-4 text-secondary'>
                                <i class='fas fa-tag'></i> <?=$categoria?>
                            </div>
                            <div class='col-sm-5 text-secondary'>
                                <i class='fas fa-hand-holding-usd'></i> S/. <?=$tagprecio?>
                            </div>
                            <div class='col-sm-12 text-secondary fw-semibold pt-2'>
                                <i class='fas fa-thermometer-quarter'></i> Estado: <?=$estado?>
                            </div>

                            <div class='row'>
                                <div class='col-sm-12 text-center'>
                                    <a href="<?=base_url('modificar-anuncio-'.$idanuncio.'')?>" class='btn btn-outline-info mt-2'>Modificar</a>
                                    <a class='btn btn-outline-danger mt-2'>Eliminar</a>
                                    <a class='btn btn-outline-secondary mt-2'>Inactivo</a>
                                    <a class='btn btn-outline-success mt-2'>Destacar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>
    <!-- <div class='card mb-3'>
        <div class='row g-0'>
            <div class='col-md-3'>
                <img src='...' class='img-fluid rounded-start' alt='...'>
            </div>
            <div class='col-md-9'>
            <div class='card-body'>
                <h5 class='card-title'>Card title</h5>
                <p class='card-text'>This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p class='card-text'><small class="text-body-secondary">Last updated 3 mins ago</small></p>
            </div>
            </div>
        </div>
    </div> -->
</div>

<?php echo $this->endSection();?>
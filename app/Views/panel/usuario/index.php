<?php echo $this->extend('plantilla/layout_panel')?>

<?php echo $this->section('contenido_panel');?>

<div class="p-2 mb-3 bg-success text-white bg-gradient fw-bolder fs-5">Dashboard Usuario</div>

<?php if(session('noanuncios')){?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?=session('noanuncios')?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php }?>

<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-light shadow-sm alert-dismissible fade show rounded-0 border border-5 border-secondary border-start-5 border-top-0 border-bottom-0 border-end-0" role="alert">
            Hola, <b><?=help_nombreWeb()?></b> te regala <b>10</b> anuncios <b>GRATIS! <a href="<?=base_url('publicar-anuncio')?>">Empieza a publicar</a></b>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
        <div class="card">
            <div class="card-header bg-warning">Anuncios Disponibles</div>
            <div class="card-body">                                            
                <p class="card-text text-center fs-2"><?=$anunciosDisponiblesUsados['count_anuncios']?></p>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
        <div class="card">
            <div class="card-header bg-warning">Anuncios Usados</div>
            <div class="card-body">                                            
                <p class="card-text text-center fs-2"><?=$anunciosDisponiblesUsados['count_anuncios_used']?></p>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
        <div class="card">
            <div class="card-header bg-warning">Anuncios que tienes</div>
            <div class="card-body">                                            
                <p class="card-text text-center fs-2"><?=$anunciosenLista?></p>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
        <div class="card">
            <div class="card-header bg-warning">Anuncios Eliminados</div>
            <div class="card-body">                                            
                <p class="card-text text-center fs-2"><?=$anunciosEliminados?></p>
            </div>
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
        <div class="card">
            <div class="card-header bg-success">Anuncios Destacados</div>
            <div class="card-body">                                            
                <p class="card-text text-center fs-2">0</p>
            </div>
        </div>
    </div>
</div> -->

<div class="row mt-4">
    <div class="col-sm-12">
        <div class="alert alert-success shadow-sm alert-dismissible fade show rounded-0 border border-5 border-secondary border-start-5 border-top-0 border-bottom-0 border-end-0" role="alert">
            <h6>Adquiere más anuncios</h6>
            <ol class="list-group list-group-numbered">
            <?php
            if( $preciosAnuncios ){
                /* echo "<pre>";
                print_r($preciosAnuncios);
                echo "</pre>"; */
                foreach( $preciosAnuncios as $pre ){
                    $idprecio    = $pre['idprecio'];
                    $item        = $pre['item'];
                    $cantidad    = $pre['cantidad'];
                    $precio      = $pre['precio'];
                    $flag        = $pre['flag'];
                    $descripcion = $pre['descripcion'];
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                    <div class="fw-bold"><?=$item?></div>
                       <?=$descripcion?>
                    </div>
                    <span class="badge text-bg-success rounded-pill fs-6">S/. <?=$precio?></span>
                </li>
                <?php
                }
            }
            ?>
            </ol>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>
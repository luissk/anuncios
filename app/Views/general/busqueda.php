<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

<section class="container filters mt-4">
    <div class="row py-2">
        <div class="col-sm-3">                      
            <input type="text" class="form-control" id="txtBuscar" placeholder="Buscar por distrito" autocomplete="off">
        </div>
        <div class="col-sm-3">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Tipo de anuncio
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item active" href="#">Inmuebles</a></li>
                    <li><a class="dropdown-item" href="#">Tiendas</a></li>
                    <li><a class="dropdown-item" href="#">Negocios</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="dropdown">
                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    Más filtros
                </button>
                <div class="dropdown-menu p-3">
                    aqui mas filtros
                </div>
            </div>
        </div>
    </div>

    <div class="row filters__selected py-2">
        <div class="col-sm-12 text-center">
            <span class="border rounded p-1 bg-light m-1">Trujillo <a href="#" class="badge bg-danger" title="borrar filtro"><i class="fas fa-times"></i></a></span>
            <span class="border rounded p-1 bg-light m-1">Tiendas <a href="#" class="badge bg-danger" title="borrar filtro"><i class="fas fa-times"></i></a></span>
            <span class="border rounded p-1 bg-light m-1">xD <a href="#" class="badge bg-danger" title="borrar filtro"><i class="fas fa-times"></i></a></span>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-7 pt-3">
            <p class="fw-medium">10 anuncios en Trujillo</p>
        </div>
        <div class="col-sm-5 text-end">
            <div class="dropdown">
                <button type="button" class="btn dropdown-toggle btnOrder" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    Ordenar
                </button>
                <ul class="dropdown-menu order">
                    <li><a class="dropdown-item active" href="#">Mayor</a></li>
                    <li><a class="dropdown-item" href="#">Menor</a></li>
                    <li><a class="dropdown-item" href="#">Precio</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

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
                <a href="anuncio-<?=$url?>"><img src="<?=$img?>" alt="<?=$nombre?>" class=""></a>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-9 resultado__item--content py-2 px-3">
                <div class="resultado__item--title fw-bolder text-success">
                    <?=$nombre?>
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
                        <a href="#" class="btn btn-success rounded-0" title="ver detalle">Detalle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        }
    }else{
        echo "NO HAY ANUNCIOS";
    }
    ?>
</section>

<section class="container">
    <div class="row">
        <div class="col-sm-12">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="container recomendados">
    <div class="row">
        <div class="col-sm-12">
            Recomendaciones anuncios
        </div>
    </div>
</section>

<?php echo $this->endSection();?>
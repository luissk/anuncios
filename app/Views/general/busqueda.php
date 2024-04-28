<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('csslinks');?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<?php echo $this->endSection();?>

<?php echo $this->section('contenido');?>
<?php
echo "<pre>";
$path_current = uri_string();
//$uri = new \CodeIgniter\HTTP\URI('http://localhost/anuncios/busca-anuncios?keyword=palabra&order=asc&page=2');
//print_r($filters);
echo "</pre>";
?>
<section class="container filters mt-4">
    <div class="row py-2">
        <div class="col-sm-2">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Tipo de anuncio
                </button>
                <ul class="dropdown-menu">
                    <?php
                    $path_tipo_explode = explode("-", $path_current);
                    foreach($tipos as $t){
                        $idtipo = $t['idtipo_anuncio'];
                        $tipo   = $t['ta_tipo'];

                        $path_tipo_explode[1] = help_reemplazaCaracterUrl($tipo);
                        $path_tipo = implode("-", $path_tipo_explode);

                        echo '<li><a class="dropdown-item" href="'.base_url($path_tipo).'">'.$tipo.'</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="dropdown">
                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    Categoría de anuncio
                </button>
                <div class="dropdown-menu p-3" style="max-height: 400px; overflow: auto">
                <?php
                    $path_cat_explode = explode("-de-", $path_current);

                    foreach($categorias as $c){
                        $idcate       = $c['idcate'];
                        $categoria    = $c['categoria'];
                        $seocategoria = $c['seocategoria'];

                        if( count($path_cat_explode) == 1 && strpos($path_current, "-en-") == 0 ) 
                            $path_cat = "$path_current-de-$seocategoria";
                        else if( count($path_cat_explode) == 1 && strpos($path_current, "-en-") > 0 )
                            $path_cat = substr($path_current, 0, strpos($path_current, "-en-")) . "-de-" . $seocategoria . substr($path_current, strpos($path_current, "-en-"));
                        else if( count($path_cat_explode) > 1 ){
                            $path_cat = substr_replace($path_current, $seocategoria, strpos($path_current,"-de-") + 4) . (strpos($path_current, "-en-") > 0 ? substr($path_current, strpos($path_current, "-en-")) : '');
                        }

                        echo '<li><a class="dropdown-item" href="'.$path_cat.'">'.$categoria.'</a></li>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3">                      
            <input type="text" class="form-control" id="txtSearch" placeholder="Buscar por distrito o provincia" autocomplete="off">
            <input type="hidden" id="path_current" value="<?=base_url().$path_current?>">
        </div>
        <div class="col-sm-3">                      
            <!-- <input type="text" class="form-control" id="keyword" placeholder="Buscar por palabra clave" autocomplete="off"> -->
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="buscar por palabra clave" autocomplete="off" id="txtKeyword">
                <button class="btn btn-outline-secondary" type="button" id="btnKeyword"><i class="fas fa-search" aria-hidden="true"></i></button>
            </div>
            <p class="text-danger" id="msjKeyword"></p>
        </div>
    </div>

    <div class="row filters__selected py-2">
        <div class="col-sm-12 text-center">
            <?php
            if( $filters ){
                foreach($filters as $fil){
                    if( $fil[1] != '' ){
                        echo '<span class="border rounded p-1 bg-light m-1">'.$fil[1].' <a href="'.$fil[0].'" class="badge bg-danger" title="borrar filtro"><i class="fas fa-times"></i></a></span>';
                    }
                }
            }
            ?>
            <!-- <span class="border rounded p-1 bg-light m-1">Trujillo <a href="#" class="badge bg-danger" title="borrar filtro"><i class="fas fa-times"></i></a></span>
            <span class="border rounded p-1 bg-light m-1">Tiendas <a href="#" class="badge bg-danger" title="borrar filtro"><i class="fas fa-times"></i></a></span>
            <span class="border rounded p-1 bg-light m-1">xD <a href="#" class="badge bg-danger" title="borrar filtro"><i class="fas fa-times"></i></a></span> -->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-7 pt-3">
            <p class="fw-medium"><?=$totalRegistros?> Anuncios encontrados</p>
        </div>
        <div class="col-sm-5 text-end">
            <div class="dropdown">
                <button type="button" class="btn dropdown-toggle btnOrder" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    Ordenar
                </button>
                <ul class="dropdown-menu order">
                    <?php
                    $uri = service('uri');
                    $uri->stripQuery('page');
                    ?>
                    <li><a class="dropdown-item" href="<?=$uri->addQuery('order', 'asc');?>">Menor precio</a></li>
                    <li><a class="dropdown-item" href="<?=$uri->addQuery('order', 'desc');?>">Mayor precio</a></li>
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
        $RegistrosAMostrar = 2;
        $PaginasIntervalo  = 2;
        $PagAct            = $page;

        $PagUlt = $totalRegistros / $RegistrosAMostrar;
        $res    = $totalRegistros % $RegistrosAMostrar;
        if( $res > 0 ) $PagUlt = floor($PagUlt) + 1;

        $uri = new \CodeIgniter\HTTP\URI(current_url(). ($_SERVER['QUERY_STRING'] != '' ? "?".$_SERVER['QUERY_STRING'] : ''));
        }
        ?>

        <nav>
            <ul class="pagination justify-content-end <?=$totalRegistros <= 2 ? 'd-none' : ''?>">
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
    }else{
        echo "NO HAY ANUNCIOS";
    }
    ?>
</section>


<section class="container recomendados">
    <div class="row">
        <div class="col-sm-12">
            Recomendaciones anuncios
        </div>
    </div>
</section>

<?php echo $this->endSection();?>

<?php echo $this->section('scripts');?>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
$(function(){
    let items = [];
    $.getJSON('public/ubigeo.json', function(data){
        $.each(data, (i,v) => {
            //console.log(i, v);
            items[i] = {value: v.idubigeo, label: v.texto2, seo: v.seotexto2};
        });
    });

    var accentMap = {
        "à": "a", 
        "á": "a", 
        "ä": "a", 
        "è": "e", 
        "é": "e", 
        "ë": "e", 
        "ì": "i", 
        "í": "i",
        "ï": "i",
        "ò": "o",
        "ó": "o",
        "ö": "o",
        "ù": "u",
        "ú": "u",
        "ü": "u",
        "ñ": "n"
    };
    var normalize = function( term ) {
        var ret = "";
        for ( var i = 0; i < term.length; i++ ) {
            ret += accentMap[ term.charAt(i) ] || term.charAt(i);
        }
        return ret;
    };

    $( "#txtSearch" ).autocomplete({
        minLength: 3,
        source: function( request, response ) {
                var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term ), "i" );
                response( $.grep( items, function( value ) {
                value = value.label || value.value || value;
                return matcher.test( value ) || matcher.test( normalize( value ) );
                }) );
        },
        focus: function( event, ui ) {
            $( "#txtSearch" ).val('');
            $("#idubigeo").val('');
            return false;
        },
        select: function( event, ui ) {
            $( "#txtSearch" ).val( ui.item.label );

            let path_current = $("#path_current").val(),
            path_ubi = '';

            path_ubi = path_current.indexOf('-en-') > 0 ? path_current.substring(0, path_current.indexOf('-en-') + 4) + ui.item.seo : `${path_current}-en-${ui.item.seo}`;

            location.href = path_ubi;

            return false;
        },
        response: function( event, ui ) {
            if( ui.content.length == 0 ){
                $("#idubigeo").val('');
            }
        },
    });

    $("#btnKeyword").on('click', function(e){
        e.preventDefault();
        let path_current = $("#path_current").val(),
            txtKeyword = $("#txtKeyword").val().trim();

        if( txtKeyword.length > 2 ){
            location.href = `${path_current}?keyword=${txtKeyword}`;
        }else{
            $("#msjKeyword").text('Ingrese más de 2 caracteres');
        }

    })
})
</script>

<?php echo $this->endSection();?>
<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('csslinks');?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<?php echo $this->endSection();?>

<?php echo $this->section('contenido');?>

<section class="py-3 bg-success">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-6">
                <form class="d-flex formsearch" id="frmSearch">
                    <input class="form-control  me-2" type="text" placeholder="Busca por distritos o palabra" id="txtSearch" name="txtSearch">
                    <input type="hidden" id="idubigeo" name="idubigeo">
                    <input type="hidden" id="ini" name="ini" value="1">
                    <button class="btn btn-outline-dark" title="Buscar"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="slider bg-light bg-gradient">
    <div id="carouselPrincipal" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselPrincipal" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselPrincipal" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="5000">
                <img src="<?php echo base_url();?>public/img/carousel/Mantenimiento-de-edificios_slider_600.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="<?php echo base_url();?>public/img/carousel/SLIDER-1920x600-1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselPrincipal" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselPrincipal" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>          
    </div>
</section>


<section class="bg-light destacados">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="mt-5 mb-4 text-center">Anuncios Destacados</h3>
            </div>
        </div>        
        <div class="row d-flex justify-content-center align-items-center py-3">
            <?php
            /* echo "<pre>"; 
            print_r($anuncios);
            echo "</pre>"; */
            if( $anuncios ){
                foreach( $anuncios as $anu ){
                    $idanuncio  = $anu['idanuncio'];
                    $codanuncio = $anu['codanuncio'];
                    $nombre     = $anu['an_nombre'];
                    $idcate     = $anu['idcate'];
                    $categoria  = $anu['categoria'];
                    $img_thumb  = $anu['img_thumb'];       

                    $img = help_folderAnuncio().$codanuncio."/".$img_thumb;

                    $url = help_reemplazaCaracterUrl($nombre)."-".$idanuncio;
            ?>

            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2 mb-2">
                <div class="card border-0 shadow-sm my-1 destacados_item">
                    <a href="anuncio-<?=$url?>"><img src="<?=$img?>" class="card-img-top" alt="<?=$nombre?>"></a>
                    <div class="card-body">
                        <h5 class="card-title fs-6"><a class="text-decoration-none text-primary" href="anuncio-<?=$url?>"><?=strlen($nombre) > 70 ? substr($nombre, 0, 70)."..." : $nombre?></a></h5>
                        <p class="card-text text-truncate"><a class="text-decoration-none text-secondary" href="#"><?=$categoria?></a></p>
                        <a href="anuncio-<?=$url?>" class="btn btn-outline-secondary"><i class="fas fa-angle-right"></i> ver más</a>
                    </div>
                </div>
            </div>

            <?php
                }
            }
            ?>
            <!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3">
                <div class="card border-0 shadow-sm my-1">
                    <img src="<?php echo base_url()?>public/img/anuncios/campaña.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title fs-6 fw-bold">Card title</h5>
                        <p class="card-text text-truncate">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-outline-primary"><i class="fas fa-angle-right"></i> ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3">
                <div class="card border-0 shadow-sm my-1">
                    <img src="<?php echo base_url()?>public/img/anuncios/cielo.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title fs-6 fw-bold">Card title</h5>
                        <p class="card-text text-truncate">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-outline-primary"><i class="fas fa-angle-right"></i> ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3">
                <div class="card border-0 shadow-sm my-1">
                    <img src="<?php echo base_url()?>public/img/anuncios/helado.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title fs-6 fw-bold">Card title</h5>
                        <p class="card-text text-truncate">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-outline-primary"><i class="fas fa-angle-right"></i> ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3">
                <div class="card border-0 shadow-sm my-1">
                    <img src="<?php echo base_url()?>public/img/anuncios/leon.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title fs-6 fw-bold">Card title</h5>
                        <p class="card-text text-truncate">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-outline-primary"><i class="fas fa-angle-right"></i> ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3">
                <div class="card border-0 shadow-sm my-1">
                    <img src="<?php echo base_url()?>public/img/anuncios/pepsi.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title fs-6 fw-bold">Card title</h5>
                        <p class="card-text text-truncate">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-outline-primary"><i class="fas fa-angle-right"></i> ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3">
                <div class="card border-0 shadow-sm my-1">
                    <img src="<?php echo base_url()?>public/img/anuncios/sabritas.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title fs-6 fw-bold">Card title</h5>
                        <p class="card-text text-truncate">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-outline-primary"><i class="fas fa-angle-right"></i> ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3">
                <div class="card border-0 shadow-sm my-1">
                    <img src="<?php echo base_url()?>public/img/anuncios/snickers.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title fs-6 fw-bold">Card title</h5>
                        <p class="card-text text-truncate">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-outline-primary"><i class="fas fa-angle-right"></i> ver más</a>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>

<section class="home-sec3 py-5">
    <div class="container">
        <div class="row mb-3">
            <div class="col-sm-12">
                <h3 class="text-center">¿Cómo funciona?</h3>
            </div>
        </div>
        <div class="row d-flex justify-content-around flex-wrap text-secondary">
            <div class="rounded-circle bg-white d-flex justify-content-center align-items-center my-2 shadow-sm">
                <div class="text-center">
                    <i class="fas fa-user-circle fs-1"></i><br>
                    <a href="#" class="text-decoration-none text-secondary">Crea tu cuenta</a>
                </div>
            </div>
            <div class="rounded-circle bg-white d-flex justify-content-center align-items-center my-2 shadow-sm">
                <div class="text-center">
                    <i class="fas fa-upload fs-1"></i><br>
                    <a href="#" class="text-decoration-none text-secondary">Detalla tu anuncio</a>
                </div>
            </div>
            <div class="rounded-circle bg-white d-flex justify-content-center align-items-center my-2 shadow-sm">
                <div class="text-center">
                    <i class="fas fa-info-circle fs-1"></i><br>
                    <a href="#" class="text-decoration-none text-secondary">Publícalo</a>
                </div>
            </div>
            <div class="rounded-circle bg-white d-flex justify-content-center align-items-center my-2 shadow-sm">
                <div class="text-center">
                    <i class="fas fa-users fs-1"></i><br>
                    <a href="#" class="text-decoration-none text-secondary">Todos lo verán</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-sec4 py-5 bg-light">
    <div class="container pb-3">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="text-center mb-4">¿Porqué confiar en nosotros?</h3>
            </div>
        </div>
        <div class="row text-black-50">
            <div class="col-sm-4 py-2">
                <div class="text-center bg-white py-4">
                    <i class="fas fa-clock text-success"></i> <br>
                    <span class="fs-5">24 horas online</span>
                </div>
            </div>
            <div class="col-sm-4 py-2">
                <div class="text-center bg-white py-4">
                    <i class="fas fa-exchange-alt text-success"></i> <br>
                    <span class="fs-5">Publicación al instante</span>
                </div>
            </div>
            <div class="col-sm-4 py-2">
                <div class="text-center bg-white py-4">
                    <i class="fas fa-shipping-fast text-success"></i> <br>
                    <span class="fs-5">Agilizamos tus servicios</span>
                </div>
            </div>
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
            items[i] = {value: v.idubigeo, label: v.texto2};
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
            console.log('focus');
            $( "#txtSearch" ).val('');
            $("#idubigeo").val('');
            return false;
        },
        select: function( event, ui ) {
            console.log('select');
            $( "#txtSearch" ).val( ui.item.label );
            $("#idubigeo").val(ui.item.value);
            $("#frmSearch").submit();
            return false;
        },
        response: function( event, ui ) {
            console.log('response', ui);
            if( ui.content.length == 0 ){
                //$( "#txtSearch" ).val('');
                $("#idubigeo").val('');
            }
        },
    }) 
    /* .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div>" + item.label + "</div>" )
        .appendTo( ul );
    }; */

    /* $("#frmSearch").on('submit', function(e){
        e.preventDefault();
        console.log($(this).serialize());
    }); */
})
</script>

<?php echo $this->endSection();?>
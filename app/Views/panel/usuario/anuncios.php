<?php echo $this->extend('plantilla/layout_panel')?>

<?php echo $this->section('contenido_panel');?>

<?php
/* echo "<pre>"; 
print_r($anuncios);
echo "</pre>"; */
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$nombre_page = $nombre != '' ? "?nombre=".$nombre : '';
?>

<div class="col-sm-12 text-end">
    <a class="btn btn-outline-danger" href="publicar-anuncio">Nuevo Anuncio</a>
</div>

<div class="mis-anuncios mt-4">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <form method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control rounded-0" placeholder="Buscar por nombre" id="txtBuscarMiAviso" name="nombre" value="<?=$nombre?>" autocomplete="off">
                    <button class="btn btn-success rounded-0" id="btnBuscarMiAviso" >Buscar</button>
                </div>
            </form>
            <p class="text-danger" id="msj-whatsapp"><?=session('errors.nombre')?></p>
        </div>
        <div class="col-sm-12 col-md-6 text-end">
            Avisos: <span class="badge text-bg-secondary"><?=$totalRegistros?></span>
        </div>
    </div>

    <?php
    if( $anuncios ){
    ?>
    <?php
        foreach( $anuncios as $anu ){
            $idanuncio      = $anu['idanuncio'];
            $nombre         = $anu['an_nombre'];
            $fechacreacion  = $anu['an_fechacreacion'];
            $fechac         = $anu['fechac'];
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
            $diasactivo     = $anu['diasactivo'];
            $levanta_obs    = $anu['levanta_obs'];

            $img = help_folderAnuncio().$codanuncio."/".$img_thumb;

            $tagprecio = $precio_mostrar == 1 ? 'No mostrar precio' : $precio;

            $tooltip_observado = $idestado == 6 ? 'data-bs-toggle="tooltip" data-bs-placement="top" title="Tu anuncio fue observado, ve a la opción modificar para más detalle"' : '';

            $icon_levanta_obs = $idestado == 6 && $levanta_obs == 1 ? '<i class="fas fa-check"></i>' : ($idestado == 6 && $levanta_obs != 1 ? '<i class="fas fa-times"></i>' : '');

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
                            <div class='col-sm-3 text-secondary fw-semibold texto-size-13'>
                                <i class='fas fa-hand-point-right'></i> <?=$tipo?>
                            </div>
                            <div class='col-sm-4 text-secondary fw-semibold texto-size-13'>
                                <i class='fas fa-tag'></i> <?=$categoria?>
                            </div>
                            <div class='col-sm-5 text-secondary fw-semibold texto-size-13'>
                                <i class='fas fa-hand-holding-usd'></i> S/. <?=$tagprecio?>
                            </div>
                            <div class='col-sm-5 text-secondary fw-semibold pt-2 texto-size-13'>
                                <i class='fas fa-thermometer-quarter'></i> Estado: <span <?=$tooltip_observado?> ><?=$estado?></span> <?=$icon_levanta_obs?>
                            </div>
                            <div class='col-sm-4 text-secondary fw-semibold pt-2 texto-size-13'>
                                <i class="fas fa-calendar-alt"></i> Creado: <?=$fechac?>
                            </div>
                            <?php
                            if( $diasactivo != '' ){
                            ?>
                            <div class='col-sm-3 text-secondary fw-semibold pt-2 texto-size-13'>
                                <i class="fas fa-hourglass-start"></i> Vence: <?=$diasactivo?> día(s)
                            </div>
                            <?php
                            }
                            ?>

                            <div class='row'>
                                <div class='col-sm-12 text-center'>
                                    <a href="<?=base_url('modificar-anuncio-'.$idanuncio.'')?>" class='btn btn-outline-info mt-2' title="Modificar Anuncio">Modificar</a>
                                    <a class='btn btn-outline-danger mt-2 eliminarAnuncio' data-id="<?=$idanuncio?>" title="Eliminar Anuncio">Eliminar</a>
                                    <?php
                                    if( $idestado == 2 || $idestado == 4 || $idestado == 5 ){
                                    ?>
                                    <a class='btn btn-outline-secondary mt-2 desactivarAnuncio' data-id="<?=$idanuncio?>" data-status="<?=$idestado?>" title="Desactivar Anuncio">Desactivar</a>
                                    <a class='btn btn-outline-success mt-2'>Destacar</a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        <?php
        }

        $RegistrosAMostrar = 10;
        $PaginasIntervalo  = 2;
        $PagAct            = $page;

        $PagUlt = $totalRegistros / $RegistrosAMostrar;
        $res    = $totalRegistros % $RegistrosAMostrar;
        if( $res > 0 ) $PagUlt = floor($PagUlt) + 1;
        ?>

        <nav>
            <ul class="pagination justify-content-end <?=$totalRegistros <= 10 ? 'd-none' : ''?>">
                <li class="page-item <?=$PagAct > ($PaginasIntervalo + 1) ? '' : 'd-none'?>">
                    <a class="page-link" href="<?=base_url('mis-anuncios-1').$nombre_page?>">Primer</a>
                </li>
                <?php
                for ( $i = ($PagAct - $PaginasIntervalo) ; $i <= ($PagAct - 1) ; $i ++) {
                    if($i >= 1) {
                        echo "<li class='page-item'><a class='page-link' href='".base_url('mis-anuncios-'.$i.'')."$nombre_page'>$i</a></li>";
                    }
                }
                ?>
                <li class="page-item"><a class="page-link active"><?=$PagAct?></a></li>
                <?php
                for ( $i = ($PagAct + 1) ; $i <= ($PagAct + $PaginasIntervalo) ; $i ++) {
                    if( $i <= $PagUlt) {
                        echo "<li class='page-item'><a class='page-link' href='".base_url('mis-anuncios-'.$i.'')."$nombre_page'>$i</a></li>";
                    }
                }
                ?>          
                <li class="page-item <?=$PagAct < ($PagUlt - $PaginasIntervalo) ? '' : 'd-none'?>">
                    <a class="page-link" href="<?=base_url('mis-anuncios-'.$PagUlt.'').$nombre_page?>">Ultimo</a>
                </li>
            </ul>
        </nav>

    <?php
    }else{
        echo '
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        No se encontraron resultados registros!
                    </div>
                </div>
            </div>
        ';
    }
    ?>
</div>

<div id="msjAnuncios"></div>

<?php echo $this->endSection();?>


<?php echo $this->section('scriptsPanel');?>

<script>
$(function(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    $('.eliminarAnuncio').on('click', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        Swal.fire({
            title: "¿Estás seguro que vas a eliminar tu anuncio?",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('eliminarAnuncioUsuario', {
                    id
                }, function(data){
                    //console.log(data);
                    $('#msjAnuncios').html(data);
                });
            }
        });
    });

    $('.desactivarAnuncio').on('click', function(e){
        e.preventDefault();
        let id = $(this).data('id'),
            status = $(this).data('status');

        let text = '';
        if( status == 2 ) text = 'Tu anuncio esta Activo. ¿Quieres desactivarlo?';
        if( status == 4 ) text = 'Tu anuncio esta Destacado, si lo desactivas ya no estará como Destacado. ¿Quieres desactivarlo?';
        if( status == 5 ) text = 'Tu anuncio esta Super Destacado, si lo desactivas ya no estará como Super Destacado. ¿Quieres desactivarlo?';

        Swal.fire({
            text: text,
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('desactivarAnuncioUsuario', {
                    id
                }, function(data){
                    //console.log(data);
                    $('#msjAnuncios').html(data);
                });
            }
        });
    });

});
</script>

<?php echo $this->endSection();?>
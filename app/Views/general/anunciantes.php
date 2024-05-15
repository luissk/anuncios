<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

<?php
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$nombre_page = $nombre != '' ? "?nombre=".$nombre : '';

$uri = new \CodeIgniter\HTTP\URI(current_url(). ($_SERVER['QUERY_STRING'] != '' ? "?".$_SERVER['QUERY_STRING'] : ''));

if( isset($_GET['page']) ){
    $uri->stripQuery('page');
}
?>

<div class="container my-3">
    <div class="row mt-5">
        <div class="col-sm-12 col-md-5">
            <form method="get">
                <div class="input-group">
                    <input type="text" class="form-control rounded-0" placeholder="Buscar anunciante" id="txtBuscarMiAviso" name="nombre" value="<?=$nombre?>" autocomplete="off">
                    <button class="btn btn-success rounded-0" id="btnBuscarMiAviso" >BUSCAR</button>
                </div>
            </form>
            <p class="text-danger" id="msj-nombre"><?=session('errors.nombre')?></p>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-12 py-2 text-end">
            Anunciantes: <span class="badge text-bg-secondary"><?=$totalRegistros?></span>
        </div>

    <?php
    /* echo "<pre>";
    print_r($usuarios);
    echo "</pre>"; */
    if( $usuarios ){
        foreach( $usuarios as $usu ){
            $idusuario  = $usu['idusuario'];
            $codusuario = $usu['us_codusuario'];
            $nombre     = $usu['us_nombre_razon'];
            $avatar     = $usu['us_avatar'];
            $prov       = $usu['prov'];
            $dist       = $usu['dist'];

            $img_avatar = $avatar == '' ? 'default.jpg': $avatar;
    ?>

        <div class="col-sm-6">
            <div class="card mb-3 p-2 bg-light bg-gradient border-0 border-bottom border-2">
                <div class="d-flex flex-wrap">
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="anunciante-<?=help_reemplazaCaracterUrl($nombre)?>-<?=$idusuario?>" target="_blank"><img src="public/images/avatar/<?=$img_avatar?>" class="object-fit-cover" alt="avatar" style="max-width: 120px; max-height: 80px"></a>
                    </div>
                    <div class="">
                        <div class="card-body">
                            <h6 class="card-title"><?=$nombre?></h6>
                            <p class="card-text"><small class="text-body-secondary"><?=$prov != '' ? $dist.", ".$prov : ''?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
        }

        $RegistrosAMostrar = 30;
        $PaginasIntervalo  = 2;
        $PagAct            = $page;

        $PagUlt = $totalRegistros / $RegistrosAMostrar;
        $res    = $totalRegistros % $RegistrosAMostrar;
        if( $res > 0 ) $PagUlt = floor($PagUlt) + 1;
        ?>

        <nav>
            <ul class="pagination justify-content-end <?=$totalRegistros <= 30 ? 'd-none' : ''?>">
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
    </div>

</div>

<?php echo $this->endSection();?>
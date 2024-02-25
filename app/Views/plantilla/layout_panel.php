<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

<?php
if(!session('idusuario')){
    header('location: '.base_url().'');
    exit();
}
?>

<section class="py-5 content-panelUsu">
    <div class="container d-flex flex-wrap">
        <div class="menu-opciones">
            <div class="accordion accordion-flush" id="accordionMenu">
                <div class="accordion-item">
                    <h2 class="accordion-header border-bottom">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Mis Opciones
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionMenu">
                        <div class="accordion-body p-0">
                            <?php
                                $opt_dash       = isset($opt_dash) ? 'active'      : '';
                                $opt_account    = isset($opt_account) ? 'active'   : '';
                                $opt_anuncios   = isset($opt_anuncios) ? 'active'  : '';
                                $opt_favorite   = isset($opt_favorite) ? 'active'  : '';
                                $opt_publicidad = isset($opt_publicidad) ? 'active': '';

                                $opt_tarifas  = isset($opt_tarifas) ? 'active' : '';
                                $opt_usuarios = isset($opt_usuarios) ? 'active': '';
                            ?>
                            <a href="<?=base_url('panel-usuario')?>" class="text-secondary text-decoration-none d-block p-2 border-bottom bg-light <?php echo $opt_dash?>">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <a href="<?=base_url('mi-cuenta')?>" class="text-secondary text-decoration-none d-block p-2 border-bottom bg-light <?php echo $opt_account?>">
                                <i class="far fa-user"></i> Mi cuenta
                            </a>
                            <a href="#" class="text-secondary text-decoration-none d-block p-2 border-bottom bg-light <?php echo $opt_anuncios?>">
                                <i class="fas fa-bullhorn"></i> <?php echo session('idtipousu') == 1 ? 'Anuncios' : 'Mis anuncios';?>
                            </a>
                            <a href="#" class="text-secondary text-decoration-none d-block p-2 border-bottom bg-light <?php echo $opt_publicidad?>">
                                <i class="fas fa-file-image"></i> <?php echo session('idtipousu') == 1 ? 'Publicidad' : 'Mi publicidad';?>
                            </a>
                            <?php
                            if( session('idtipousu') == 2 ){
                            ?>
                            <a href="#" class="text-secondary text-decoration-none d-block p-2 border-bottom bg-light <?php echo $opt_favorite?>">
                                <i class="far fa-heart"></i> Mis favoritos
                            </a>
                            <?php }?>
                            <?php
                            if( session('idtipousu') == 1 ){
                            ?>
                            <a href="#" class="text-secondary text-decoration-none d-block p-2 border-bottom bg-light <?php echo $opt_tarifas?>">
                                <i class="fas fa-dollar-sign"></i> Tarifas
                            </a>
                            <a href="#" class="text-secondary text-decoration-none d-block p-2 border-bottom bg-light <?php echo $opt_usuarios?>">
                                <i class="fas fa-users"></i> Usuarios
                            </a>
                            <?php }?>                            
                            <a href="<?=base_url('salir')?>" class="text-secondary text-decoration-none d-block p-2 border-bottom bg-light">
                                <i class="far fa-times-circle"></i> Salir 
                                <!-- <a href="<?php //url_to('user_gallery', 15, 12) ?>">View Gallery</a> -->
                            </a>
                        </div>
                    </div>
                </div>                        
            </div>
        </div>

        <div class="data-opciones ps-sm-1 ps-md-4 pt-2">

            <?php echo $this->renderSection("contenido_panel");?>

        </div>
    </div>
</section>

<?php echo $this->endSection();?>
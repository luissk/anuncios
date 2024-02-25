<?php echo $this->extend('plantilla/layout_panel')?>

<?php echo $this->section('contenido_panel');?>

<div class="p-2 mb-3 bg-success text-white bg-gradient fw-bolder fs-5">Dashboard Usuario</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
        <div class="card">
            <div class="card-header bg-warning">Total de Anuncios</div>
            <div class="card-body">                                            
                <p class="card-text text-center fs-2">0</p>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
        <div class="card">
            <div class="card-header bg-warning">Anuncios Activos</div>
            <div class="card-body">                                            
                <p class="card-text text-center fs-2">0</p>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
        <div class="card">
            <div class="card-header bg-warning">Anuncios Inactivos</div>
            <div class="card-body">                                            
                <p class="card-text text-center fs-2">0</p>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
        <div class="card">
            <div class="card-header bg-warning">Anuncios Pendientes</div>
            <div class="card-body">                                            
                <p class="card-text text-center fs-2">0</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-2">
        <div class="card">
            <div class="card-header bg-success">Anuncios Destacados</div>
            <div class="card-body">                                            
                <p class="card-text text-center fs-2">0</p>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>
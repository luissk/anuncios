<?php echo $this->extend('plantilla/layout_panel')?>

<?php echo $this->section('contenido_panel');?>

<?php
/* echo "<pre>"; 
print_r();
echo "</pre>"; */
?>
<div class="card rounded-0">
    <div class="card-header p-2 mb-3 bg-success text-white bg-gradient fw-bolder rounded-0">NUEVO ANUNCIO</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group pb-2">
                    <label for="tipo" class="mb-2 fw-semibold">Tipo de anuncio</label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="">Seleccione</option>                        
                    </select>
                    <p class="text-danger" id="msj-tipo"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group pb-2">
                    <label for="categoria" class="mb-2 fw-semibold">Categoría</label>
                    <select name="categoria" id="categoria" class="form-select">
                        <option value="">Seleccione</option>                        
                    </select>
                    <p class="text-danger" id="msj-categoria"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>
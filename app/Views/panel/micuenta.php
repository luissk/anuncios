<?php echo $this->extend('plantilla/layout_panel')?>

<?php echo $this->section('contenido_panel');?>

<?php 
//print_r($usuario);
?>

<div class="card rounded-0">
    <div class="card-header p-2 mb-3 bg-success text-white bg-gradient fw-bolder rounded-0">DATOS DE TU CUENTA</div>
    <div class="card-body">
        <form id="frmMiCuenta">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group pb-2">
                        <label for="email" class="mb-2 fw-semibold">Usuario Email</label>
                        <p><?=$usuario['us_email']?></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group pb-2">
                        <label for="nombre" class="mb-2 fw-semibold">Nombre o Razon Social</label>
                        <input type="text" class="form-control rounded-0" maxlength="100" name="nombre" id="nombre" value="<?=$usuario['us_nombre_razon']?>">
                        <p class="text-danger" id="msj-nombre"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group pb-2">
                        <label for="dniruc" class="mb-2 fw-semibold">DNI / RUC</label>
                        <input type="text" class="form-control rounded-0" maxlength="11" name="dniruc" id="dniruc" value="<?=$usuario['us_ruc']?>">
                        <p class="text-danger" id="msj-dniruc"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group pb-2">
                        <label for="telefono" class="mb-2 fw-semibold">Teléfono</label>
                        <input type="text" class="form-control rounded-0" maxlength="12" name="telefono" id="telefono" value="<?=$usuario['us_telefono']?>">
                        <p class="text-danger" id="msj-telefono"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group pb-2">
                        <label for="password" class="mb-2 fw-semibold">Contraseña</label>
                        <input type="password" class="form-control rounded-0" maxlength="15" name="password" id="password">
                        <p class="text-danger" id="msj-password"></p>
                    </div>
                </div>

                <div class="col-sm-12">
                    <button class="btn btn-danger">MODIFICAR DATOS</button>
                </div>
            </div>
        </form>
        <div id="msj"></div>
    </div>
</div>
<?php echo $this->endSection();?>

<?php echo $this->section('scripts');?>

<script>
$(function(){
    $('#frmMiCuenta').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: 'modificarDatosUsu',
            data: $(this).serialize(),
            success: function(data){
                //console.log(data);                
                if( data.errors ){
                    $('[id^="msj-"').text("");
                    let errors = data.errors;
                    for( let err in errors ){
                        $('#msj-' + err).text(errors[err]);
                    }
                }
            }
        });
    });
});
</script>

<?php echo $this->endSection();?>
<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

<section class="container filters mt-5">
    <div class="row">
        <div class="col-sm-12">
            <?php if(session('msg_recup')){?>
            <div class="alert alert-<?=session('msg_recup')[0]?> alert-dismissible fade show" role="alert">
                <?=session('msg_recup')[1]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }?>
        </div>
    </div>
    <?php
    if( isset($usuario) && $usuario ){
        $idusuario = $usuario['idusuario'];
        $email     = $usuario['us_email'];
    ?>
    <div class="row d-flex justify-content-center">
        <div class="col-sm-12 col-md-6">
            <div class="card mb-5">
                <div class="card-body">
                    <h5 class="card-title">Hola, <?=$email?></h5>
                    <p class="card-text fw-semibold">Crea una nueva contraseña</p>
                    <form id="frmNuevoPass">
                        <div class="form-group pb-2">
                            <label for="nvoPass" class="mb-2">Contraseña:</label>
                            <input type="password" class="form-control form-control rounded-0" name="nvoPass" id="nvoPass" maxlength="15" autocomplete="off" required>
                            <p class="text-danger" id="msj-nvoPass"></p>
                        </div>
                        <div class="form-group pb-2">
                            <label for="nvoPassConf" class="mb-2">Confirmar contraseña:</label>
                            <input type="password" class="form-control form-control rounded-0" name="nvoPassConf" id="nvoPassConf" maxlength="15" autocomplete="off" required>
                            <p class="text-danger" id="msj-nvoPassConf"></p>
                        </div>                        
                        <button class="btn btn-success mt-3 d-block px-5 form-control-lg" id="btnNuevoPass">Guardar Contraseña</button>
                        <input type="hidden" name="linkRec" id="linkRec" value="<?=$linkrec?>">
                        <p class="text-danger" id="msj-linkRec"></p>
                    </form>
                    <div id="msjrecpass"></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</section>

<?php echo $this->endSection();?>

<?php echo $this->section('scripts');?>

<script>
$(function(){
    $("#frmNuevoPass").on('submit', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnNuevoPass'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            btn.setAttribute('disabled', 'disabled');
            btn.innerHTML = `${btnHTML} PROCESANDO...`;

        $.post('guardarnuevopass', $(this).serialize(), function(data){
            console.log(data);

            $('[id^="msj-"').text("");                
            if( data.errors ){                    
                let errors = data.errors;
                for( let err in errors ){
                    $('#msj-' + err).text(errors[err]);
                }
            }

            $("#msjrecpass").html(data);
            btn.removeAttribute('disabled');
            btn.innerHTML = txtbtn;
        });

    });
})
</script>

<?php echo $this->endSection();?>
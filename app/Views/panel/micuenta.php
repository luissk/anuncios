<?php echo $this->extend('plantilla/layout_panel')?>

<?php echo $this->section('contenido_panel');?>

<?php
/* echo "<pre>"; 
print_r($usuario);
echo "</pre>"; */
?>

<div class="card rounded-0">
    <div class="card-header p-2 mb-3 bg-success text-white bg-gradient fw-bolder rounded-0">DATOS DE TU CUENTA</div>
    <div class="card-body">
        <form id="frmMiCuenta" enctype="multipart/form-data">
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
                <div class="col-sm-12 col-md-3">
                    <div class="form-group pb-2">
                        <label for="telefono" class="mb-2 fw-semibold">Teléfono</label>
                        <input type="text" class="form-control rounded-0" maxlength="12" name="telefono" id="telefono" value="<?=$usuario['us_telefono']?>">
                        <p class="text-danger" id="msj-telefono"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group pb-2">
                        <label for="whatsapp" class="mb-2 fw-semibold">Whatsapp</label>
                        <input type="text" class="form-control rounded-0" maxlength="9" name="whatsapp" id="whatsapp" placeholder="(ejm: 987654321)" value="<?=$usuario['us_whatsapp']?>">
                        <p class="text-danger" id="msj-whatsapp"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group pb-2">
                        <label for="password" class="mb-2 fw-semibold">Contraseña</label>
                        <input type="password" class="form-control rounded-0" maxlength="15" name="password" id="password">
                        <p class="text-danger" id="msj-password"></p>
                    </div>
                </div>                
                <div class="col-sm-12 col-md-8">
                    <div class="form-group pb-2">
                        <label for="direccion" class="mb-2 fw-semibold">Dirección</label>
                        <input type="text" class="form-control rounded-0" maxlength="150" name="direccion" id="direccion" value="<?=$usuario['us_direccion']?>">
                        <p class="text-danger" id="msj-direccion"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group pb-2">
                        <label for="provincia" class="mb-2 fw-semibold">Provincia</label>
                        <select name="provincia" id="provincia" class="form-select">
                            <option value="">Seleccione</option>
                            <?php
                            if( $provincias ){
                                foreach($provincias as $prov){
                                    $provincia = $prov['provincia'];
                                    $idprov    = $prov['idprov'];

                                    $selected_prov = $idprov == $usuario['idprov'] ? 'selected' : '';

                                    echo "<option value='$idprov' $selected_prov>$provincia</option>";
                                }
                            }
                            ?>
                        </select>
                        <p class="text-danger" id="msj-provincia"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group pb-2">
                        <label for="distrito" class="mb-2 fw-semibold">Distrito</label>
                        <select name="distrito" id="distrito" class="form-select">
                            <option value="">Seleccione</option>
                        </select>
                        <p class="text-danger" id="msj-distrito"></p>
                    </div>
                </div>

                <div class="col-sm-12 my-2">
                    
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group pb-2">
                    <label for="web" class="mb-2 fw-semibold">Mi página web</label>
                        <input type="text" class="form-control rounded-0" maxlength="150" name="web" id="web" value="<?=$usuario['us_website']?>">
                        <p class="text-danger" id="msj-web"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group pb-2">
                    <label for="facebook" class="mb-2 fw-semibold">Mi facebook</label>
                        <input type="text" class="form-control rounded-0" maxlength="150" name="facebook" id="facebook" value="<?=$usuario['us_facebook']?>">
                        <p class="text-danger" id="msj-facebook"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group pb-2">
                    <label for="youtube" class="mb-2 fw-semibold">Mi youtube</label>
                        <input type="text" class="form-control rounded-0" maxlength="150" name="youtube" id="youtube" value="<?=$usuario['us_youtube']?>">
                        <p class="text-danger" id="msj-youtube"></p>
                    </div>
                </div> 
                <div class="col-sm-12 col-md-4">
                    <div class="form-group pb-2">
                    <label for="instagram" class="mb-2 fw-semibold">Mi instagram</label>
                        <input type="text" class="form-control rounded-0" maxlength="150" name="instagram" id="instagram" value="<?=$usuario['us_instagram']?>">
                        <p class="text-danger" id="msj-instagram"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group pb-2">
                    <label for="tiktok" class="mb-2 fw-semibold">Mi tiktok</label>
                        <input type="text" class="form-control rounded-0" maxlength="150" name="tiktok" id="tiktok" value="<?=$usuario['us_tiktok']?>">
                        <p class="text-danger" id="msj-tiktok"></p>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 text-center">
                                
                </div>
                <div class="row py-3">
                    <div class="col-sm-8">
                        <div class="mb-3">
                            <label for="avatar" class=" fw-semibold">Subir una imagen como avatar o logo</label>
                            <input class="form-control" type="file" id="avatar" name="avatar">
                            <p class="text-danger" id="msj-avatar"></p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="image-avatar">
                            <?php 
                            if( $usuario['us_avatar'] != '' ){
                                echo "<img src='".base_url('public/images/avatar/'.$usuario['us_avatar'].'')."?v=".time()."' alt='avatar'>";
                                echo "<br>";
                                echo "<a class='text-decoration-none text-danger eliminarAvatar btn' data-avatar='".$usuario['us_avatar']."'><i class='fas fa-trash-alt'></i> eliminar avatar</a>";
                            }else{
                                echo "<img src='".base_url('public/images/avatar/default.png')."' alt='avatar'>";
                            }
                            ?>
                        </div>
                    </div>                    
                </div>

                <div class="col-sm-12">
                    <button class="btn btn-danger" id="btnModificaDatos">MODIFICAR DATOS</button>
                    
                    <div class="progress mt-2 d-none">
                        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                    </div>
                </div>
            </div>
        </form>
        <div id="msj"></div>
    </div>
</div>

<?php echo $this->endSection();?>


<?php echo $this->section('scriptsPanel');?>

<script>
$(function(){  
    $('#provincia').on('change', function(e){
        let idprov = $(this).val(),
            iddist_bd = <?=$usuario['iddist'] != '' ? $usuario['iddist']  : '0' ?>;
        
        $.post('distritosUsu', {
            idprov, iddist_bd
        }, function (data){
            $('#distrito').html(data);
        })
    });

    <?php
    if( $usuario['idprov'] != '' ){
    ?>
        $("#provincia").trigger("change");
        
    <?php
    }
    ?>

    $('#frmMiCuenta').on('submit', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnModificaDatos'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;

        let formData = new FormData(this);
        
        let progress = $('.progress'), 
            progress_bar = $('.progress-bar');

        progress.removeClass('d-none');

        $.ajax({
            method: 'POST',
            url: 'modificarDatosUsu',
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(data){
                //console.log(data);
                $('[id^="msj-"').text("");                
                if( data.errors ){                    
                    let errors = data.errors;
                    for( let err in errors ){
                        $('#msj-' + err).text(errors[err]);
                    }
                }
                btn.removeAttribute('disabled');
                btn.innerHTML = txtbtn;
                $('#msj').html(data);
            },
            xhr: function() {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        //console.log(percentComplete);
                        progress_bar.width(percentComplete + "%").text(percentComplete + "%");

                        if (percentComplete === 100) {
                            progress.addClass('d-none');
                        }
                    }
                }, false);

                return xhr;
            }

        });
    });


    $('#avatar').on('change', function(){
        let tipos = ['image/jpeg','image/jpg'];
        let file = this.files[0];
        let tipofile = file.type;
        let sizefile = file.size;

        if(!tipos.includes(tipofile)){
            Swal.fire({
                text: "LA IMAGEN DEBE ESTAR EN FORMATO JPG",
                icon: "info"
            });
            $(this).val('');
            return false;
        }
        if(sizefile >= 2097152){
            Swal.fire({
                text: "LA IMAGEN NO DEBE SER MAYOR A 2MB",
                icon: "info"
            });
            $(this).val('');
            return false;
        }
    });

    $('.eliminarAvatar').on('click', function(e){
        let avatar = $(this).data('avatar');

        $.post('eliminarAvaUsu', {
            avatar
        }, function(data){
            $('#msj').html(data);
        });
    });

});
</script>

<?php echo $this->endSection();?>
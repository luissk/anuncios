<?php echo $this->extend('plantilla/layout_panel')?>

<?php echo $this->section('contenido_panel');?>

<?php
/* echo "<pre>"; 
print_r();
echo "</pre>"; */
?>
<div class="card rounded-0">
    <div class="card-header p-2 mb-3 bg-success text-white bg-gradient fw-bolder rounded-0">NUEVO ANUNCIO</div>
    <div class="card-body create_anuncio">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group pb-2">
                    <label for="tipo" class="mb-2 fw-semibold bg-light d-block">Tipo de anuncio</label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="">Seleccione</option>
                        <?php
                        if( $tipos ){
                            foreach($tipos as $tipo){
                                $idtipo = $tipo['idtipo_anuncio'];
                                $tipo   = $tipo['ta_tipo'];

                                //$selected_prov = $idprov == $usuario['idprov'] ? 'selected' : '';

                                echo "<option value='$idtipo'>$tipo</option>";
                            }
                        }
                        ?>                        
                    </select>
                    <p class="text-danger" id="msj-tipo"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group pb-2">
                    <label for="categoria" class="mb-2 fw-semibold bg-light d-block">Categoría</label>
                    <select name="categoria" id="categoria" class="form-select">
                        <option value="">Seleccione</option>
                        <?php
                        if( $tipos ){
                            foreach($categorias as $cate){
                                $idcate    = $cate['idcate'];
                                $categoria = $cate['categoria'];

                                echo "<option value='$idcate'>$categoria</option>";
                            }
                        }
                        ?>                       
                    </select>
                    <p class="text-danger" id="msj-categoria"></p>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group pb-2">
                    <label for="nombre" class="mb-2 fw-semibold bg-light d-block">Título o nombre de tu anuncio</label>
                    <input type="text" class="form-control rounded-0" maxlength="100" name="nombre" id="nombre">
                    <p class="text-danger" id="msj-nombre"></p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group pb-2">
                    <label for="precio" class="mb-2 fw-semibold bg-light d-block">Precio (S/.)</label>
                    <input type="text" class="form-control rounded-0" maxlength="15" name="precio" id="precio">
                    <p class="text-danger" id="msj-precio"></p>
                </div>
            </div>
            <div class="col-sm-8 d-flex align-items-sm-start align-items-md-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="nomostrar" name="nomostrar">
                    <label class="form-check-label" for="nomostrar">
                        No mostrar precio
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group pb-2">
                    <label for="caracteristicas" class="mb-2 fw-semibold bg-light d-block">Características</label>
                    <textarea class="form-control rounded-0" name="caracteristicas" id="caracteristicas" rows="7"></textarea>
                    <p class="text-danger" id="msj-caracteristicas"></p>
                </div>
            </div>
            <div class="col-sm-6 d-flex align-items-center texto-size-13">
                <i class="text-secondary">Ingrese una característica por cada línea. Ejemplo:<br>
                    Característica 1<br>
                    Característica 2<br>
                    Característica 3<br>
                    ...
                </i>
            </div>
            <div class="col-sm-12">
                <div class="form-group pb-2">
                    <label for="descripcion" class="mb-2 fw-semibold bg-light d-block">Descripción</label>
                    <textarea class="form-control rounded-0" name="descripcion" id="descripcion" rows="10"></textarea>
                    <p class="text-danger" id="msj-descripcion"></p>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group pb-2">
                    <label for="video" class="mb-2 fw-semibold bg-light d-block bg-light d-block">Video Youtube URL o link</label>
                    <p class="text-secondary texto-size-13">Ejemplo: https://www.youtube.com/watch?v=p6vN06ypccM</p>
                    <input type="text" class="form-control rounded-0" maxlength="150" name="video" id="video">
                    <p class="text-danger" id="msj-video"></p>
                </div>
            </div>
            <div class="col-sm-12">
                <p class="fw-semibold bg-light">Sube Hasta 5 imágenes de tu Anuncio</p>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="imagenes" class="">Agrega tus imágenes <i class="text-secondary texto-size-13">(Sólo en formato (JPEG | JPG) y tamaño max. 3 MB </i></label>
                        <input class="form-control" type="file" id="imagenes" name="imagenes[]" multiple>
                        <p class="text-danger" id="msj-imagenes"></p>
                    </div>
                    <div class="col-sm-12">
                        <div class="d-flex justify-content-start flex-wrap" id="content_images">
                            <!-- <div class="item-img position-relative me-4">
                                <img src="public/img/anuncios/helado.jpg" class="img-thumbnail" alt="images">
                                <a class="position-absolute top-0 start-100 translate-middle badge  bg-danger" title='eliminar' href="#">
                                    <i class='fas fa-trash-alt'></i>
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalImg" tabindex="-1" aria-labelledby="modalImgLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-12 text-center">
                <img src="public/img/anuncios/campaña.jpg" alt="images" id="imgModalShow" style="max-width: 100%;">
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php echo $this->endSection();?>


<?php echo $this->section('scriptsPanel');?>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>

/*** IMAGENES ***/
let arr_images = [];
let content_images = document.querySelector("#content_images");

function verImg(img){
    $('#imgModalShow').attr('src', img.src);
    $('#modalImg').modal('show');
}

function eliminarImg(el_arr, el){
    arr_images.forEach((item, index) => {
        if (item.lastModified === el_arr) {
            arr_images.splice(index, 1);
        }
    });
    el.parentElement.remove();
    console.log(arr_images);
}

function printImages(){
    content_images.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
    if( arr_images.length > 0 ){      
        content_images.innerHTML = '';

        arr_images.map((file, i) => {
            let el_arr = arr_images[i].lastModified;
            const blobUrl = window.URL.createObjectURL(file)
            content_images.innerHTML += `
                <div class="item-img position-relative me-4">
                    <img src="${blobUrl}" class="img-thumbnail" alt="${file.name}" onclick="verImg(this)">
                    <a class="btn position-absolute top-0 start-100 translate-middle badge  bg-danger" title='eliminar' onclick='eliminarImg(${el_arr}, this)'>
                        <i class='fas fa-trash-alt'></i>
                    </a>
                </div>
            `;
        });
    }    
}
/*** FIN IMAGENES ***/

$(function(){
    /*** IMAGENES ***/
    $('#imagenes').on('change', function(e){
        let images = this.files,
            total = images.length,
            tipos = ['image/jpeg','image/jpg'];

        if( total > 0 && total <= 5 ){
            for( let i = 0; i < total; i++ ){
                let tipo = images[i].type,
                    tamaño = images[i].size;
                
                if( tamaño == 0 ){ 
                    Swal.fire({text: "Imagen invàlida: " + images[i].name, icon: "info"});
                    continue;
                }

                if( !tipos.includes(tipo) ){
                    Swal.fire({ text: "Cada imagen debe estar en formato JPG o JPEG", icon: "info"});
                    continue;
                }

                if( tamaño > 3145728 ){ //3145728
                    Swal.fire({text: "Cada imagen no debe ser mayor a 3MB", icon: "info"});
                    continue;
                }

                if( arr_images.length >= 5 ) {
                    Swal.fire({text: "Sólo 5 imágenes como máximo", icon: "info"});
                    continue;
                }           
                arr_images.push(images[i]);
            }
            printImages();
            $(this).val('');
        }

        if( total > 5 ){
            Swal.fire({text: "Sólo 5 imágenes como máximo", icon: "info"});
        }
    }); 
    
    /*** FIN IMAGENES ***/

    /*** PRECIO ***/
    $('#nomostrar').on('click', function(e){
        if( $(this).is(':checked') ){
            $("#precio").attr('disabled','disabled');
            $("#precio").val('');
        }else{
            $("#precio").removeAttr('disabled');
        }
    });

    $("#precio").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    /*** FIN PRECIO ***/

    /*** DESCRIPCION ***/
    CKEDITOR.replace( 'descripcion', {
        removePlugins: 'image,tabletools,tableselection',
    } );
    /*** FIN DESCRIPCION ***/
    
});
</script>

<?php echo $this->endSection();?>


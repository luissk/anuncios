<?php echo $this->extend('plantilla/layout_panel')?>

<?php echo $this->section('contenido_panel');?>

<?php
/* echo "<pre>"; 
print_r();
echo "</pre>"; */
?>

<div class="col-sm-12 text-end">
    <a class="btn btn-outline-danger" href="publicar-anuncio">Nuevo Anuncio</a>
</div>

<div class="mis-anuncios mt-4">
    <div class="anuncio border">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem fugit nihil maiores, officia praesentium dolorum ea laudantium, consectetur nisi, exercitationem aliquid sit quasi enim id repudiandae reiciendis voluptate voluptatem aliquam.
    </div>
</div>

<?php echo $this->endSection();?>
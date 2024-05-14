<?php echo $this->extend('plantilla/layout_panel')?>

<?php echo $this->section('csslinks');?>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.csss">
<?php echo $this->endSection();?>

<?php echo $this->section('contenido_panel');?>

<?php
/* echo "<pre>"; 
print_r($favoritos);
echo "</pre>"; */
?>
<div class="row">
    <div class="col-sm-12 mb-3">
        <h4 class="text-center">Anuncios favoritos</h4>
    </div>
    <div class="col-sm-12">
        <table class="table table-striped" style="width: 100%;" id="dtFav">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Categoria</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if( $favoritos ){
                    foreach( $favoritos as $fav ){
                        $idfavorito = $fav['idfavorito'];
                        $idanuncio  = $fav['idanuncio'];
                        $nombre     = $fav['an_nombre'];
                        $tipo       = $fav['ta_tipo'];
                        $categoria  = $fav['categoria'];
                        $codanuncio = $fav['codanuncio'];
                        $img_thumb  = $fav['img_thumb'];

                        $img = help_folderAnuncio().$codanuncio."/".$img_thumb;

                        $url = help_reemplazaCaracterUrl($nombre)."-".$idanuncio;

                        echo "<tr>";

                        echo "<td>
                            <a href='".base_url('anuncio-'.$url.'')."' target='_blank'>
                            <img src='$img' style='max-width: 100px'/>
                            </a>
                        </td>";
                        echo "<td>$nombre</td>";
                        echo "<td>$tipo</td>";
                        echo "<td>$categoria</td>";
                        echo '<td>
                            <a class="btn deleteFavorite" data-id="'.$idfavorito.'">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>';

                        echo "</tr>";
                    }                    
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div id="msjFav"></div>

<?php echo $this->endSection();?>


<?php echo $this->section('scriptsPanel');?>

<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>
<script>
//new DataTable('#example');
var table = new DataTable('#dtFav', {
    language: {
        url: 'https://cdn.datatables.net/plug-ins/2.0.7/i18n/es-MX.json',
    },
    responsive: true
});

$(function(){
    $("#dtFav").on('click', '.deleteFavorite', function(e){
        e.preventDefault();
        let id = $(this).data('id');

        $.post('deletefavorite', {
            id
        }, function(data){
            $("#msjFav").html(data);
        })
    })
})
</script>

<?php echo $this->endSection();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title;?></title>

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import bootstrap.css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo base_url();?>public/css/style.css">

    <script src="https://kit.fontawesome.com/6bea3db884.js" crossorigin="anonymous"></script>

    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bolder text-success" href="<?php echo base_url();?>">Anuncios del Valle</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar" aria-controls="mynavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav d-flex justify-content-between mx-lg-auto">
                    <li class="nav-item pe-3">
                        <a class="nav-link <?php echo isset($act_menuinicio) ? 'active' : ''?>" aria-current="page" href="<?php echo base_url();?>"><i class="fas fa-home"></i> Inicio</a>
                    </li>
                    <li class="nav-item pe-3">
                        <a class="nav-link <?php echo isset($act_menuanuncios) ? 'active' : ''?>" href="<?php echo base_url();?>"><i class="fas fa-bullhorn"></i> Anuncios</a>
                    </li>
                    <li class="nav-item pe-3">
                        <a class="nav-link <?php echo isset($act_menucontact) ? 'active' : ''?>" href="<?php echo base_url();?>"><i class="fas fa-address-book"></i> Contáctanos</a>
                    </li>
                    <li class="nav-item pe-3">
                        <a class="btn btn-danger" >Publica Anuncio</a>
                    </li>
                </ul>
                <ul class="navbar-nav  mb-2 mb-lg-0 d-flex justify-content-end">
                    <?php
                    if( !session('idusuario') ){
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="ingresar"><i class="fas fa-sign-in-alt"></i> Ingresar</a>
                    </li>
                    <?php 
                    }else{
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                            $email_cut = explode('@', session('email'));
                            $email_cut = $email_cut[0];
                            ?>
                            <i class="fas fa-user"></i> <?=$email_cut?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">                           
                            <li><a class="dropdown-item" href="<?php echo base_url('panel-usuario')?>">Mi Panel</a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('salir')?>">Salir</a></li>
                        </ul>
                    </li>
                    <?php
                    }
                    ?>
                </ul>                
            </div>
        </div>
    </nav>


    <div class="contenido">
        <?php echo $this->renderSection("contenido");?>
    </div>



    <footer class="bg-success text-white">
        <div class="container py-5">
            <div class="row">
                <div class="col-sm-4">
                    <h4 class="border-bottom border-2 pb-2 text-center">Anuncios del Valle</h4>
                    <div class="py-2">
                        <i class="fas fa-map-marker-alt"></i> 123 Casa Grande, La Libertad
                    </div>
                    <div class="py-2">
                        <i class="fas fa-phone"></i> +51 999777666
                    </div>
                    <div class="py-2">
                        <i class="fas fa-envelope"></i> micorreo@mi-empresa.com
                    </div>
                </div>
                <div class="col-sm-4">
                    <h4 class="border-bottom border-2 pb-2 text-center">Categorías</h4>
                    <div class="py-2">
                        <a href="#" class="text-decoration-none text-white">Restaurants</a>
                    </div>
                    <div class="py-2">
                        <a href="#" class="text-decoration-none text-white">Inmuebles</a>
                    </div>
                    <div class="py-2">
                        <a href="#" class="text-decoration-none text-white">Tiendas</a>
                    </div>
                    <div class="py-2">
                        <a href="#" class="text-decoration-none text-white">Tecnología</a>
                    </div>
                    <div class="py-2">
                        <a href="#" class="text-decoration-none text-white">Servicios</a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <h4 class="border-bottom border-2 pb-2 text-center">Términos</h4>
                    <div class="py-2">
                        <a href="#" class="text-decoration-none text-white">Otros</a>
                    </div>
                    <div class="py-2">
                        <a href="#" class="text-decoration-none text-white">Otros</a>
                    </div>
                    <div class="py-2">
                        <a href="#" class="text-decoration-none text-white">Otros</a>
                    </div>
                    <div class="py-2">
                        <a href="#" class="text-decoration-none text-white">Otros</a>
                    </div>
                </div>
            </div>

            <div class="row py-3">
                <div class="col-sm-8">
                    <ul class="list-inline text-left footer-icons">
                        <li class="list-inline-item border border-light rounded-circle text-center p-2">
                            <a class="text-light text-decoration-none" target="_blank" href="http://facebook.com/"><i class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center p-2">
                            <a class="text-light text-decoration-none" target="_blank" href="https://www.instagram.com/"><i class="fab fa-instagram fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center p-2">
                            <a class="text-light text-decoration-none" target="_blank" href="https://twitter.com/"><i class="fab fa-twitter fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center p-2">
                            <a class="text-light text-decoration-none" target="_blank" href="https://www.linkedin.com/"><i class="fab fa-linkedin fa-lg fa-fw"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-4">                      
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Ingresa tu email" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-dark" type="button" id="button-addon2">Suscríbete</button>
                    </div>                      
                </div>
            </div>
        </div>

        <section class="footer-end text-center py-4">
            Copyright &copy; <?php echo date('Y');?> Anuncios del Valle | Luis A. Calderón Sánchez
        </section>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    
    <script src="<?php echo base_url();?>public/js/home.js"></script>

    <?php echo $this->renderSection("scripts");?>
</body>
</html>
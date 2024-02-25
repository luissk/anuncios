<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 py-2">
                <div class="card border-0">
                    <h5 class="card-header border-0 px-sm-2 px-md-5"><i class="fas fa-sign-in-alt"></i> Inicia Sesión</h5>
                    <?php if(session('msg_login')){?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?=session('msg_login')?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php }?>
                    <div class="card-body px-sm-2 px-md-5">
                        <form id="frmLogin" method="post">
                            <div class="form-group pb-2">
                                <label for="loginEmail" class="mb-2">Ingresa tu email</label>
                                <input type="email" class="form-control form-control-lg rounded-0" maxlength="100" name="loginEmail" id="loginEmail" value="<?=old('loginEmail');?>">
                                <p class="text-danger"><?=session('errors.loginEmail')?></p>
                            </div>
                            <div class="form-group pb-2">
                                <label for="loginPassword" class="mb-2">Ingresa tu contraseña</label>
                                <input type="password" class="form-control form-control-lg rounded-0" name="loginPassword" id="loginPassword" maxlength="15">
                                <p class="text-danger"><?=session('errors.loginPassword')?></p>
                            </div>

                            <button class="btn btn-danger mt-3 d-block px-5 form-control-lg" id="btnLogin">Ingresar</button>
                        </form>
                        <div class="text-end">
                            <a href="#" class="link-dark">¿Olvidaste tu Contraseña?</a>
                        </div>
                        <hr>
                        <p>o Ingresa con: </p>
                        <p><a href="#" class="btn btn-outline-secondary w-50"><i class="fab fa-google"></i> Google</a></p>
                        <p><a href="#" class="btn btn-outline-primary w-50"><i class="fab fa-facebook"></i> Facebook</a></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 py-2">
                <div class="card border-0">
                    <h5 class="card-header border-0 px-sm-2 px-md-5"><i class="fas fa-clipboard"></i> Regístrate</h5>
                    <?php if(session('msg_register')){?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>¡Registro Correcto!</strong> Ya puede iniciar sesión.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php }?>
                    <div class="card-body px-sm-2 px-md-5">
                        <form id="frmRegister" method="post">
                            <div class="form-group pb-2">
                                <label for="regNombre" class="mb-2">Nombre Completo (ejm: Juan Perez Vasquez)</label>
                                <input type="text" class="form-control form-control-lg rounded-0" name="regNombre" id="regNombre" maxlength="100" value="<?=old('regNombre');?>">
                                <p class="text-danger"><?=session('errors.regNombre')?></p>
                            </div>
                            <div class="form-group pb-2">
                                <label for="regFono" class="mb-2">Teléfono</label>
                                <input type="text" class="form-control form-control-lg rounded-0" name="regFono" id="regFono" maxlength="12" value="<?=old('regFono');?>">
                                <p class="text-danger"><?=session('errors.regFono')?></p>
                            </div>
                            <div class="form-group pb-2">
                                <label for="regEmail" class="mb-2">Email</label>
                                <input type="email" class="form-control form-control-lg rounded-0" name="regEmail" id="regEmail" maxlength="100" value="<?=old('regEmail');?>">
                                <p class="text-danger"><?=session('errors.regEmail')?></p>
                            </div>
                            <div class="form-group pb-2">
                                <label for="regPassword" class="mb-2">Contraseña</label>
                                <input type="password" class="form-control form-control-lg rounded-0" name="regPassword" id="regPassword" maxlength="15">
                                <p class="text-danger"><?=session('errors.regPassword')?></p>
                            </div>
                            <div class="form-group pb-2">
                                <label for="regConfPassword" class="mb-2">Confirmar contraseña</label>
                                <input type="password" class="form-control form-control-lg rounded-0" name="regConfPassword" id="regConfPassword" maxlength="15">
                                <p class="text-danger"><?=session('errors.regConfPassword')?></p>
                            </div>
                            <div class="form-check pt-2">
                                <input class="form-check-input" type="checkbox" name="regPolitica" id="regPolitica" value="1">
                                <label class="form-check-label" for="regPolitica">
                                    Sus datos personales se utilizarán para respaldar su experiencia en este sitio web, para administrar el acceso a su cuenta y para otros fines descritos en nuestra <a href="#" class="text-decoration-none">privacy policy</a>
                                </label>
                            </div>
                            <p class="text-danger"><?=session('errors.regPolitica')?></p>

                            <button class="btn btn-danger mt-3 d-block px-5 form-control-lg" id="btnRegister">Registrarse</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php echo $this->endSection();?>


<?php echo $this->section('scripts');?>
<script src="https://www.google.com/recaptcha/api.js?render=6Ld-2nUpAAAAAOjkVUnJYb8ty2crvJt7F2BNcgqA"></script>

<script>
    $(function(){
        $("#btnLogin").on('click', function(e){
            e.preventDefault();
            $(this).attr('disabled', 'disabled');
            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verificando');
            grecaptcha.ready(function() {
                grecaptcha.execute('6Ld-2nUpAAAAAOjkVUnJYb8ty2crvJt7F2BNcgqA', {
                    action: 'LOGIN'
                }).then(function(token) {
                    $("#frmLogin").prepend('<input type="hidden" name="token" value="'+token+'"> ');
                    $("#frmLogin").prepend('<input type="hidden" name="action" value="login"> ');
                    $("#frmLogin").submit();
                });
            });
        });

        $("#btnRegister").on('click', function(e){
            e.preventDefault();
            $(this).attr('disabled', 'disabled');
            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Validando');
            grecaptcha.ready(function() {
                grecaptcha.execute('6Ld-2nUpAAAAAOjkVUnJYb8ty2crvJt7F2BNcgqA', {
                    action: 'REGISTER'
                }).then(function(token) {
                    $("#frmRegister").prepend('<input type="hidden" name="token" value="'+token+'"> ');
                    $("#frmRegister").prepend('<input type="hidden" name="action" value="register"> ');
                    $("#frmRegister").submit();
                });
            });
        });
    });
</script>
<?php echo $this->endSection();?>
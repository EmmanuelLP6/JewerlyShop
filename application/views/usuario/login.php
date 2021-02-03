<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Login</title>
    <!-- Favicon--> 
    <link rel="icon" href="<?php echo base_url('imagenes/logo/logo.png'); ?>" type="image/png">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>css/style.css" rel="stylesheet">
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <!-- <a href="javascript:void(0);"><b>Iniciar sesión</b></a> -->
            <!-- <small>Admin BootStrap Based - Material Design</small> -->
        </div>
        <div class="card">
            <div class="body">
                <!-- <form id="sign_in" method="POST"> -->
                  <?php echo form_open(base_url('usuario/login/validar'),'id="sign_in"'); ?>
                        <center>
                            <img src="<?php echo base_url('uploads/icons/user.jpg'); ?>" width="50%" id="preview" class="img-circle">
                            <div class="msg">Ingresa tus credenciales</div>
                        </center><hr>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person</i>
                            </span>
                            <div class="form-line">
                                <input type="email" class="form-control" name="email" placeholder="ejemplo@dominio.com" required autofocus>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="password" placeholder="*******" required>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-xs-8 p-t-5">
                                <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                                <label for="rememberme">Remember Me</label>
                            </div> -->
                            <div class="col-xs-12">
                                <button class="btn btn-block bg-blue waves-effect" type="submit">Entrar</button>
                            </div>
                        </div>
                        <div class="row m-t-15 m-b--20">
                            <!-- <div class="col-xs-6 align-right">
                                <a href="forgot-password.html">Forgot Password?</a>
                            </div> -->
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>plugins/jquery-validation/jquery.validate.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- Bootstrap Notify Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>plugins/bootstrap-notify/bootstrap-notify.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>plugins/node-waves/waves.js"></script>
    <!-- Custom Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>js/admin.js"></script>
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/'); ?>js/pages/examples/sign-in.js"></script>
    <script type="text/javascript">
        <?php echo mostrar_mensaje(); ?>
    </script>

</body>

</html>

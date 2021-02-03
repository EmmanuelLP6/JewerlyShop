<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $titulo_tarea; ?></title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Icone Here-->
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/bootstrap/css/bootstrap.css');?>" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/node-waves/waves.css');?>" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/animate-css/animate.css');?>" rel="stylesheet" />
    <!-- Morris Chart Css-->
    <link href="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/morrisjs/morris.css');?>" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="<?php echo base_url('recursos-plantilla/AdminBSB/css/style.css');?>" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url('recursos-plantilla/AdminBSB/css/themes/all-themes.css');?>" rel="stylesheet" />
    <!-- JQuery DataTable Css -->
    <link href="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css');?>" rel="stylesheet">
    <!-- Bootstrap Select Css -->
    <link href="<?php echo base_url('recursos-plantilla/AdminBSB//plugins/bootstrap-select/css/bootstrap-select.css');?>" rel="stylesheet" />
    <!-- Base -->
    <link href="<?php #echo base_url('recursos-plantilla/AdminBSB/');?>" rel="stylesheet">
</head>

<body class="theme-pink">
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo base_url('principal/'.$this->constantes->TAREA_DASHBOARD); ?>">Shop</a>
            </div>
            <!-- Menú lateral -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">7</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>12 new members joined</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 14 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                    <!-- #END# Notifications -->
                </ul>
            </div>
            <!-- End Menú Lateral -->
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="
                    <?php echo base_url(($this->session->userdata($this->constantes->CLAVE_SESION.'imagen_usuario')  != NULL ? 'uploads/users/'.$this->session->userdata($this->constantes->CLAVE_SESION.'imagen_usuario') : 'uploads/icons/user.jpg'));?>" width="50" height="50" alt="Usuario" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><B><?php echo $this->session->userdata($this->constantes->CLAVE_SESION.'nombre_usuario') ?></B></div>
                    <div class="email"><?php echo $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual')['nombre']; ?></div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <?php echo $menu_lateral; ?>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.5
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#settings" data-toggle="tab">Configuración</a></li>
                <li role="presentation"><a href="#rol" data-toggle="tab">Roles</a></li>
            </ul>
            <div class="tab-content">
                <style media="screen">
                    a.class_a_href{
                        text-decoration: none;
                        color: black;
                    }/*End a.class_a_href*/
                </style>
                <div role="tabpanel" class="tab-pane fade in active in active" id="settings">
                    <!-- <p>CONFIGURACIÓN GENERAL</p> -->
                    <ul class="demo-choose-skin">
                        <li data-theme="black">
                            <a class="class_a_href" href="<?php echo base_url('principal/'.$this->constantes->TAREA_PERFIL); ?>">
                                <i class="material-icons">person</i>
                                <span>Perfil</span>
                        </li>
                        <li data-theme="black">
                            <a class="class_a_href" href="<?php echo base_url('principal/'.$this->constantes->TAREA_LOGOUT); ?>">
                                <i class="material-icons">input</i>
                                <span>Salir</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="rol">
                    <div class="demo-settings">
                        <ul class="demo-choose-skin">
                            <?php
								$count=0;
								foreach ($this->session->userdata($this->constantes->CLAVE_SESION.'roles') as $key) {
									if($key['clave'] != $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual')['clave']) {
                                        echo '
                                            <li data-theme="black">
                                                <a class="class_a_href" href="'.base_url('usuario/cambio_de_rol/'.$key['clave']).'">
                                                    <i class="material-icons">person</i>
                                                    <span>'.$key['nombre'].'</span>
                                                </a>
                                            </li>
                                        ';
									}
								}//end of foreach
							?>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Contenido del Cuerpo -->
            <?php echo $contenido; ?>
            <!-- End contenido del Cuerpo -->
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/jquery/jquery.min.js');?>"></script>
    <!-- Select Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/');?>plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/');?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/');?>plugins/node-waves/waves.js"></script>
    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/jquery-datatable/jquery.dataTables.js');?>"></script>
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js');?>"></script>
    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/bootstrap/js/bootstrap.js');?>"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/jquery-slimscroll/jquery.slimscroll.js');?>"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/node-waves/waves.js');?>"></script>
    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/jquery-countto/jquery.countTo.js');?>"></script>
    <!-- Morris Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/raphael/raphael.min.js');?>"></script>
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/morrisjs/morris.js');?>"></script>
    <!-- ChartJs -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/chartjs/Chart.bundle.js');?>"></script>
    <!-- Flot Charts Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/flot-charts/jquery.flot.js');?>"></script>
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/flot-charts/jquery.flot.resize.js');?>"></script>
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/flot-charts/jquery.flot.pie.js');?>"></script>
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/flot-charts/jquery.flot.categories.js');?>"></script>
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/flot-charts/jquery.flot.time.js');?>"></script>
    <!-- Sparkline Chart Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/jquery-sparkline/jquery.sparkline.js');?>"></script>
    <!-- Custom Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/js/admin.js');?>"></script>
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/js/pages/index.js');?>"></script>
    <!-- Demo Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/js/demo.js');?>"></script>
    <!-- Bootstrap Notify Plugin Js -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/plugins/bootstrap-notify/bootstrap-notify.js'); ?>"></script>
    <!-- Funciones globales -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/js/funciones.js');?>"></script>
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/js/formularios.js');?>"></script>
    <!-- JS base -->
    <script src="<?php echo base_url('recursos-plantilla/AdminBSB/js/sweetalert.min.js');?>"></script>
    <!-- JS base -->
    <script src="<?php #echo base_url('recursos-plantilla/AdminBSB/');?>"></script>
    <script type="text/javascript">
        <?php echo mostrar_mensaje(); ?>
        // $(window).load(function(){
        //
        // });
    </script>
</body>

</html>

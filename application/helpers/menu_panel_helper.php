<?php
    //MENU SETTINGS
    if (!function_exists('configurar_menu_lateral')) {
        function configurar_menu_lateral($rol_actual){
            $CI =& get_instance();
            $CI->load->library('constantes');
            $menu = array();
            $menu_item = array();
            $sub_menu_item = array();
            /**
                ALL OPTIONS
            **/
            //Dashboard
            $menu_item = array();
            $menu_item['is_active'] = false;
            $menu_item['href'] = base_url('principal/'.$CI->constantes->TAREA_DASHBOARD);
            $menu_item['icon'] = 'wifi_tethering';
            $menu_item['text'] = 'Dashboard';
            $menu_item['submenu'] = array();
            $menu['dashboard'] = $menu_item;

            if ( in_array($rol_actual['clave'], array($CI->constantes->ROL_SUPERADMIN['clave'])) ) {
                //Usuario
                $menu_item = array();
                $menu_item['is_active'] = false;
                $menu_item['href'] = base_url('principal/'.$CI->constantes->TAREA_USUARIO_TODOS);
                $menu_item['icon'] = 'contacts';
                $menu_item['text'] = 'Usuarios';
                $menu_item['submenu'] = array();
                $menu['usuarios'] = $menu_item;

            }//End if show all options for the super admin

            /**
                EXAMPLE SUBMENU
            **/
            $menu_item = array();
            $menu_item['is_active'] = false;
            $menu_item['href'] = '#';
            $menu_item['icon'] = 'trending_down';
            $menu_item['text'] = 'Multi Level Menu';
            $menu_item['submenu'] = array();
                //Option 1
                $sub_menu_item = array();
                $sub_menu_item['is_active'] = false;
                $sub_menu_item['href'] = base_url('principal/'.$CI->constantes->TAREA_USUARIO_TODOS);
                $sub_menu_item['text'] = 'Opcion 1';
                $menu_item['submenu']['option_1'] = $sub_menu_item;
                //Option 2
                $sub_menu_item = array();
                $sub_menu_item['is_active'] = false;
                $sub_menu_item['href'] = base_url('principal/'.$CI->constantes->TAREA_USUARIO_TODOS);
                $sub_menu_item['text'] = 'Opcion 2';
                $menu_item['submenu']['option_2'] = $sub_menu_item;
            $menu['multi_level'] = $menu_item;

            return $menu;
        }//End function configurar_menu_lateral
    }//End if configurar_menu_lateral

    if (!function_exists('activar_menu_item')) {
        function activar_menu_item($tarea_actual, $menu) {
            $CI =& get_instance();
            $CI->load->library('constantes');

            /**
                ACTIVE OPTION
            **/
            if ($tarea_actual == $CI->constantes->TAREA_DASHBOARD) {
                $menu['dashboard']['is_active'] = TRUE;
            }//end if TAREA DASHBOARD
            if ($tarea_actual == $CI->constantes->TAREA_USUARIO_TODOS) {
                $menu['usuarios']['is_active'] = TRUE;
            }//end if TAREA DASHBOARD
            return $menu;
        }//End function activar_menu_item
    }//End if activar_menu_item

    if (!function_exists('crear_menu_lateral')) {
        function crear_menu_lateral($tarea_actual, $rol_actual){
            $CI =& get_instance();
            $CI->load->helper('menu_panel_helper');
            $menu = configurar_menu_lateral($rol_actual);
            $menu = activar_menu_item($tarea_actual, $menu);
            $html = '';
            /**
                START MENU
            **/
            $html.= '
                    <ul class="list">
                        <li class="header">MENÚ DE NAVEGACIÓN</li>
            ';
                        foreach ($menu as $menu_item) {
                            if ($menu_item['href'] != '#') {
                                $html.='
                                    <li class="'.(($menu_item['is_active'])?'active':'').'">
                                        <a href="'.$menu_item['href'].'">
                                            <i class="material-icons">'.$menu_item['icon'].'</i>
                                            <span>'.$menu_item['text'].'</span>
                                        </a>
                                    </li>
                                ';
                            }//End if $menu_item['href']
                            else{
                                $html.='
                                    <li class="'.(($menu_item['is_active'])?'active':'').'">
                                        <a href="'.$menu_item['href'].'" class="menu-toggle">
                                            <i class="material-icons">'.$menu_item['icon'].'</i>
                                            <span>'.$menu_item['text'].'</span>
                                        </a>';
                                        if(sizeof($menu_item['submenu']) > 0){
                                            $html.='<ul class="ml-menu">';
                                                foreach ($menu_item['submenu'] as $sub_menu_item) {
                                                    if ($sub_menu_item['href'] != "#") {
                                                        $html.='
                                                            <li>
                                                                <a href="'.$sub_menu_item['href'].'">
                                                                    <span>'.$sub_menu_item['text'].'</span>
                                                                </a>
                                                            </li>
                                                        ';
                                                    }//End if
                                                }//End foreach
                                            $html.='</ul>';
                                        }//End if sizeof
                                    $html.='</li>
                                ';
                            }
                        }//End foreach
            $html.= '<ul>';
            /**
                END MENU
            **/
            return $html;
        }//End function crear_menu_lateral
    }//End if crear_menu_lateral
?>

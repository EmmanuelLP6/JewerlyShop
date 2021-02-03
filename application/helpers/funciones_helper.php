<?php
    /**
     *  FUNCIONES GLOBALES PARA EL SISTEMA 
    */
    //Funcion para establecer el horario en México
    date_default_timezone_set("America/Mexico_City");
    
    // ================================================
    // Función para fecha actual 00/00/0000
    // ================================================
    if(!function_exists("fecha_actual")){
        function fecha_actual(){
            $CI =& get_instance();
            $CI->load->helper('date');
            return unix_to_human(now(),true,"mx");
        }//end function fecha_actual
    }//end exists function fecha_actual

    // ================================================
    // Función para obtener fecha actual
    // ================================================
    if(!function_exists("obtener_fecha_actual")){
        function obtener_fecha_actual(){
            $fecha = array();
            $fecha['dia'] = date("d");
            $fecha['mes'] = date("m");
            $fecha['anio'] = date("Y");
            return $fecha;
        }//end function obtener_fecha_actual
    }//end exists function obtener_fecha_actual

    // ================================================
    // Función para crear el mensaje
    // ================================================
    if (!function_exists("mensaje")) {
        function mensaje($texto='', $tipo = 5){
            $mensaje = array();
            $mensaje['texto'] = $texto ;
            $mensaje['tipo'] = $tipo ;
            // $mensaje['titulo'] = $titulo ;

            $CI =& get_instance();
            $CI->load->library('session');
            $CI->session->mensaje = $mensaje;
        }//End function mensaje
    }//End exists function mensaje

    // ================================================
    // Función para limpiar el mensaje
    // ================================================
    if (!function_exists("limpiar_mensaje")) {
        function limpiar_mensaje(){
            $CI =& get_instance();
            $CI->load->library('session');
            $CI->session->mensaje = NULL;
        }//End function limpiar_mensaje
    }//End exists function limpiar_mensaje

    // ================================================
    // Función para que se muestre el mensaje
    // ================================================
    if(!function_exists("mostrar_mensaje")){
        function mostrar_mensaje(){
            $CI =& get_instance();
            $CI->load->library('session');
            $mensaje = $CI->session->mensaje;
            $CI->session->mensaje = NULL;

            //Retorna null si no hay mensaje
            if($mensaje == NULL){
                return "";
            }//end if mensaje null

            $tipoMensaje  = '';
            $titulo  = '';
            switch($mensaje['tipo']){
                case 1:
                    //Satisfactoriamente
                    $tipoMensaje = "success";
                    $titulo = "¡Correcto!";
                break;
                case 2:
                    //Error
                    $tipoMensaje = "danger";
                    $titulo = "¡Error!";
                break;
                case 3:
                    //Atencion
                    $tipoMensaje = "warning";
                    $titulo = "¡Atención!";
                break;
                default:
                    $tipoMensaje = "info";
                    $titulo = "¡Bienvenido!";
                break;
            }//end switch

            $html = '
                $.notify(
                    "<strong>'.$titulo.'</strong> <br>'.$mensaje["texto"].'",
                    {
                        type: "'.$tipoMensaje.'",
                        allow_dismiss: true,
                        timer: 1000,
                        placement: {
                            from: "top",
                            align: "center"
                        },
                        animate: {
                            enter: "animated fadeInDown",
                            exit: "animated fadeOutUp"
                        }
                    }
                );
            ';
            return $html;
        }//End function limpiar_mensaje
    }//End exists function limpiar_mensaje

    // ================================================
    // Función para hacer un breadcrome AdminBSB
    // ================================================
    if (!function_exists("breadcrumb")) {
        function breadcrumb($navegacion){
            $html = '';
            $count = 1;
            $html.='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ol class="breadcrumb breadcrumb-col-teal">';
                        foreach ($navegacion as $tarea) {
                            if (sizeof($navegacion) == $count) {
                                $html.='<li class="active"><i class="material-icons">'.$tarea["icon"].'</i> '.$tarea["tarea"].'</li>';
                            }//End if
                            else{
                                $html.='<li><a href="'.($tarea['href'] != '' ? $tarea['href'] : '').'"><i class="material-icons">'.$tarea["icon"].'</i> '.$tarea["tarea"].'</a></li>';
                            }
                            $count++;
                        }//End foreach
                        $html.='</ol>
                    </div>';
            return $html;
        }//End breadcrumb
    }//End if breadcrumb

    /**
     *  NUEVAS FUNCIONES
    */

    // ================================================
    // Función para convertir un arreglo[] 
    // a un arreglo object 
    // ================================================
    if (!function_exists("covert_array_to_stdlclass")) {
        function covert_array_to_stdlclass($arreglo){
            $object = new stdClass();
            foreach ($arreglo as $key => $value) {
                if (is_array($value)) {
                    $value = covert_array_to_stdlclass($value);
                }//End if
                $object->$key = $value;
            }//End foreach
            return $object;
        }//End covert_array_to_stdlclass
    }//End if covert_array_to_stdlclass

    // ================================================
    // Función para convertir un arreglo object
    // a un arreglo[]
    // ================================================
    if (!function_exists("covert_stdlclass_to_array")) {
        function covert_stdlclass_to_array($arreglo){
            $array = (array)$arreglo;
            foreach($array as $key => &$field){
                if(is_object($field))$field = covert_stdlclass_to_array($field);
            }//End foreach 
            return $array;
        }//End covert_stdlclass_to_array
    }//End if covert_stdlclass_to_array
    
    // ================================================
    // Función
    // ================================================
    // if (!function_exists("funcion")) {
    //     function funcion(){

    //     }//End funcion
    // }//End if funcion
?>

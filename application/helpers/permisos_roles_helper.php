<?php
    // ------------------------------------------------------------------------
    if ( !function_exists('isRolPermitido')) {
        function is_rol_permitido($clave_tarea=-1, $clave_rol=-1){
            $permiso = FALSE;
            $CI =& get_instance();
            switch ($clave_tarea) {

                case $CI->constantes->TAREA_NONE:
                    $permiso = FALSE;
                	break;

                //***************  TAREA  DASHBOARD  ****************
                case $CI->constantes->TAREA_DASHBOARD: //TAREA PARA TODOS
                    $roles_permitidos = array(
                                            $CI->constantes->ROL_SUPERADMIN['clave'],
                                            $CI->constantes->ROL_ASISTENTE['clave'],
                                        );
                    $permiso = in_array($clave_rol, $roles_permitidos);
                    break;
                //**************************************************

                //***************  TAREA  USUARIOS  ****************
                case $CI->constantes->TAREA_USUARIO_TODOS: //TAREA PARA TODOS
                case $CI->constantes->TAREA_USUARIO_NUEVO: 
                case $CI->constantes->TAREA_USUARIO_DETALLES: 
                    $roles_permitidos = array(
                                            $CI->constantes->ROL_SUPERADMIN['clave'],
                                        );
                    $permiso = in_array($clave_rol, $roles_permitidos);
                    break;
                //**************************************************

                //**********  TAREA  USUARIO DETALLES  *************
                case $CI->constantes->TAREA_USUARIO_DETALLES:
                    $roles_permitidos = array(
                                            $CI->constantes->ROL_SUPERADMIN['clave'],
                                        );
                    $permiso = in_array($clave_rol, $roles_permitidos);
                    break;
                //**************************************************

                default:

                    break;
            }//end switch tareas
            return $permiso;
        }//end isRolPermitido
    }//end no existe funcion isRolPermitido
?>

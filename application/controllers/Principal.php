<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Principal extends CI_Controller {

        public function __construct(){
            parent::__construct();

            //Cargarenmos los helper de FORMULARIO
            $this->load->helper('form');
            $this->load->helper('date');
            $this->load->library('form_validation');
        }//end function __construct

        public function index($id_tarea=NULL, $id_elemento=NULL, $id_elemento_dos=NULL){
            /* OPERACIONES DE SESSION */
    		$sesion_iniciada = ($this->session->userdata($this->constantes->CLAVE_SESION.'sesion_iniciada_panel') != NULL) ? $this->session->userdata($this->constantes->CLAVE_SESION.'sesion_iniciada_panel') : FALSE;

            $this->session->set_userdata($this->constantes->CLAVE_SESION.'tarea_actual',($id_tarea==NULL ? $this->constantes->TAREA_NONE : $id_tarea));
    		$rol_actual = ($this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual') != NULL) ? $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual') : NULL;
            $is_locked = ($this->session->userdata($this->constantes->CLAVE_SESION.'is_locked') != FALSE) ? $this->session->userdata($this->constantes->CLAVE_SESION.'is_locked') : FALSE;
            if(($this->session->userdata($this->constantes->CLAVE_SESION.'tarea_actual') == 0) || ($this->session->userdata($this->constantes->CLAVE_SESION.'tarea_actual') >= 1000)){
                switch ($this->session->userdata($this->constantes->CLAVE_SESION.'tarea_actual')) {
                    case $this->constantes->PAGINA_NONE:
                        redirect('usuario/login');
                    break;

                    default:
                        redirect('usuario/login');
                        break;
                }//end switch
            }//end if tarea del portal
            else{
                if (!$sesion_iniciada && $this->session->userdata($this->constantes->CLAVE_SESION.'login_failure')) {
                    redirect('usuario/login');
                    // return;
                }//end if no session inciada
                else{
                    if ($is_locked) {
                        // redirect('usuario/lock');
                        return;
                    }//end if session bloqueada
                    else{
                        // $this->session->id_elementoEditar = $id_elemento;
                        /* ENRUTAR POR TAREA */
                        // debug($this->session->userdata($this->constantes->CLAVE_SESION.'tarea_actual'),false);
                        // debug($this->constantes->TAREA_USUARIO_TODOS)
                        switch($this->session->userdata($this->constantes->CLAVE_SESION.'tarea_actual')){
                            /**
                            * Estos casos pertenecen a panel de superadmin, vinculación, asistente y asesores intenos
                            */
                            case $this->constantes->TAREA_NONE:
                                redirect('usuario/login');
                                break;

                            case $this->constantes->TAREA_LOGOUT:
                                redirect('usuario/logout');
                                break;

                            case $this->constantes->TAREA_DASHBOARD:
                                redirect('panel/dashboard');
                                break;

                            case $this->constantes->TAREA_USUARIO_TODOS:
                                redirect('panel/usuarios');
                                break;

                            case $this->constantes->TAREA_USUARIO_NUEVO:
                                redirect('panel/usuario_nuevo');
                                break;

                            case $this->constantes->TAREA_USUARIO_DETALLES:
                                redirect('panel/usuario_detalles/'.$id_elemento);
                                break;
                            
                            case $this->constantes->TAREA_PERFIL:
                                // $this->session->set_userdata($this->constantes->CLAVE_SESION.'id_usuario_detalles', $id_elemento);
                                redirect('panel/usuario_perfil');
                                break;

                            default:
                                redirect('usuario/login');
                            break;
                        }//end switch enrutamiento por tarea
                    }//end else sesión iniciada y no bloqueado
                }//end else se tiene sesión iniciada
            }//end else tareas de administrador
        }//end function index

    }//end class Principal
?>

<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Login extends CI_Controller {

    	public function __construct(){
    		parent::__construct();
    		$this->load->helper("form");
    		$this->load->library('form_validation');
    	}//end __construct

        public function reglas_formulario(){
            return array(
                // array(
                //     '' => ''
                // ),
            );//End return
        }//End function reglas_formulario

    	public function validar()	{
            $this->load->model('Tabla_usuario');
			$respuesta = $this->Tabla_usuario->login($this->input->post('email'), $this->input->post('password'));
			// debug($respuesta);
	 		if($respuesta != NULL){
                if ($respuesta->estatus != $this->constantes->ESTATUS_DESACTIVADO['clave']) {
					$this->load->model('Tabla_rol_usuario');
					$roles = $this->Tabla_rol_usuario->rol_usuario($respuesta->id_usuario);
					// $this->session->correo_usuario = $respuesta->correo_usuario;
					// $this->session->fecha_nacimiento = $respuesta->fecha_nacimiento;
					$clave_sesion = $this->constantes->CLAVE_SESION;
					$array = array(
								$clave_sesion.'sesion_iniciada_panel' => TRUE,
								$clave_sesion.'is_locked' => FALSE,
								$clave_sesion.'id_usuario' => $respuesta->id_usuario,
								$clave_sesion.'nombre_usuario' => $respuesta->nombre_usuario,
								$clave_sesion.'nombre_completo_usuario' => $respuesta->nombre_usuario.' '.$respuesta->ap_usuario.' '.$respuesta->am_usuario,
								$clave_sesion.'roles' => $roles,
								$clave_sesion.'rol_actual' => $roles[0],
								// $clave_sesion.'usuario' => $respuesta->usuario,
								$clave_sesion.'tarea_actual' => $this->constantes->TAREA_DASHBOARD,
								$clave_sesion.'login_failure' => FALSE,
								$clave_sesion.'imagen_usuario' => $respuesta->imagen_usuario,
							);
					$this->session->set_userdata($array);
					mensaje($respuesta->nombre_usuario);
					redirect('principal/'.$this->constantes->TAREA_DASHBOARD);
				}//End if
				else{
					$this->session->set_userdata($this->constantes->CLAVE_SESION.'login_failure', TRUE);
                	mensaje('Este usuario no ha sido activado',3);
					redirect('usuario/login');
				}
			}//end if si existe
			else{
                $this->session->set_userdata($this->constantes->CLAVE_SESION.'login_failure', TRUE);
                mensaje('Credenciales de acceso son incorrectas',2);
				redirect('usuario/login');
			}//end else
    	}//End function validar

        public function index()	{
            $sesion_iniciada_panel = ($this->session->userdata($this->constantes->CLAVE_SESION.'sesion_iniciada_panel') != FALSE) ? $this->session->userdata($this->constantes->CLAVE_SESION.'sesion_iniciada_panel') : FALSE;
            if ($sesion_iniciada_panel) {
                redirect('principal/'.$this->constantes->TAREA_DASHBOARD);
            }//End if
            else{
                $this->load->view('usuario/login');
            }//End else
    	}//End function index

    }//End class Login

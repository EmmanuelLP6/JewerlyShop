<?php
class Cambio_de_rol extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
    }//end constructor

	private function cargar_datos(){
		$datos  = array();

		return $datos;
	}//end loadData

    public function index($id){
        $sesion_iniciada_panel = ($this->session->userdata($this->constantes->CLAVE_SESION.'sesion_iniciada_panel') != FALSE) ? $this->session->userdata($this->constantes->CLAVE_SESION.'sesion_iniciada_panel') : FALSE;
		$rol_actual = ($this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual') != array()) ? $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual') : '';
        $is_locked = ($this->session->userdata($this->constantes->CLAVE_SESION.'is_locked') != FALSE) ? $this->session->userdata($this->constantes->CLAVE_SESION.'is_locked') : FALSE;
        $clave_rol_cambio = $id;

        //2. VERIFICAR SI LA SESIÓN ESTÁ INICIADA (no modificar)
        if ($sesion_iniciada_panel && (!$is_locked) && (!$clave_rol_cambio)) {
            redirect('principal');
            return;
        }

		$data = $this->cargar_datos();

        switch ($clave_rol_cambio) {

            //ROL_SUPERADMIN
            case $this->constantes->ROL_SUPERADMIN['clave']:
                //cambiar rol en variable de sesión
                $this->session->set_userdata($this->constantes->CLAVE_SESION.'rol_actual', $this->constantes->ROL_SUPERADMIN);
                redirect('principal/'.$this->constantes->TAREA_DASHBOARD);
                break;

            //ROL_VINCULACION
            case $this->constantes->ROL_ASISTENTE['clave']:
                //cambiar rol en variable de sesión
                $this->session->set_userdata($this->constantes->CLAVE_SESION.'rol_actual', $this->constantes->ROL_ASISTENTE);
                redirect('principal/'.$this->constantes->TAREA_DASHBOARD);
                break;

            default:
                //iniciar sesion
				$this->session->set_userdata($this->constantes->CLAVE_SESION.'sesion_iniciada', FALSE);
				$this->session->set_userdata($this->constantes->CLAVE_SESION.'rol_actual', $this->constantes->ROL_NONE);
				redirect('principal/'.$this->constantes->TAREA_DASHBOARD);
                break;
        }//end switch

    }//end index

}//end class Cambio_de_rol
?>

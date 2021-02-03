<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(__DIR__.'/../base/Tarea.php');

    // class Dashboard extends CI_Controller {
    class Dashboard extends CI_Controller implements Tarea {
        private $titulo_vista = 'Dashboard';
        public function __construct(){
            parent::__construct();
            if(!is_rol_permitido($this->constantes->TAREA_DASHBOARD, $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual')['clave'])){
                redirect('principal');
                return;
            }//end if
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model([
                ''
            ]);
        }//end constructor

        public function reglas_formulario(){

        }//end reglas_formulario

        public function cargar_datos(){
            $datos = array();

            //Titulo de tarea
            $datos['titulo_tarea'] = $this->titulo_vista;

            //navegación
			$datos['navegacion'] = array(
                'descripcion' => ''
            );

			return $datos;
        }//end cargar_datos

        public function crear_vista($nombre_vista=NULL, $datos=NULL){
            $data['titulo_vista'] = $this->titulo_vista;
            $data['contenido'] = $this->load->view($nombre_vista, $datos,TRUE);
            $data['menu_lateral'] = crear_menu_lateral($this->constantes->TAREA_DASHBOARD, $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual'));
			$data['navegacion'] = $datos['navegacion'];
            $this->load->view('base/plantilla_panel', $data);
        }//end crear_vista

        public function index(){
            $this->crear_vista('panel/dashboard', $this->cargar_datos());
        }//end index

    }//end class Dashboard

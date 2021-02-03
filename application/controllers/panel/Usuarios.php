<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(__DIR__.'/../base/Tarea.php');

    class Usuarios extends CI_Controller implements Tarea {
        private $titulo_vista = 'Usuarios';
        public function __construct(){
            parent::__construct();
            if(!is_rol_permitido($this->constantes->TAREA_USUARIO_TODOS, $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual')['clave'])){
                redirect('principal');
                return;
            }//end if
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model([
                'Tabla_usuario',
                'Tabla_rol_usuario',
            ]);
        }//end constructor

        public function reglas_formulario(){

        }//end reglas_formulario
        
        /**
            GLOBAL SETTING
        **/
        public function cargar_datos(){
            $datos = array();
            //Query
            $datos['usuarios'] = $this->Tabla_rol_usuario->usuarios_todos();
            // $datos[''] = '';
            //Titulo de tarea
            $datos['titulo_tarea'] = $this->titulo_vista;
            //navegación
			//navegación
            $navegacion = array(
                array(
                    'tarea' =>  'Inicio',
                    'icon' => 'home',
                    'href'  =>  base_url('principal/'.$this->constantes->TAREA_DASHBOARD),
                ),
                array(
                    'tarea' =>  'Usuarios',
                    'icon' => 'contacts',
                    'href'  =>  '',
                ),
            );
            $datos['navegacion'] = breadcrumb($navegacion);
            // debug($datos['usuarios']);
			return $datos;
        }//end cargar_datos

        public function crear_vista($nombre_vista=NULL, $datos=NULL){
            $data['titulo_vista'] = $this->titulo_vista;
            $data['contenido'] = $this->load->view($nombre_vista, $datos,TRUE);
            $data['menu_lateral'] = crear_menu_lateral($this->constantes->TAREA_USUARIO_TODOS, $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual'));
			$data['navegacion'] = $datos['navegacion'];
            $this->load->view('base/plantilla_panel', $data);
        }//end crear_vista

        public function index(){
            $this->crear_vista('panel/usuarios', $this->cargar_datos());
        }//end index

        /**
         * Funciones estadares
         */
        public function data_table(){
            $usuarios = $this->Tabla_rol_usuario->usuarios_todos();
            $data = array();
            $count = 0;
            foreach ($usuarios as $usuario) {
                $sub_array = array();
                $sub_array['total'] = ++$count;
                $sub_array['usuario'] = $usuario->nombre_usuario;
                $sub_array['rol'] = $usuario->rol;
                if($usuario->estatus == $this->constantes->ESTATUS_ACTIVADO['clave']){
                    $sub_array['estatus'] = '<a type="button" class="btn bg-pink text-white estatus" href="#" id="'.$usuario->id_usuario.'_'.$usuario->estatus.'"><i class="material-icons">lock_outline</i> Desactivar</a>';
                }//End if
                else{
                    $sub_array['estatus'] = '<a type="button" class="btn bg-teal text-white estatus" href="#" id="'.$usuario->id_usuario.'_'.$usuario->estatus.'"><i class="material-icons">lock_open</i> Activar</a>';
                }//End else
                $sub_array['eliminar'] = '<a type="button" class="btn btn-danger text-white eliminar" href="#" id="'.$usuario->id_usuario.'"><i class="material-icons">delete</i> Eliminar</a>';
                $sub_array['detalles'] = '<a type="button" class="btn btn-warning text-white" href="'.base_url('principal/'.$this->constantes->TAREA_USUARIO_DETALLES.'/'.$usuario->id_usuario).'"><i class="material-icons">info</i> Detalles</a>';
                $data[] = $sub_array;
            }//End foreach
            echo '{"data": '.json_encode($data).'}';
        }//End data_table

        public function eliminar() {
            $img = $this->Tabla_usuario->seleccionar_imagen($this->input->post('id'));
            if($this->Tabla_usuario->delete($this->input->post('id'))) {
                if($img != NULL && file_exists('./uploads/users/'.$img)) {
                    unlink('./uploads/users/'.$img);
                }//end of if
                echo '1';
            }//end of if
            else {
                echo '2';
            }//end of else
        }//end eliminar

        public function estatus() {
            if($this->Tabla_usuario->update(array('fecha_actualizacion'=>fecha_actual(), 'estatus' => $this->input->post('estatus')), $this->input->post('id'))) {
                echo '1';
            }//end of if
            else {
                echo '2';
            }//end of else
        }//end estatus

        /**
         * Funciones nuevas
         */

    }//end class Usuarios

<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(__DIR__.'/../base/Tarea.php');

    class Usuario_perfil extends CI_Controller implements Tarea {
        private $titulo_vista = 'Perfil usuario';
        public function __construct(){
            parent::__construct();
            if(!is_rol_permitido($this->constantes->TAREA_USUARIO_NUEVO, $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual')['clave'])){
                redirect('principal');
                return;
            }//end if
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model([
                'Tabla_usuario',
                'Tabla_rol_usuario',
                'Tabla_rol',
                // '',
            ]);
        }//end constructor

        /**
            GLOBAL SETTING
        **/

        public function reglas_formulario(){
            return array(
                array(
                    'field' => 'nombre_usuario',
                    'label' => 'Nombre del usuario',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => '%s requerido'
                    )
                ),
                array(
                    'field' => 'ap_usuario',
                    'label' => 'Apellido paterno',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => '%s requerido'
                    )
                ),
                array(
                    'field' => 'am_usuario',
                    'label' => 'Apellido materno',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => '%s requerido'
                    )
                ),
                array(
                    'field' => 'genero_usuario',
                    'label' => 'Genero',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => '%s requerido'
                    )
                ),
                array(
                    'field' => 'usuario',
                    'label' => 'Correo electrónico',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => '%s requerido',
                    )
                )
            );//End return array
        }//end reglas_formulario

        public function reglas_formulario_password() {
            return array(
                array(
                    'field' => 'password',
                    'label' => 'Contraseña',
                    'rules' => 'required|min_length[5]|max_length[64]',
                    'errors' => array(
                        'required' => '%s requerido',
                        'min_length' => 'Longitud mínima de 5 caracteres',
					    'max_length' => 'Logitud máxima de 64 caracteres',
                    )
                ),
                array(
                    'field' => 'password2',
                    'label' => 'Contraseña',
                    'rules' => 'required|matches[password]|min_length[5]|max_length[64]',
                    'errors' => array(
                        'required' => '%s requerida',
                        'matches' => 'Las contraseñas no coinciden',
                        'min_length' => 'Longitud mínima de 5 caracteres',
					    'max_length' => 'Logitud máxima de 64 caracteres',
                    )
                )
            );//End return array
        }//End reglas_formulario_password

        public function cargar_datos(){
            $id_usuario = $this->session->userdata($this->constantes->CLAVE_SESION.'id_usuario');
            $datos = array();
            //Query
            $datos['perfil'] = $this->Tabla_usuario->select_where(['id_usuario' => $id_usuario])[0];
            $roles = $this->Tabla_rol_usuario->rol_usuario($id_usuario);
            $datos['rol_actual'] = $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual',$roles[0]);
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
                    'tarea' =>  'Perfil',
                    'icon' => 'account_circle',
                    'href'  =>  ''
                ),
            );
            $datos['navegacion'] = breadcrumb($navegacion);
            // debug($id_usuario);
            // debug($this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual'));
            // debug($datos['rol_actual']);
			return $datos;
        }//end cargar_datos

        public function crear_vista($nombre_vista=NULL, $datos=NULL){
            $data['titulo_vista'] = $this->titulo_vista;
            $data['contenido'] = $this->load->view($nombre_vista, $datos,TRUE);
            $data['menu_lateral'] = crear_menu_lateral($this->constantes->TAREA_NONE, $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual'));
			$data['navegacion'] = $datos['navegacion'];
            $this->load->view('base/plantilla_panel', $data);
        }//end crear_vista

        public function index(){
            $this->crear_vista('panel/usuario_perfil', $this->cargar_datos());
        }//end index

        /**
            NEWS FUNCTIONS
        **/
        public function editar_perfil() {
            $usuario = array();
            //Manda a tarer las reglas formulario
            $this->form_validation->set_rules($this->reglas_formulario());
            if ($this->form_validation->run() == FALSE){
                echo json_encode([
                    'validation' => TRUE,
                    'nombre_error' => form_error('nombre_usuario'),
                    'ap_error' => form_error('ap_usuario'),
                    'am_error' => form_error('am_usuario'),
                    'genero_error' => form_error('genero_usuario'),
                    'usuario_error' => form_error('usuario')
                ]);
            }//End if
            else {
                 /**
                    La variable $estatus_imagen con valor boleano falso siver como bandera
                    para poder saber si al subir la imagen hay algún error. En caso de que lo haya,
                    la bandera cambia a true y por lo tanto no se hara el registro a la BD y
                    retornará un error.
                */
                $estatus_imagen = FALSE;
                $id_usuario = $this->input->post('id_usuario');
                //Datos del Usuario
                $usuario['fecha_actualizacion'] = fecha_actual();
                $usuario['nombre_usuario'] = $this->input->post('nombre_usuario');
                $usuario['ap_usuario'] = $this->input->post('ap_usuario');
                $usuario['am_usuario'] = $this->input->post('am_usuario');
                $usuario['genero_usuario'] = $this->input->post('genero_usuario');
                if ($_FILES['imagen']['name'] != NULL) {
                    //esta configuración es pra ver si la imágen cuenta con las caracteriticas necesarias
                    $config['upload_path'] = './uploads/users';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = '1024';
                    $config['max_width'] = '700';
                    $config['max_height'] = '700';

                    //esta parte simplemente recibe la configuración echa anteriormente
                    $this->load->library('upload', $config);

                    // si hay un error al subir la imgen se mostrará un error en la vista
                    if (!$this->upload->do_upload('imagen')) {
                        $error = array('error' => $this->upload->display_errors());
                        $estatus_imagen = TRUE;
                    }//end if
                    else {
                        //Si no ocurrió algún error al subir la imagen se guarda en la carpeta que se configuro y el nombre en el arreglo creado
                        $file_info = $this->upload->data();
                        $usuario['imagen_usuario'] = $file_info['file_name'];
                        if($this->input->post('imagen-usuario-anterior') != NULL && file_exists('./uploads/users/'.$this->input->post('imagen-usuario-anterior'))) {
                            unlink('./uploads/users/'.$this->input->post('imagen-usuario-anterior'));
                        }//end of if
                    }//end else
                }//end else

                if($this->Tabla_usuario->update($usuario, $id_usuario)) {
                    $this->session->set_userdata($this->constantes->CLAVE_SESION.'nombre_usuario', $this->input->post('nombre_usuario'));
                    $this->session->set_userdata($this->constantes->CLAVE_SESION.'nombre_completo_usuario', $this->input->post('nombre_usuario').' '.$this->input->post('ap_usuario').' '.$this->input->post('am_usuario'));
                    if(isset($usuario['imagen_usuario'])) {
                        $this->session->set_userdata($this->constantes->CLAVE_SESION.'imagen_usuario', $usuario['imagen_usuario']);
                    }//end if
                    echo json_encode(['update'=>TRUE]);
                }//End if
                else{
                    echo json_encode(['error'=>TRUE]);
                }//End else
            }
        }//End function editar_perfil

        public function editar_password(){
            $usuario = array();
            //Manda a tarer las reglas formulario
            $this->form_validation->set_rules($this->reglas_formulario_password());
            if ($this->form_validation->run() == FALSE){
                echo json_encode([
                    'validation' => TRUE,
                    'password_error' => form_error('password'),
                    'password2_error' => form_error('password2')
                ]);
            }//End if
            else {
                $id_usuario = $this->input->post('id_usuario');
                if (($this->input->post('password') == $this->input->post('password2')) && ($this->input->post('password') != NULL && $this->input->post('password2') != NULL)) {
                    //Se encripta la contraseña
                    $usuario['password'] = $this->Tabla_usuario->encrypt_password($this->input->post('password'));
                }//end if
                if($this->Tabla_usuario->update($usuario, $id_usuario)) {
                    echo json_encode(['update'=>TRUE]);
                }//End if
                else{
                    echo json_encode(['error'=>TRUE]);
                }//End else
            }
        }//End editar_password

        /**
         * Callbacks
         */
        

    }//end class Usuario_perfil

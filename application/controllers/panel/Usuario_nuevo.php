<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(__DIR__.'/../base/Tarea.php');

    class Usuario_nuevo extends CI_Controller implements Tarea {
        private $titulo_vista = 'Usuarios';
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
                    'rules' => 'required|callback_verificar_nombre',
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
                    'field' => 'rol[]',
                    'label' => 'Se requiere al menos seleccionar un rol',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => '%s'
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
                    'rules' => 'required|callback_verificar_usuario',
                    'errors' => array(
                        'required' => '%s requerido',
                    )
                ),
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
                // array(
                //     'field' => '',
                //     'label' => '',
                //     'rules' => 'required',
                //     'errors' => array(
                //         'required' => '%s requerido'
                //     )
                // ),
            );//End return array
        }//end reglas_formulario

        public function cargar_datos(){
            $datos = array();
            //Query
            $datos['roles'] = $this->Tabla_rol->obtener_lista_roles();
            $datos[''] = '';
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
                    'href'  =>  base_url('principal/'.$this->constantes->TAREA_USUARIO_TODOS),
                ),
                array(
                    'tarea' =>  'Nuevo usuario',
                    'icon' => 'group_add',
                    'href'  =>  '',
                ),
            );
            $datos['navegacion'] = breadcrumb($navegacion);
            // debug($datos['roles']);
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
            $this->crear_vista('panel/usuario_nuevo', $this->cargar_datos());
        }//end index

        /**
            NEWS FUNCTIONS
        **/
        public function agregar(){
            $this->form_validation->set_rules($this->reglas_formulario());
            if ($this->form_validation->run() == FALSE){
                echo json_encode([
                    'validation' => TRUE,
                    'nombre_error' => form_error('nombre_usuario'),
                    'ap_error' => form_error('ap_usuario'),
                    'am_error' => form_error('am_usuario'),
                    'rol_error' => form_error('rol[]'),
                    'genero_error' => form_error('genero_usuario'),
                    'usuario_error' => form_error('usuario'),
                    'password_error' => form_error('password'),
                    'password2_error' => form_error('password2')
                ]);
            }//End if
            else {
                /**
                   La variable $estatus_imagen con valor boleano falso siver como bandera
                   para poder saber si al subir la imagen hay algún error. En caso de que lo haya,
                   la bandera cambia a true y por lo tanto no se hara el registro a la BD y
                   retornará un error.
               **/
                $estatus_imagen = FALSE;
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
                        echo '3';
                    }//end if
                    else {
                        //Si no ocurrió algún error al subir la imagen se guarda en la carpeta que se configuro y el nombre en el arreglo creado
                        $file_info = $this->upload->data();
                        $usuario['imagen_usuario'] = $file_info['file_name'];
                    }//end else
                }//end else

                //Captura de información el usuario
                $usuario['nombre_usuario'] = $this->input->post('nombre_usuario');
                $usuario['ap_usuario'] = $this->input->post('ap_usuario');
                $usuario['am_usuario'] = $this->input->post('am_usuario');
                $usuario['genero_usuario'] = $this->input->post('genero_usuario');
                $usuario['email_usuario'] = $this->input->post('usuario');
                //Se encripta la contraseña
                $usuario['password'] = $this->Tabla_usuario->encrypt_password($this->input->post('password'));
               if (!$estatus_imagen) {
                    if($this->Tabla_usuario->insert($usuario)) {
                        $id_usuario = $this->db->insert_id();
                        $roles = $this->input->post('rol[]');
                        for ($i=0; $i < sizeof($roles); $i++) {
                            $temp = array(
                                'id_rol' => $roles[$i],
                                'id_usuario' => $id_usuario
                            );
                            $this->Tabla_rol_usuario->insert($temp);
                        }//end for
                        echo json_encode(['insert' => TRUE, 'url' => base_url('principal/'.$this->constantes->TAREA_USUARIO_TODOS)]);
                        mensaje('El usuario fue registrado', 1);
                    }//end if
                    else {
                        echo json_encode(['error' => TRUE]);
                    }//end else
                }//end if
            }//End else
        }//End function agregar

        /**
         * Callbacks
         */
        public function verificar_usuario($usuario=NULL) {
            $resultado = $this->Tabla_usuario->select_where(['email_usuario'=> $usuario]);
            if(sizeof($resultado) > 0) {
                $this->form_validation->set_message('verificar_usuario', "El usuario <b> $usuario </b> ya ha sido registrado");
                return FALSE;
            }//end if
            else {
                return TRUE;
            }//end else
        }//end verificar_usuario

        public function verificar_nombre($nombre_usuario=NULL) {
            $ap_usuario = $this->input->post('ap_usuario');
            $am_usuario = $this->input->post('am_usuario');
            $resultado = $this->Tabla_usuario->select_where(['upper(nombre_usuario)=' => mb_strtoupper($nombre_usuario, 'UTF-8'),'upper(ap_usuario)=' => mb_strtoupper($ap_usuario, 'UTF-8'),'upper(am_usuario)=' => mb_strtoupper($am_usuario, 'UTF-8')]);
            if(sizeof($resultado) > 0) {
                $this->form_validation->set_message('verificar_nombre', "El nombre <b> $nombre_usuario $ap_usuario $am_usuario </b> ya ha sido registrado");
                return FALSE;
            }//end if
            else {
                return TRUE;
            }//end else
        }//end verificar_nombre

    }//end class Usuario_nuevo

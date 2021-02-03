<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(__DIR__.'/../base/Tarea.php');

    class Usuario_detalles extends CI_Controller implements Tarea {
        private $titulo_vista = 'Usuario detalles';
        public function __construct(){
            parent::__construct();
            if(!is_rol_permitido($this->constantes->TAREA_USUARIO_DETALLES, $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual')['clave'])){
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
                    'rules' => 'required',
                    'errors' => array(
                        'required' => '%s requerido',
                    )
                ),
                array(
                    'field' => 'password',
                    'label' => 'Contraseña',
                    'rules' => 'min_length[5]|max_length[64]',
                    'errors' => array(
                        // 'required' => '%s requerido',
                        'min_length' => 'Longitud mínima de 5 caracteres',
					    'max_length' => 'Logitud máxima de 64 caracteres',
                    )
                ),
                array(
                    'field' => 'password2',
                    'label' => 'Contraseña',
                    'rules' => 'matches[password]|min_length[5]|max_length[64]',
                    'errors' => array(
                        // 'required' => '%s requerida',
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

        public function cargar_datos($id_usuario = NULL){
            $datos = array();
            //Query
            $datos['roles'] = $this->Tabla_rol->obtener_lista_roles();
            $datos['usuario'] = $this->Tabla_usuario->select_where(array('id_usuario' => $id_usuario))[0];
            $datos['rol_usuario'] = $this->Tabla_rol_usuario->seleccionar_roles_usuario($id_usuario);
            //Titulo de tarea
            $datos['titulo_tarea'] = $this->titulo_vista;
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
                                    'tarea' =>  'Detalles usuario',
                                    'icon' => 'mode_edit',
                                    'href'  =>  '',
                                ),
                            );
            $datos['navegacion'] = breadcrumb($navegacion);
            // debug($datos['usuario']);
			return $datos;
        }//end cargar_datos

        public function crear_vista($nombre_vista=NULL, $datos=NULL){
            $data['titulo_vista'] = $this->titulo_vista;
            $data['contenido'] = $this->load->view($nombre_vista, $datos,TRUE);
            $data['menu_lateral'] = crear_menu_lateral($this->constantes->TAREA_USUARIO_TODOS, $this->session->userdata($this->constantes->CLAVE_SESION.'rol_actual'));
			$data['navegacion'] = $datos['navegacion'];
            $this->load->view('base/plantilla_panel', $data);
        }//end crear_vista

        public function index($id_usuario = NULL){
            if (sizeof($this->Tabla_usuario->select_where(['id_usuario'=> $id_usuario])) == 0) {
                mensaje('No se encuentra el registro', 3);
                redirect('principal/'.$this->constantes->TAREA_USUARIO_TODOS);
            }//End if
            else{
                $this->crear_vista('panel/usuario_detalles', $this->cargar_datos($id_usuario));
            }//End else
        }//end index

        /**
            NEWS FUNCTIONS
        **/
        
        public function editar() {
            $usuario = array();
            //Manda a tarer las reglas formulario
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

                //En caso de que la password sea necesaria
                if (($this->input->post('password') == $this->input->post('password2')) && ($this->input->post('password') != NULL && $this->input->post('password2') != NULL)) {
                    //Se encripta la contraseña
                    $usuario['password'] = $this->Tabla_usuario->encrypt_password($this->input->post('password'));
                }//end if
                
                if($this->Tabla_usuario->update($usuario, $id_usuario)) {
                    //Elimina todos los roles actuales para insertar los nuevos
                    $roles = $this->input->post('rol[]');
                    $this->Tabla_rol_usuario->eliminar_roles_accesos($id_usuario);
                    for ($i=0; $i < sizeof($roles); $i++) {
                        $temp = array(
                            'id_rol' => $roles[$i],
                            'id_usuario' => $id_usuario
                        );
                        $this->Tabla_rol_usuario->insert($temp);
                    }//end for

                    echo json_encode(['insert'=>TRUE]);
                }//End if
                else{
                    echo json_encode(['error'=>TRUE]);
                }//End else
            }//End else            
        }//End function editar

    }//end class Usuario_detalles

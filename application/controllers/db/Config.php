<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

	private $campos = array();

        public function __construct() {
                parent::__construct();
                // Your own constructor code
                $this->load->helper('date');
                $this->load->dbforge();
                $this->load->dbutil();
				$this->load->helper('db_helper');
				$this->limpiar_campos();
				set_time_limit(5000);
        }//end constructor

		public function clear(){
			$this->load->model('Operaciones_bd');
			$this->Operaciones_bd->importar();
		}

		/********** BORRA TABLAS DE LA BASE DE DATOS **********/
		public function borrar_tablas(){
			echo $this->dbforge->drop_table('usuario_rol')?'Tabla usuario_rol borrada':'Tabla usuario_rol NO fue borrada';echo '<br>';
			echo $this->dbforge->drop_table('usuarios')?'Tabla usuaros borrada':'Tabla usuarios NO fue borrada';echo '<br>';
			echo $this->dbforge->drop_table('rol')?'Tabla rol borrada':'Tabla rol NO fue borrada';echo '<br>';
		}//end clear

		public function crear_tablas(){
			echo $this->crear_tabla_usuarios()?'Tabla usuarios creada':'Tabla usuarios NO creada';echo '<br>';
			echo $this->crear_tabla_roles()?'Tabla rol creada':'Tabla rol NO creada';echo '<br>';
			echo $this->crear_tabla_usuario_rol()?'Tabla usuario_rol creada':'Tabla usuario_rol NO creada';echo '<br>';
		}//end crear_tablas

		public function inicializar_tablas(){
			$this->inicializar_tabla_usuarios();
			$this->inicializar_tabla_rol();
			$this->inicializar_tabla_usuario_rol();
		}//end inicializar_tablas

		public function asignar_password_a_usuario($password, $id) {
			$this->db->query("UPDATE usuarios SET password = SHA2('".$password."', 0) WHERE id_usuario = ".$id);
	    }//end of function login

		public function inicializar_tabla_usuarios(){
			$this->load->helper("date");
			$data = array(
						array("fecha_creacion"=>unix_to_human(now('America/Mexico_City'),true,"mx"), "fecha_actualizacion"=>unix_to_human(now('America/Mexico_City'),true,"mx"),
						"estatus"=>"-1", "id_usuario"=>NULL, "nombre_usuario"=>"Usuario-admin", "ap_usuario"=>"AP-usuario-admin", "am_usuario"=>"AM-usuario-admin",
						"email_usuario"=>"admin@proyecto.com", "password"=>'abc123',"imagen_perfil_usuario"=>'usuarios/03.jpg'),
					);
			$this->db->insert_batch('usuarios', $data);
			//Se asigna password cifrado al Administrador
			$this->asignar_password_a_usuario('abc123', 1);

			echo 'tabla usuarios ...registros creados: '.sizeof($data).'<br>';
			echo json_encode($data);

			echo '<hr>';
		}

		public function inicializar_tabla_rol(){
			$this->load->helper("date");
			$data = array(
						array("fecha_creacion"=>unix_to_human(now('America/Mexico_City'),true,"mx"), "fecha_actualizacion"=>unix_to_human(now('America/Mexico_City'),true,"mx"),
						"estatus"=>"-1", "id_rol"=>NULL, "rol"=>"Administrador"),
						array("fecha_creacion"=>unix_to_human(now('America/Mexico_City'),true,"mx"), "fecha_actualizacion"=>unix_to_human(now('America/Mexico_City'),true,"mx"),
						"estatus"=>"-1", "id_rol"=>NULL, "rol"=>"Usuario"),
					);
			$this->db->insert_batch('rol', $data);

			echo 'tabla rol ...registros creados: '.sizeof($data).'<br>';
			echo json_encode($data);

			echo '<hr>';
		}//end inicializar_tabla_rol

		public function inicializar_tabla_usuario_rol(){
			$data = array(
						array("id_usuario"=>1, "id_rol"=>2),
						array("id_usuario"=>1, "id_rol"=>1),
					);
			$this->db->insert_batch('usuario_rol', $data);
			echo 'tabla usuario_rol ...registros creados: '.sizeof($data).'<br>';
			echo json_encode($data);

			echo '<hr>';
		}//end inicializar_tabla_usuario_rol

		public function crear_tabla_usuarios(){
		   $this->limpiar_campos();
		   $this->campo_timestamp('fecha_creacion');
		   $this->campo_timestamp('fecha_actualizacion');
		   $this->campo_int('estatus');
		   $this->campo_llave('id_usuario');
		   $this->campo_varchar('nombre_usuario');
		   $this->campo_varchar('ap_usuario');
		   $this->campo_varchar('am_usuario');
		   $this->campo_varchar('email_usuario', '100', '', FALSE, TRUE);
		   $this->campo_varchar('password','64');
		   $this->campo_varchar('imagen_perfil_usuario','300');
		   $this->dbforge->add_field($this->campos);
		   $this->dbforge->add_key('id_usuario', TRUE);
		   // $this->dbforge->add_field('id');
		   return $this->dbforge->create_table('usuarios');
	   }//end crear_tabla_usuarios

	   public function crear_tabla_roles(){
		   $this->limpiar_campos();
		   $this->campo_timestamp('fecha_creacion');
		   $this->campo_timestamp('fecha_actualizacion');
		   $this->campo_int('estatus');
		   $this->campo_llave('id_rol');
		   $this->campo_varchar('rol');
		   $this->dbforge->add_field($this->campos);
		   $this->dbforge->add_key('id_rol',TRUE);
		   return $this->dbforge->create_table('rol');
	   }//end crear_tablas_roles

	   public function crear_tabla_usuario_rol(){
		   $this->limpiar_campos();
		   $this->campo_int('id_usuario',10,'-1',FALSE);
		   $this->campo_int('id_rol',10,'-1',FALSE);
		   $this->dbforge->add_field($this->campos);
		   $this->dbforge->add_key('id_usuario');
		   $this->dbforge->add_key('id_rol');
		   $result = $this->dbforge->create_table('usuario_rol');
		   $result = $this->db->query(add_foreign_key('usuario_rol', 'id_usuario', 'usuarios (id_usuario)', 'CASCADE', 'CASCADE'));
		   $result = $this->db->query(add_foreign_key('usuario_rol', 'id_rol', 'rol (id_rol)', 'CASCADE', 'CASCADE'));
		   return $result;
	   }//end crear_tabla_usuario_rol

        private function limpiar_campos(){
            $this->campos = array();
        }//end limpiar_campos

        private function campo_varchar($name, $longitud='100', $default='', $null=TRUE, $unique=FALSE){
            $this->campos[$name] = array(
                    'type' => 'VARCHAR',
                    'constraint' => $longitud,
                    'unique' => $unique,
                    'default' => $default,
                    'null' => $null,
            );
        }

        private function campo_text($name, $default='', $null=TRUE){
            $this->campos[$name] = array(
                    'type' => 'TEXT',
                    // 'unique' => TRUE,
                    'default' => $default,
                    'null' => $null,
            );
        }
        private function campo_int($name, $tamanio=10, $default=-1, $null=TRUE){
            $this->campos[$name] = array(
                    'type' => 'INT',
                    // 'unique' => TRUE,
					'constraint' => $tamanio,
                    'default' => $default,
                    'null' => $null,
            );
        }
        private function campo_llave($name, $tamanio=10){
            $this->campos[$name] = array(
                    'type' => 'INT',
					'constraint' => $tamanio,
					'auto_increment' => TRUE
            );
        }
        private function campo_float($name, $default=-1, $null=TRUE){
            $this->campos[$name] = array(
                    'type' => 'FLOAT',
                    // 'unique' => TRUE,
                    'default' => $default,
                    'null' => $null,
            );
        }
        private function campo_double($name, $default=-1, $null=TRUE){
            $this->campos[$name] = array(
                    'type' => 'DOUBLE',
                    // 'unique' => TRUE,
                    'default' => $default,
                    'null' => $null,
            );
        }
        private function campo_datetime($name, $default=0, $null=TRUE){
            $this->campos[$name] = array(
                    'type' => 'DATETIME',
                    // 'unique' => TRUE,
                    'default' => $default,
                    'null' => $null,
            );
        }
        private function campo_timestamp($name, $default=0, $null=TRUE){
            $this->campos[$name] = array(
                    'type' => 'TIMESTAMP',
                    // 'unique' => TRUE,
                    'default' => $default,
                    'null' => $null,
            );
        }
}//end class Config

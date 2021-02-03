<?php
    class Tabla_rol_usuario extends CI_Model {
        private $tabla = "rol_usuario";
        private $id_tabla = 'id_rol_usuario';

        public function __construct(){
            parent::__construct();
        }//end constructor

        // ================================================
        // Funciones principales del modelo
        // ================================================
        public function select_all(){
            $this->db->select('*');
            $this->db->from($this->tabla);
            return $this->db->get()->result();
        }//end select_all

        public function insert($data=NULL){
            $this->db->insert($this->tabla, $data);
            return $this->db->insert_id();
        }//end insert

        public function update($data=NULL, $id=NULL){
            $this->db->where($this->id_tabla, $id);
            return $this->db->update($this->tabla, $data);
        }//end update

        public function delete($id=NULL){
            $this->db->where($this->id_tabla, $id);
            return $this->db->delete($this->tabla);
        }//end delete

        public function select_where($constraints=NULL){
            $query = $this->db->get_where($this->tabla, $constraints);
            return $query->result();
        }//end select_where

        // ================================================
        // Funciones nuevas del modelo
        // ================================================
        public function rol_usuario($id_user){
            $this->load->model('Tabla_rol');
            $this->db->select("*");
            $this->db->from($this->tabla);
            $this->db->where("id_usuario",$id_user);
            $roles = $this->db->get()->result();

            $rol = array();
            foreach ($roles as $row) {
                $query = $this->Tabla_rol->get_rol($row->id_rol);
                $info['clave'] = $query->id_rol;
                $info['nombre'] = $query->rol;
                $rol[] = $info;
            }//end foreach
            return $rol;
        }//end rol_de_usuario

        //Toma todos los usuarios 
        public function usuarios_todos(){
            $user = array();
            $rol = array();
            $all_user = array();
            $temporal = array();
            $this->db->select('
                usuario.id_usuario, usuario.nombre_usuario, usuario.ap_usuario, usuario.am_usuario,usuario.estatus,
                rol.id_rol, rol.rol
            ');
            $this->db->from($this->tabla);
            $this->db->join('usuario','usuario.id_usuario = rol_usuario.id_usuario');
            $this->db->join('rol','rol.id_rol = rol_usuario.id_rol');
            $this->db->where('usuario.id_usuario !=',1);
            $this->db->order_by("usuario.nombre_usuario", "asc");
            $usuarios = $this->db->get()->result(); //Toma todos usuarios 

            $id_usuario = 0;
            /**
             * Se itera para identificar si 
             * el usuario existe más de una solavez
             */
            foreach ($usuarios as $usuario) {
                if($id_usuario != $usuario->id_usuario){
                    $temporal[] = $usuario;//Se guarda en un arreglo temporal
                }//End if
                $id_usuario = $usuario->id_usuario;
            }//End foreach 
            /**
             * Se iterea el arreglo temporal para obtener 
             * los diferentes roles que obtenga el usuari
             */
            foreach ($temporal as $value) {
                for ($i=0; $i < sizeof($usuarios); $i++) {    
                    if($usuarios[$i]->id_usuario == $value->id_usuario){
                        $rol[] = $usuarios[$i]->rol;
                    }//End if 
                }//End for
                $user['id_usuario'] = $value->id_usuario;
                $user['nombre_usuario'] = $value->nombre_usuario;
                $user['ap_usuario'] = $value->ap_usuario;
                $user['am_usuario'] = $value->am_usuario;
                $user['estatus'] = $value->estatus;
                $user['rol'] = implode(", ",$rol); // Remplaza un arreglo en cadena
                $all_user[] =$user;
                $rol = array();
            }//End foreach
            return covert_array_to_stdlclass($all_user);
        }//usuarios_todos

        //Obtiene los id_rol de un usuario
        public function seleccionar_roles_usuario($id_usuario) {
            $this->db->select('rol.id_rol');
            $this->db->from($this->tabla);
            $this->db->join('usuario','usuario.id_usuario = rol_usuario.id_usuario');
            $this->db->join('rol','rol.id_rol = rol_usuario.id_rol');
            $this->db->where("usuario.id_usuario",$id_usuario);
            $res = $this->db->get()->result();
            $temp = array();
            foreach ($res as $valor) {
                $temp[] = $valor->id_rol;
            }//end foreach
            return $temp;
        }//end seleccionar_roles_de_usuario
        
        //Eliminar roles
        public function eliminar_roles_accesos($id=NULL){
            $this->db->where('id_usuario', $id);
            return $this->db->delete($this->tabla);
        }//end eliminar_roles_accesos

    }//end class Tabla_usuario

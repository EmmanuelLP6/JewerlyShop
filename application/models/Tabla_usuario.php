<?php
    class Tabla_usuario extends CI_Model {
        private $tabla = "usuario";
        private $id_tabla = 'id_usuario';

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

        public function login($email,$password) {
            $this->db->select('usuario.*');
            $this->db->from($this->tabla);
            $this->db->where("email_usuario",$email);
            $this->db->where('password = sha2("'.$password.'",0)');
            $resultado = $this->db->get()->result();
            if(sizeof($resultado) > 0){
                return $resultado[0];
            }//End if
            else{
                return NULL;
            }//end else
        }//end function login

        // ================================================
        // Funciones nuevas del modelo
        // ================================================
        public function encrypt_password($password=NULL) {
            $password = $this->db->query("SELECT sha2('".$password."',0) as password");
            return $password->result()[0]->password;
        }//end encrypt_password

        public function usuario_inner_rol($id_usuario){
            $this->db->select("rol.rol");
            $this->db->from($this->tabla);
            $this->db->join('rol_usuario','usuario.id_usuario = rol_usuario.id_usuario');
            $this->db->join('rol','rol.id_rol = rol_usuario.id_rol');
            $this->db->where("usuario.id_usuario",$id_usuario);
            $roles = $this->db->get()->result();
            return $roles;
        }//End usuario_inner_rol

        public function seleccionar_imagen($id = null) {
            $this->db->select('imagen_usuario');
            $this->db->from($this->tabla);
            $this->db->where($this->id_tabla, $id);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->imagen_usuario;
            }//end if
            else {
                return NULL;
            }//end else
        }//end seleccionar_imagen
    }//end class Tabla_usuario

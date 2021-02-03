<?php

class Tabla_rol extends CI_Model {
    private $tabla = "rol";
    private $id_tabla = 'id_rol';

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
    // Funciones nuevas
    // ================================================
    public function get_rol($id){
        $this->db->select("rol.*");
        $this->db->from($this->tabla);
        $this->db->where("id_rol", $id);
        $resultado = $this->db->get()->result();
        return $resultado[0];
    }//end getRol

    public function obtener_lista_roles(){
        $this->db->select("id_rol,rol");
        $this->db->from($this->tabla);
        $this->db->order_by("rol","ASC");
        $result = $this->db->get()->result();
        $roles = array();
        foreach ($result as $r) {
            $roles[$r->id_rol] = $r->rol;
        }
        return $roles;
    }//end obtener_lista_roles
    
}//end class Tabla_rol

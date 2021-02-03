<?php
    /**
     * Interface para crear la estructura con las funciones necesarios en
     * cada tarea que se va a ocupar
     */
    interface Tarea{
        public function reglas_formulario();
		public function cargar_datos();
        public function crear_vista($nombre_vista=NULL, $datos=NULL);
    }//end interface Tarea

?>

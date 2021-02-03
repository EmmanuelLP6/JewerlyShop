<?php
    class Constantes {

        public $CLAVE_SESION = 'anelShop';

        /*Toda constante debe estar en mayuscula y dar continuidad a la numeracion*/
        //Constantes roles
		public $ROL_NONE = array();
		public $ROL_SUPERADMIN = array();
        public $ROL_ASISTENTE = array();

		//Cosntantes para los estatus
		public $ESTATUS_ACTIVADO = array();
		public $ESTATUS_DESACTIVADO = array();

		//Constantes tareas
		//PANEL
		public $TAREA_NONE = 0;
		public $TAREA_LOGIN = 1;
		public $TAREA_LOGOUT = 2;
		public $TAREA_DASHBOARD = 3;
		public $TAREA_PERFIL = 4;
        public $TAREA_USUARIO_TODOS = 5;
        public $TAREA_USUARIO_NUEVO = 6;
        public $TAREA_USUARIO_DETALLES = 7;

		//Constantes páginas
		//PORTAL -PARTE PUBLICA
		public $PAGINA_NONE = 1000;
		public $PAGINA_INICIO = 1001;
		public $PAGINA_CUESTIONARIO = 1002;

		//info sesión
		public $SES_VAR_PANEL = array();

		//Constante para arreglo de generos
		public $GENEROS = array();
		public $ANIOS = array();

		public function __construct(){

			//Inicialización de las constantes de los roles
			//Respetar el orden de los roles
			$this->ROL_NONE['nombre'] = 'Sin rol';
			$this->ROL_NONE['clave'] = 0;

            //ROL_SUPERADMIN
			$this->ROL_SUPERADMIN['nombre'] = 'Superadmin';
            $this->ROL_SUPERADMIN['clave'] = 35;

            //ROL_ASISTENTE
			$this->ROL_ASISTENTE['nombre'] = 'Asistente';
			$this->ROL_ASISTENTE['clave'] = 2;

			//ESTATUS GENERALES
			$this->ESTATUS_ACTIVADO['nombre'] = 'Activdado';
			$this->ESTATUS_ACTIVADO['clave'] = 1;

			$this->ESTATUS_DESACTIVADO['nombre'] = 'Desactivado';
			$this->ESTATUS_DESACTIVADO['clave'] = -1;

			//Consatnte para arreglo de generos
			$this->GENEROS = array(
				'F' => 'Femenino',
				'M' => 'Masculino'
			);

			// Lo que hace el for es tomar el año actual y la segunda parte es que toma el año
			// actual y le suma 11 años para que se valla recorriendo automáticamente cada año
            for ($i=date('Y'); $i < date("Y",strtotime(date('Y')."+ 11 year")); $i++) {
                $this->ANIOS[$i] = $i;
			}//end for años


			//Arreglo de nombres de variables de sesión
			$this->SES_VAR_PANEL = array(
                $this->CLAVE_SESION.'tarea_actual', $this->CLAVE_SESION.'mensaje', $this->CLAVE_SESION.'sesion_iniciada_panel', $this->CLAVE_SESION.'is_locked', $this->CLAVE_SESION.'id_usuario', $this->CLAVE_SESION.'nombre_usuario',
				$this->CLAVE_SESION.'nombre_completo_usuario', $this->CLAVE_SESION.'roles', $this->CLAVE_SESION.'rol_actual', $this->CLAVE_SESION.'email_usuario',$this->CLAVE_SESION.'imagen_usuario', $this->CLAVE_SESION.'login_failure', $this->CLAVE_SESION.'idElementoEditar',
                '__ci_last_regenerate',
		    );

        }//end constructor

    }//end class Constantes
?>

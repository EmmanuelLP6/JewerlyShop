<?php

class Operaciones_bd extends CI_Model {

    public function __construct(){
        $this->load->library('constantes');
    }//end function __construct

    public function importar(){
        $query = '';
		$sqlScript = file(base_url('/recursos/dbbase.sql'));
		foreach ($sqlScript as $line)   {

	        $startWith = substr(trim($line), 0 ,2);
	        $endWith = substr(trim($line), -1 ,1);

	        if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
                continue;
	        }//end if lineas de comentarios

	        $query = $query . $line;
	        if ($endWith == ';') {
                if (!$this->db->simple_query($query)){
                    echo '<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query. '</b></div>';
                }//end if error al ejecutar query
                $query= '';
	        }//end if fin linea de query
		}//end foreach
		echo '<div class="success-response sql-import-response">SQL basedb file imported successfully</div>';
    }//end function importar

}//end class Operacionesdb

<?php 
    define('METHOD','AES-256-CBC');
	define('SECRET_KEY','%9/UPTxCATIAMLab');
	define('SECRET_IV', date('Y').'14');

    class Lcrypt {
        public function __construct() { }//end construct

        public function encriptar($cadena = NULL) {
            $clave_encriptada = FALSE;
			$clave = hash('sha256', SECRET_KEY);
			$iv = substr(hash('sha256', SECRET_IV), 0, 16);
			$clave_encriptada = openssl_encrypt($cadena, METHOD, $clave, 0, $iv);
			$clave_encriptada = base64_encode($clave_encriptada);
			return $clave_encriptada;
        }//end encriptar

        public function desencriptar($cadena = NULL) {
            $clave = hash('sha256', SECRET_KEY);
			$iv = substr(hash('sha256', SECRET_IV), 0, 16);
			$clave_desencriptada = openssl_decrypt(base64_decode($cadena), METHOD, $clave, 0, $iv);
			return $clave_desencriptada;
        }//end desencriptar        

    }//end Class Lcrypt
    
?>
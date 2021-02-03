<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Logout extends CI_Controller {
        public function index(){
            $this->session->unset_userdata($this->constantes->SES_VAR_PANEL);
            $this->session->sess_destroy();
            redirect('principal');
        }//end index
    }//end class Login

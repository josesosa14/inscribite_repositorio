<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Background extends MX_Controller {

    public function __construct() {
        parent::__construct();
        /*$CI = get_instance();
        if ($CI->input->is_cli_request()) {
            $this->test();
        }*/
        
    }
    
    public function test(){
        echo 'hola';
    }

    public function enviarCorreo($mail_id) {
        $this->load->model("mailing/mailing_model", "mailing");
        $this->mailing->nuevoMail($mail_id);
    }

}

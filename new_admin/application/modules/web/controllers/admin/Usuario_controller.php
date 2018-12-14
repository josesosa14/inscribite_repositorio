<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Usuario_model $usuario
 */
class Usuario_controller extends A_Controller {

    function __construct() {
        parent::__construct();
        
        $this->setTemplateDefault("admin/templateAdmin");
        $this->load->model("usuario/usuariomodel","usuario");
    }

    public function index() {
        
    }

    public function emailsByAjax() {
        echo json_encode($this->usuario->getEmailsByAjax($this->input->get()));
    }

}

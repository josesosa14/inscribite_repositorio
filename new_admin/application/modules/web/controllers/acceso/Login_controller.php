<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends A_Controller {

    /**
     * Index Page for this controller.
     *
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("usuario/usuariomodel");
    }

    public function index() {
        $this->loadView("login/index");
    }

    public function gidema() {
        $this->loadView("login/index_gidema");
    }

    public function silogea() {
        $this->loadView("login/index_silogea");
    }

    public function validar() {
        $nombreUsuario = $this->input->post("usuario");
        $password = $this->input->post("password");
        $usuario = $this->usuariomodel->validar($nombreUsuario, $password);
        if ($usuario) {
            $data = array(
                'logged' => TRUE,
                'id_usuario' => $usuario->getId(),
                'nombre_usuario' => $usuario->getNombreUsuario(),
                'usuario_rol' => $usuario->getRoles()[0]->getId(),
                'rol' => $usuario->getArrayRoles(),
                'controlador' => $usuario->getRoles()[0]->getControlador()
            );
            $this->session->set_userdata($data);
            redirect("decodificador");
        } else {
            redirect(base_url() . 'login');
        }
    }

    public function logout_ci() {
        $this->session->sess_destroy();
        $this->gidema();
    }

}

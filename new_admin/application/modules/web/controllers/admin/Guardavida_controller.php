<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * @property Guardavida_model $guardavida
 * @property Tipoatributo_model $tipoatributo
 */
class Guardavida_controller extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("guardavida/guardavida_model", "guardavida");
        $this->load->model("tipoatributo/tipoatributo_model", "tipoatributo");
        $this->setTemplateDefault("admin/templateAdmin");
    }

    public function index($args = false) {
        if ($this->post()) {
            $this->guardavida->insertar($this->post());
            redirect("admin-guardavida");
        } elseif ($args) {
            $data["guardavida"] = $this->guardavida->getById($args);
            $data["tipos"] = $this->tipoatributo->getTipoAtributos();
            $data["footer"] = "guardavida/footer";
            $this->loadTemplateDefault("guardavida/guardavida_formulario", $data);
        } else {
            $data["footer"] = "guardavida/footer";
            $data["tipos"] = $this->tipoatributo->getTipoAtributos();
            $this->loadTemplateDefault("guardavida/guardavida_formulario", $data);
        }
    }

    public function getGuardavidaAjax() {
        echo json_encode($this->guardavida->getGuardavidaAjax($this->input->get()));
    }

    public function borrar($gua_id) {
        $this->guardavida->borrar($gua_id);
        redirect("admin-guardavida");
    }

    public function emailsByAjax() {
        echo json_encode($this->guardavida->getEmailsByAjax($this->input->get()));
    }

}

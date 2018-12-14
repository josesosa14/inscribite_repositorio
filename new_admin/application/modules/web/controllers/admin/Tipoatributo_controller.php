<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * @property Tipoatributo_model $tipoatributo
 */
class Tipoatributo_controller extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("tipoatributo/tipoatributo_model", "tipoatributo");
        $this->setTemplateDefault("admin/templateAdmin");
    }

    public function index($args = false) {
        if ($this->post()) {
            $this->tipoatributo->insertar($this->post());
            redirect("admin-tipoatributo");
        } elseif ($args) {
            $data["tipoatributo"] = $this->tipoatributo->getById($args);
            $data["footer"] = "tipoatributo/footer";
            $this->loadTemplateDefault("tipoatributo/tipoatributo_formulario", $data);
        } else {
            $data["footer"] = "tipoatributo/footer";
            $this->loadTemplateDefault("tipoatributo/tipoatributo_formulario", $data);
        }
    }

    public function getTipoatributoAjax() {
        echo json_encode($this->tipoatributo->getTipoatributoAjax($this->input->get()));
    }
    
    public function borrar($tip_id){
        $this->tipoatributo->borrar($tip_id);
        redirect("admin-tipoatributo");
    }

}

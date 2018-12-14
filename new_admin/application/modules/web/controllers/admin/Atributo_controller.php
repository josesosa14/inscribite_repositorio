<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * @property Atributo_model $atributo
 */
class Atributo_controller extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("atributo/atributo_model", "atributo");
        $this->setTemplateDefault("admin/templateAdmin");
    }

    public function index($args = false) {
        if ($this->post()) {
            $this->atributo->insertar($this->post());
            redirect("admin-atributo");
        } elseif ($args) {
            $data["atributo"] = $this->atributo->getById($args);
            $data["tipos"]= $this->atributo->getAllCollection("Tipoatributo");
            $data["footer"] = "atributo/footer";
            $this->loadTemplateDefault("atributo/atributo_formulario", $data);
        } else {
            $data["footer"] = "atributo/footer";
            $data["tipos"]= $this->atributo->getAllCollection("Tipoatributo");
            $this->loadTemplateDefault("atributo/atributo_formulario", $data);
        }
    }

    public function getAtributoAjax() {
        echo json_encode($this->atributo->getAtributoAjax($this->input->get()));
    }
    
    public function borrar($atr_id){
        $this->atributo->borrar($atr_id);
        redirect("admin-atributo");
    }

}

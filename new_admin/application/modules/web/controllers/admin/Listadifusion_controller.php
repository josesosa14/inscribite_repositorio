<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * @property Listadifusion_model $listadifusion
 */
class Listadifusion_controller extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("listadifusion/listadifusion_model", "listadifusion");
        $this->setTemplateDefault("admin/templateAdmin");
    }

    public function index($args = false) {
        if ($this->post()) {
            $this->listadifusion->insertar($this->post());
            redirect("admin-listadifusion");
        } elseif ($args) {
            $listadifusion = $this->listadifusion->getById($args);
            $data["listadifusion"] = $listadifusion;
            $data["footer"] = "../listadifusion/footer";
            $this->loadTemplateDefault("../listadifusion/listadifusion_formulario", $data);
        } else {
            $data["footer"] = "../listadifusion/footer";
            $this->loadTemplateDefault("../listadifusion/listadifusion_formulario", $data);
        }
    }

    public function getListadifusionAjax() {
        echo json_encode($this->listadifusion->getListadifusionAjax($_GET));
    }

}

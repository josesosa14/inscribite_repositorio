<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * @property Solicitudtransferencia_model $solicitudtransferencia
 */
class Solicitudtransferencia_controller extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("solicitudtransferencia/solicitudtransferencia_model");
        $this->setTemplateDefault("admin/templateAdmin");
    }

    public function index($args = false) {
        if ($this->post()) {
            $this->solicitudtransferencia_model->insertar($this->post());
            redirect("solicitudtransferencia");
        } elseif ($args) {
            $solicitudtransferencia = $this->solicitudtransferencia_model->getById($args);
            $data["solicitudtransferencia"] = $solicitudtransferencia;
            $data["footer"] = "../solicitudtransferencia/footer";
            $this->loadTemplateDefault("../solicitudtransferencia/solicitudtransferencia_formulario", $data);
        } else {
            $data["footer"] = "../solicitudtransferencia/footer";
            $this->loadTemplateDefault("../solicitudtransferencia/solicitudtransferencia_formulario", $data);
        }
    }

    public function getSolTransTableAjax() {
        echo json_encode($this->solicitudtransferencia_model->getSolTransTableAjax($_GET));
    }

    public function renglonesTransferenciaDetalle($args = false) {
        echo json_encode($this->solicitudtransferencia_model->renglonesTransferenciaDetalle($args));
    }

    public function borrarSolicitudTransferencia($id) {
        $this->solicitudtransferencia_model->borrarSolicitudTransferencia($id);
        redirect("solicitudtransferencia");
    }

}

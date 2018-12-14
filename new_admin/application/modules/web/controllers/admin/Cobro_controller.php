<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * @property Cobro_model $cobro
 */
class Cobro_controller extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("cobro/cobro_model");
        $this->setTemplateDefault("admin/templateAdmin");
    }

    public function index($args = false) {
        if ($this->post()) {
            $this->cobro_model->insertar($this->post());
            redirect("cobro");
        } elseif ($args) {
            $cobro = $this->cobro_model->getById($args);
            $data["cobro"] = $cobro;
            $this->loadTemplateDefault("../cobro/cobro_formulario", $data);
        } else {
            $data["footer"] = "../cobro/footer";
            $data["estado_cuenta"] = $this->cobro_model->getEstadoCuenta();
            $this->loadTemplateDefault("../cobro/cobro_formulario", $data);
        }
    }

    public function getCobroAjax() {
        echo json_encode($this->cobro_model->getCobroAjax($_GET));
    }

    public function borrar($cob_id) {
        $this->cobro_model->borrar($cob_id);
        redirect("cobro");
    }

    public function xls_cobro_renglones($args) {
        $this->cobro_model->xls_cobro_renglones($args);
    }

    public function generaPagos($cob_id) {
        //$cobro = $this->cobro_model->getCollectionById("Cobro", $cob_id);
        if ($cob_id) {
            $cobro = $this->cobro_model->getCollectionById("Cobro", $cob_id);
            $this->cobro_model->generaPagos($cobro);
        } else {
            $this->cobro_model->generaTodosLosPagos();
        }
        redirect("cobro");
    }

    public function generaTodosLosPagos() {
        $this->cobro_model->generaTodosLosPagos();
        redirect("cobro");
    }

}

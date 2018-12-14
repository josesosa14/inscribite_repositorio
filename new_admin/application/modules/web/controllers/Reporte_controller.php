<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Reporte_controller extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->setTemplateDefault("admin/templateAdmin");
        $this->load->model("empresa/EmpresaModel");
        $this->load->model("cobro/cobro_model");
    }

    function estadoCuenta() {
        $this->load->model("evento_model");
        $data["clientes"] = $this->EmpresaModel->getEmpresas();
        $data["eventos"] = $this->evento_model->getEventosActivos();
        $data["footer"]="reportes/footer";
        $this->loadTemplateDefault("reportes/estado_cuenta_clientes", $data);
    }

    function estadoCuentaAjax() {
        echo json_encode($this->EmpresaModel->getEstadoCuentaAjax($this->input->get()));
    }
    function estadoCuentaTotalesAjax() {
        echo $this->EmpresaModel->getEstadoCuentaTotalesAjax($this->input->get());
    }
    
    function miEstadoCuenta(){
        $data["estado_cuenta"] = $this->cobro_model->getEstadoCuenta();
        $this->loadTemplateDefault("reportes/mi_estado_cuenta", $data);
    }

}

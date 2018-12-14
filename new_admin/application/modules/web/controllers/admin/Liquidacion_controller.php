<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * @property Liquidacion_model $liquidacion
 */
class Liquidacion_controller extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("liquidacion/liquidacion_model");
        $this->load->model("empresa/EmpresaModel");
        $this->load->model("cobro/cobro_model");
        $this->load->model("evento_model");
        $this->setTemplateDefault("admin/templateAdmin");
    }

    public function index($args = false) {
        if ($this->post()) {
            $this->liquidacion_model->insertar($this->post());
            redirect("liquidacion");
        } elseif ($args) {
            $liquidacion = $this->liquidacion_model->getById($args);
            $data["liquidacion"] = $liquidacion;
            $this->loadTemplateDefault("../liquidacion/liquidacion_formulario", $data);
        } else {
            $data["footer"] = "../liquidacion/footer";
            $data["clientes"] = $this->EmpresaModel->getEmpresas();
            $data["eventos"] = $this->evento_model->getEventosActivos();
            $this->loadTemplateDefault("../liquidacion/liquidacion_formulario", $data);
        }
    }

    public function getLiquidacionAjax($liq_id=false) {
        echo json_encode($this->liquidacion_model->getLiquidacionAjax($this->input->get(),$liq_id));
    }

    function borrar($liq_id) {
        $this->liquidacion_model->borrar($liq_id);
        redirect("liquidacion");
    }
    function pagar($liq_id) {
        $this->liquidacion_model->pagar($liq_id);
        redirect("liquidacion");
    }
    
    function getReporteLiquidacion($liq_id){
        $this->liquidacion_model->xls_decodificador($liq_id);
    }

}

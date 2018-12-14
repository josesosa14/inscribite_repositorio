<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * @property Decodificador_model $decodificador
 */
class Decodificador_controller extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("decodificador/decodificador_model");
        $this->setTemplateDefault("admin/templateAdmin");
    }

    public function index($args = false) {
        if ($this->post()) {
            $this->decodificador_model->insertar($this->post());
            redirect("decodificador");
        } elseif ($args) {
            $decodificador = $this->decodificador_model->getById($args);
            $data["decodificador"] = $decodificador;
            $this->loadTemplateDefault("../decodificador/decodificador_formulario", $data);
        } else {
            $data["footer"] = "../decodificador/footer";
            $decodificador = $this->decodificador_model->getCollectionById("Decodificador", 1);
            $this->loadTemplateDefault("../decodificador/decodificador_formulario", $data);
        }
    }
    
    public function reprocesar($med_id){
        $this->decodificador_model->reProcesarMedio($med_id);
        redirect("decodificador");
    }

    public function borrardecodificador($dec_id) {
        $this->decodificador_model->borrar($dec_id);
        redirect("decodificador");
    }

    public function getDecodificadorAjax() {
        echo json_encode($this->decodificador_model->getDecodificadorAjax($_GET));
    }

    public function xls_decodificador($dec_id) {
        $this->decodificador_model->xls_decodificador($dec_id);
    }

    public function xls_acumulado($tipo=false) {
        $this->decodificador_model->xls_acumulado($tipo);
    }

    function avisa_pagos(){
        $this->decodificador_model->avisaPagos();
    }
}

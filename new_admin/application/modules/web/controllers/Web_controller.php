<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Web_controller extends A_Controller {

    function __construct() {
        parent::__construct();
        $this->setTemplateDefault("templateWeb");
        $this->load->model("guardavida/guardavida_model", "guardavida");
        $this->load->model("liquidacion/liquidacion_model", "liquidacion");
    }
    
    public function test(){
        echo 'hoola';
    }

    public function index($email = false) {
        if ($this->post()) {
            $this->guardavida->insertaDesdeWeb($this->post());
            redirect("registro-guardavida/".$this->post("gua_id")."?e=1");
        } elseif ($email) {
            $data["guardavida"] = $this->guardavida->getGuardavidaByEmail($email);
            if (!$data["guardavida"]) {
                die('acceso no autorizado');
            }
            $this->loadTemplateDefault("web/registro_guardavida", $data);
        } else {
            $this->loadTemplateDefault("web/registro_guardavida");
        }
    }

    function getRenglonesPagos($liq_id = false) {
        if ($this->post()) {
            if ($this->post("data")) {
                $data["destinos"]=converArraySerializeToArrayData($this->post("data"));
                $data["liq_id"]= $this->post("liq_id");
            } else {
                $data=$this->post();
            }
            
            $this->liquidacion->insertaLiquidacionEmpresa($data);
            redirect("liquidacion");
        } elseif ($liq_id) {
            $this->setTemplateDefault("admin/templateAdmin");
            $data["liquidacion"] = $this->liquidacion->getByIdEmpresa($liq_id);
            $data["footer"] = "../liquidacion/footer";
            $this->loadTemplateDefault("../liquidacion/liquidacion_renglones_pagos", $data);
        } else {
            die('acceso no autorizado');
        }
    }

}

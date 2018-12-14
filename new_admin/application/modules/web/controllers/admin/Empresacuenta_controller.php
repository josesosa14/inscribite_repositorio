<?php 

defined("BASEPATH") OR exit("No direct script access allowed");


/**
 * @property Empresacuenta_model $empresacuenta
 */
class Empresacuenta_controller extends Admin_Controller {

public function __construct() {
parent::__construct();
$this->load->model("empresacuenta/empresacuenta_model");
$this->setTemplateDefault("admin/templateAdmin");
}

public function index($args=false) {
if ($this->post()) {
$this->empresacuenta_model->insertar($this->post());
redirect("empresacuenta");
} elseif ($args) {
$empresacuenta = $this->empresacuenta_model->getById($args);
$data["empresacuenta"] = $empresacuenta;
$this->loadTemplateDefault("../empresacuenta/empresacuenta_formulario", $data);
} else {
$data["footer"] = "../empresacuenta/footer";
$this->loadTemplateDefault("../empresacuenta/empresacuenta_formulario", $data);


}

}

public function getEmpresacuentaAjax() {
echo json_encode($this->empresacuenta_model->getEmpresacuentaAjax($_GET));


}

}
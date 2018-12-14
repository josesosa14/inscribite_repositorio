<?php 

defined("BASEPATH") OR exit("No direct script access allowed");


/**
 * @property Mediodecodificado_model $mediodecodificado
 */
class Mediodecodificado_controller extends Admin_Controller {

public function __construct() {
parent::__construct();
$this->load->model("mediodecodificado/mediodecodificado_model");
$this->setTemplateDefault("admin/templateAdmin");
}

public function index($args=false) {
if ($this->post()) {
$this->mediodecodificado_model->insertar($this->post());
redirect("mediodecodificado");
} elseif ($args) {
$mediodecodificado = $this->mediodecodificado_model->getById($args);
$data["mediodecodificado"] = $mediodecodificado;
$this->loadTemplateDefault("../mediodecodificado/mediodecodificado_formulario", $data);
} else {
$data["footer"] = "../mediodecodificado/footer";
$this->loadTemplateDefault("../mediodecodificado/mediodecodificado_formulario", $data);


}

}

public function getMediodecodificadoAjax() {
echo json_encode($this->mediodecodificado_model->getMediodecodificadoAjax($_GET));


}

}
<?php 

defined("BASEPATH") OR exit("No direct script access allowed");


/**
 * @property Decodificado_renglones_model $decodificado_renglones
 */
class Decodificado_renglones_controller extends Admin_Controller {

public function __construct() {
parent::__construct();
$this->load->model("decodificado_renglones/decodificado_renglones_model");
$this->setTemplateDefault("admin/templateAdmin");
}

public function index($args=false) {
if ($this->post()) {
$this->decodificado_renglones_model->insertar($this->post());
redirect("decodificado_renglones");
} elseif ($args) {
$decodificado_renglones = $this->decodificado_renglones_model->getById($args);
$data["decodificado_renglones"] = $decodificado_renglones;
$this->loadTemplateDefault("../decodificado_renglones/decodificado_renglones_formulario", $data);
} else {
$data["footer"] = "../decodificado_renglones/footer";
$this->loadTemplateDefault("../decodificado_renglones/decodificado_renglones_formulario", $data);


}

}

public function getDecodificado_renglonesAjax() {
echo json_encode($this->decodificado_renglones_model->getDecodificado_renglonesAjax($_GET));


}

}
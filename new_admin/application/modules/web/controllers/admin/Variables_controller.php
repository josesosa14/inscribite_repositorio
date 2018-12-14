<?php 

defined("BASEPATH") OR exit("No direct script access allowed");


/**
 * @property Variables_model $variables
 */
class Variables_controller extends Admin_Controller {

public function __construct() {
parent::__construct();
$this->load->model("variables/variables_model");
$this->setTemplateDefault("admin/templateAdmin");
}

public function index($args=false) {
if ($this->post()) {
$this->variables_model->insertar($this->post());
redirect("variables");
} elseif ($args) {
$variables = $this->variables_model->getById($args);
$data["variables"] = $variables;
$this->loadTemplateDefault("../variables/variables_formulario", $data);
} else {
$data["footer"] = "../variables/footer";
$this->loadTemplateDefault("../variables/variables_formulario", $data);


}

}

public function getVariablesAjax() {
echo json_encode($this->variables_model->getVariablesAjax($_GET));


}

}
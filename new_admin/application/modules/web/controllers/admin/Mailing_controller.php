<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * @property Mailing_model $mailing
 */
class Mailing_controller extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("mailing/mailing_model");
        $this->setTemplateDefault("admin/templateAdmin");
    }

    public function index($args = false) {
        if ($this->post()) {
            $this->mailing_model->insertar($this->post());
            redirect("mailing");
        } elseif ($args) {
            $mailing = $this->mailing_model->getById($args);
            $data["mailing"] = $mailing;
            $data["listas"]=$this->mailing_model->getAllCollection("Listadifusion");
            $this->loadTemplateDefault("../mailing/mailing_formulario", $data);
        } else {
            $data["footer"] = "../mailing/footer";
            $data["listas"]=$this->mailing_model->getAllCollection("Listadifusion");
            $this->loadTemplateDefault("../mailing/mailing_formulario", $data);
        }
    }

    public function getMailingAjax() {
        echo json_encode($this->mailing_model->getMailingAjax($_GET));
    }

    function nuevoMail() {
        $message['success'] = $this->mailing_model->nuevoMail($this->post());
        $message['text'] = $message['success'] ? "MAIL INGRESADO" : "MAIL EXISTENTE";
        echo json_encode($message);
    }

}

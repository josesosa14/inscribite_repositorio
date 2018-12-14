<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class EmpresaController extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        //Por ahora sin template default
        $this->setTemplateDefault("admin/templateAdmin");
        $this->load->model("empresa/EmpresaModel");
    }

    public function index($args = false) {
        $data['provincias'] = $this->EmpresaModel->getProvincias();
        $data['arrayNombreCondIvas'] = $this->EmpresaModel->getNombreCondIvas();
        $data['footer'] = 'empresa/footer_extra';
        /*
         * Si recibe post redireccionamos con un post a la misma página para
         * insertar un nuevo cliente...
         */
        if ($this->post()) {
            $this->EmpresaModel->insertarEmpresa($this->post());
            redirect('cliente');
        } elseif ($args) {
            $empresa = $this->EmpresaModel->getById($args);
            $data["empresa"] = $empresa;
            $data["localidad"] = $this->EmpresaModel->getLocalidad($empresa->getLocalidad());
            $this->loadTemplateDefault("empresa/index", $data);
        } else {/*
         * sino, le pasamos los datos correspondientes para mostrar por
         * pantalla los clientes..
         */
            $data['empresas'] = $this->EmpresaModel->getEmpresas();
            $this->loadTemplateDefault("empresa/index", $data);
        }
    }

    public function getEmpresaTableAjax() {
        echo json_encode($this->EmpresaModel->getEmpresaTableAjax($_GET));
    }

    public function borrarCliente($emp_id) {
        $this->EmpresaModel->borrarEmpresa($emp_id);
        redirect("cliente");
    }

    public function getJSONEmpresas() {
        $empresas = $this->EmpresaModel->getJSONempresas($_GET);
        echo json_encode($empresas);
    }

    public function JSONempresaById() {
        $empresa = $this->EmpresaModel->getEmpresaByIdJSON($this->post());
        echo json_encode($empresa);
    }

    function estadoCuenta() {
        $this->load->model("evento_model");
        $data["clientes"] = $this->EmpresaModel->getEmpresas();
        $data["eventos"] = $this->evento_model->getEventosActivos();
        $data["footer"] = "reportes/footer";
        $this->loadTemplateDefault("reportes/estado_cuenta_clientes", $data);
    }

    function estadoCuentaAjax() {
        echo json_encode($this->EmpresaModel->getEstadoCuentaAjax($this->input->get()));
    }

    function estadoCuentaTotalesAjax() {
        echo $this->EmpresaModel->getEstadoCuentaTotalesAjax($this->input->get());
    }

    function getEmpresaEventos() {
        echo json_encode($this->EmpresaModel->getEmpresaEventos($this->input->get()));
    }
    
    function getEmpresaInscripciones($emp_id){
        $this->load->model("evento_model");
        $data["empresa"] = $this->EmpresaModel->getCollectionById("Empresa",$emp_id);
        $this->loadTemplateDefault("empresa/inscripciones_mensualidades", $data);
    }

    
    function getInscripcionesDetalles($emp_id,$ev_id){
        $this->load->model("evento_model");
        $data["empresa"] = $this->EmpresaModel->getCollectionById("Empresa",$emp_id);
        $data["renglones"] = $this->EmpresaModel->getInscripcionesDetalles($emp_id,$ev_id);
        $this->loadTemplateDefault("empresa/inscripciones_detalles", $data);
    }
}

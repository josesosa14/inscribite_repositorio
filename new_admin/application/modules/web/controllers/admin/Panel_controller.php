<?phpdefined('BASEPATH') OR exit('No direct script access allowed');class Panel_controller extends Admin_Controller {    public function __construct() {        parent::__construct();        $this->load->model("admin/formulario_model");    }    function panel() {        $data['vista'] = "panel/panel";        $data['footer'] = 'panel/footer_mapa';        $this->load->view("admin/templateAdmin", $data);    }    function maker() {        if ($this->post()) {            $this->formulario_model->insertar($this->post());        } else {            $data['vista'] = "panel/index";            $data['footer'] = 'panel/footer';            $this->load->view("admin/templateAdmin", $data);        }    }        function sync(){        $this->load->model("decodificador/decodificador_model");        $this->decodificador_model->sincronizaInfoNecesaria(true);        redirect("decodificador");    }}
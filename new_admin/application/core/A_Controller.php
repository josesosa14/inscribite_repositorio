<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class A_Controller
 * @property Mobdetector $mobdetector
 */
class A_Controller extends MX_Controller {

    protected $templateDefault;
    public $ver = false;
    public $edita = false;

    function __construct() {
        parent::__construct();
        $this->load->library("mobdetector");
        $this->load->library("Phpmailer");
        /* $this->configuraciones = $this->getConfiguraciones();
          if (!isset($_SESSION['idioma'])) {
          $_SESSION['idioma'] = "ES";
          }
          $this->lang->load('general_lang', getIdiomaActual()); */
    }

    function validaPermiso($full, $vista = false) {
        if ($this->tienePermiso($full)) {
            $this->edita = true;
            $this->ver = true;
        } elseif ($this->tienePermiso($vista)) {
            $this->ver = true;
        } else {
            redirect(base_url() . $this->session->controlador);
        }
    }

    function tienePermiso($permiso_pedido) {
        $this->load->model("usuario/usuariomodel");
        $rol_actual = $this->usuariomodel->getCollectionById("Rol", $_SESSION['usuario_rol']);
        foreach ($rol_actual->getPermisos() as $permiso) {
            if ($permiso->getNombre() == $permiso_pedido || $permiso->getNombre() == "global") {
                return true;
            }
        }
        return false;
    }

    function getTemplateDefault() {
        return $this->templateDefault;
    }

    function setTemplateDefault($templateDefault) {
        $this->templateDefault = $templateDefault;
    }

    public function index() {
        echo "mensaje de ejemplo";
    }

    public function loadView($vista, $datos = false) {
        if (!$datos) {
            $this->load->view($vista);
        } else {
            $this->load->view($vista, $datos);
        }
    }

    public function loadModel($modelo) {
        $this->load->model($modelo);
    }

    public function post($dato = false) {
        if ($dato) {
            return $this->input->post($dato);
        } else {
            return $this->input->post();
        }
    }

    function loadTemplateDefault($vista = false, array $datos = null, $template = false) {
        /*
         * agregamos el parámetro recibido $vista al array recibido $datos con
         * la clave 'vista' que apunta al parámetro recibido $vista. De esta forma
         * tenemos un array $datos con toda la información relevante
         */
        $datos['vista'] = $vista;
        if ($template) {
            $this->load->view($template, $datos);
        } else {
            $this->load->view($this->getTemplateDefault(), $datos);
        }
    }

}

class A_Sesion_Controller extends A_Controller {

    /**
     * Controlador que verifica siempre la sesión
     *
     * 
     */
    public function __construct() {
        parent::__construct();

        $this->load->helper("admin_helper");
        if ($this->session->logged == false) {
            redirect(base_url() . 'web');
        }
    }

    public function index() {
        
    }

}

class Admin_Controller extends A_Controller {

    /**
     * Controlador que verifica siempre la sesión
     *
     * 
     */
    public function __construct() {
        parent::__construct();

        $this->load->helper("admin_helper");

        $this->session->desde_inscribite = false;
        if (isset($_SERVER["HTTP_REFERER"]) && strpos($_SERVER["HTTP_REFERER"], "http://www.inscribiteonline.com.ar/empresas/") !== false) {
            $this->session->desde_inscribite = true;
        }
            

        if ($this->session->logged == false || ($this->session->usuario_rol != 3 && $this->session->usuario_rol != 1)) {
            if (!isset($_SERVER["HTTP_REFERER"]) || strpos($_SERVER["HTTP_REFERER"], "http://www.inscribiteonline.com.ar/empresas/") === false) {
                redirect(base_url() . 'web?deslogeado');
            }
        }
    }

    public function index() {
        
    }

}

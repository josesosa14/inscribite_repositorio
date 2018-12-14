<?php

//defined("BASEPATH") OR exit("No direct script access allowed");
/**
 * Empresa
 *
 * @Table(name="empresa")
 * @Entity
 */
class Empresa {

    /**
     * @var integer $id
     *
     * @Column(name="emp_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nombre
     *
     * @Column(name="emp_nombre", type="string", nullable=true)
     */
    private $nombre;

    /**
     * @var string $cuit
     *
     * @Column(name="emp_cuit", type="integer", nullable=true)
     */
    private $cuit;

    /**
     * @var string $condIva
     *
     * @Column(name="emp_cond_iva", type="string", nullable=true)
     */
    private $condIva; //esto no es clave foránea a tabla condIva, es varchar
    /**
     * @var string $mail
     *
     * @Column(name="emp_mail", type="string", nullable=true)
     */
    private $mail;

    /**
     * @var string $domicilio
     *
     * @Column(name="emp_domicilio", type="string", nullable=true)
     */
    private $domicilio;

    /**
     * @var string $codigoPostal
     *
     * @Column(name="emp_cp", type="integer", nullable=true)
     */
    private $codigoPostal;

    /**
     * @var string fechaCreacion
     *
     * @Column(name="emp_fecha_in", type="date", nullable=true)
     */
    private $fechaCreacion;

    /**
     * @var string $localidad
     *
     * @Column(name="emp_localidad", type="integer", nullable=true)
     */
    private $localidad;

    /**
     * @ManyToOne(targetEntity="Provincia")
     * @JoinColumn(name="emp_provincia", referencedColumnName="id")
     */
    private $provincia;

    /**
     * @var string $usuario
     *
     * @Column(name="emp_usuario", type="string", nullable=true)
     */
    private $usuario;

    /**
     * @var string $password
     *
     * @Column(name="emp_password", type="string", nullable=true)
     */
    private $password;

    /**
     * @var string $estado
     *
     * @Column(name="emp_estado", type="smallint", nullable=true)
     */
    private $estado;

    /**
     * @var Empresacuenta[] $cuentas
     * @OneToMany(targetEntity="Empresacuenta", mappedBy="empresa")
     * @Where(clause = "activa = true")
     */
    private $cuentas;

    /**
     * @var string $comisionACobrar
     *
     * @Column(name="emp_comision", type="float")
     */
    private $comisionACobrar;

    /**
     * @var Mensualidad[] $mensualidades
     * @OneToMany(targetEntity="Mensualidad", mappedBy="empresa")
     */
    private $mensualidades;

    function getMensualidades() {
        return $this->mensualidades;
    }

    function setMensualidades(array $mensualidades) {
        $this->mensualidades = $mensualidades;
    }

    function getCuentas() {
        return $this->cuentas;
    }

    function setCuentas(array $cuentas) {
        $this->cuentas = $cuentas;
    }

    function getComisionACobrar() {
        return $this->comisionACobrar;
    }

    function getCuentaDefault() {
        foreach ($this->getCuentas() as $cada_cuenta) {
            if ($cada_cuenta->getDefault()) {
                return $cada_cuenta;
            }
        }
        return false;
    }

    function setComisionACobrar($comisionACobrar) {
        $this->comisionACobrar = $comisionACobrar;
    }

    /*
     * "emp_id" => $this->getId(),
     * "emp_cond_iva" => $this->getCondIva(),
      "emp_fecha_in" => $this->getFechaCreacion(),
      "emp_password" => $this->getPassword(),
      "emp_usuario" => $this->getUsuario()
     */

    public function getNombreProvincias() {
        $provincias = array("", "Buenos Aires", "Catamarca", "Chaco", "Chubut", "Córdoba", "Corrientes", "Entre Ríos",
            "Formosa", "Jujuy", "La Pampa", "La Rioja", "Mendoza", "Misiones", "Neuquén", "Río Negro",
            "Salta", "San Juan", "San Luis", "Santa Cruz", "Santa Fe", "Santiago del Estero",
            "Tierra del Fuego", "Tucumán");
        return $provincias;
    }

    public function getNombreEstados() {
        $estados = array("Inactivo", "Activo");
        return $estados;
    }

    public function getCuentaActiva() {
        return $this->cuentas[0];
    }

    public function getDatosArray() {
        /*
         * Definimos un array $provincias para devolver al view y mostrar
         * el nombre de la provincia y no el integer. El integer será el índice
         * que tomará el array. "0" => "Buenos Aires", "1" => "Catamarca", etc.
         */
        /* $provincias = array("Buenos Aires", "Catamarca", "Chaco", "Chubut", "Córdoba", "Corrientes", "Entre Ríos", 
          "Formosa", "Jujuy", "La Pampa", "La Rioja", "Mendoza", "Misiones", "Neuquén", "Río Negro",
          "Salta", "San Juan", "San Luis", "Santa Cruz", "Santa Fe", "Santiago del Estero",
          "Tierra del Fuego", "Tucumán"); */
        //De manera semejante trabajamos con $condIva y $estado

        $e = $this->getNombreEstados();
        $array = array("id" => $this->getId(),
            "emp_nombre" => $this->getNombre(),
            "emp_cuit" => $this->getCuit(),
            "emp_cond_iva" => $this->getCondIva(),
            "emp_mail" => $this->getMail(),
            "emp_domicilio" => $this->getDomicilio(),
            "emp_cp" => $this->getCodigoPostal(),
            "emp_localidad" => $this->getLocalidad(),
            "emp_provincia" => "provincia",
            "emp_usuario" => $this->getUsuario(),
            "emp_estado" => $e[$this->getEstado()],
        );
        return $array;
    }

    function getCondIva() {
        return $this->condIva;
    }

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCuit() {
        return $this->cuit;
    }

    function getMail() {
        return $this->mail;
    }

    function getDomicilio() {
        return $this->domicilio;
    }

    function getCodigoPostal() {
        return $this->codigoPostal;
    }

    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function getLocalidad() {
        return $this->localidad;
    }

    function getProvincia() {
        return $this->provincia;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getPassword() {
        return $this->password;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCuit($cuit) {
        $this->cuit = $cuit;
    }

    function setMail($mail) {
        $this->mail = $mail;
    }

    function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;
    }

    function setCodigoPostal($codigoPostal) {
        $this->codigoPostal = $codigoPostal;
    }

    function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    function setLocalidad($localidad) {
        $this->localidad = $localidad;
    }

    function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setCondIva($condIva) {
        $this->condIva = $condIva;
    }

    function __construct() {
        $this->cuentas = new Doctrine\Common\Collections\ArrayCollection;
    }

    function tieneProvincia(&$provincia) {
        if ($this->getProvincia()) {
            return $provincia->getId() == $this->getProvincia()->getId() ? true : false;
        } else {
            return false;
        }
    }

}

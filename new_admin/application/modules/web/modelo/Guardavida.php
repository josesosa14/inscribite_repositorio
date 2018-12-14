<?php

defined("BASEPATH") OR exit("No direct script access allowed");

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Guardavida
 * 
 * @Table(name="guardavida") 
 * @Entity 
 */
class Guardavida {

    /**
     * @var integer $id
     *
     * @Column(name="gua_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean $activo
     *
     * @Column(name="gua_activo", type="boolean")
     */
    private $activo;

    /**
     * @var datetime $created_at
     *
     * @Column(name="gua_created_at", type="datetime",nullable=false)
     */
    private $created_at;

    /**
     * @var datetime $modified_at
     *
     * @Column(name="gua_modified_at", type="datetime",nullable=true)
     */
    private $modified_at;

    /**
     * @var string $nombre
     *
     * @Column(name="gua_nombre", type="string",nullable=true)
     * 
     */
    protected $nombre;

    /**
     * @var string $apellido
     *
     * @Column(name="gua_apellido", type="string",nullable=true)
     * 
     */
    protected $apellido;

    /**
     * @var integer $dni
     *
     * @Column(name="gua_dni", type="integer",nullable=true)
     * 
     */
    protected $dni;

    /**
     * @var string $domicilio
     *
     * @Column(name="gua_domicilio", type="string",nullable=true)
     * 
     */
    protected $domicilio;

    /**
     * @var string $provincia
     *
     * @Column(name="gua_provincia", type="string",nullable=true)
     * 
     */
    protected $provincia;

    /**
     * @var string $localidad
     *
     * @Column(name="gua_localidad", type="string",nullable=true)
     * 
     */
    protected $localidad;

    /**
     * @var string $codpostal
     *
     * @Column(name="gua_codpostal", type="string",nullable=true)
     * 
     */
    protected $codpostal;

    /**
     * @var string $telfijo
     *
     * @Column(name="gua_telfijo", type="string",nullable=true)
     * 
     */
    protected $telfijo;

    /**
     * @var string $telcelular
     *
     * @Column(name="gua_telcelular", type="string",nullable=true)
     * 
     */
    protected $telcelular;

    /**
     * @var string $foto
     *
     * @Column(name="gua_foto", type="string",nullable=true)
     * 
     */
    protected $foto;

    /**
     * @var string $email
     *
     * @Column(name="gua_email", type="string",nullable=true)
     * 
     */
    protected $email;

    /**
     * @var string $password
     *
     * @Column(name="gua_password", type="string",nullable=true)
     * 
     */
    protected $password;

    /**
     * @var string $nosconocio
     *
     * @Column(name="gua_nosconocio", type="string",nullable=true)
     * 
     */
    protected $nosconocio;

    /**
     * @var string $tipousuario
     *
     * @Column(name="gua_tipousuario", type="string",nullable=true)
     * 
     */
    protected $tipousuario;

    /**
     * @var Atributo[] $atributos
     * @ManyToMany(targetEntity="Atributo")
     * @JoinTable(name="guardavida_atributos",
     *      joinColumns={@JoinColumn(name="gat_gua_id", referencedColumnName="gua_id")},
     *      inverseJoinColumns={@JoinColumn(name="gat_atr_id", referencedColumnName="atr_id")}
     *      )
     */
    private $atributos;

    /**
     * @var Guardavidaatributo[] $guarda_atributos
     * @OneToMany(targetEntity="Guardavidaatributo", mappedBy="guardavida")
     */
    private $guarda_atributos;

    public function __construct() {
        $this->atributos = new ArrayCollection();
        $this->guarda_atributos = new ArrayCollection();
    }

    function getGuarda_atributos() {
        return $this->guarda_atributos;
    }

    function setGuarda_atributos($guarda_atributos) {
        $this->guarda_atributos = $guarda_atributos;
    }

    function getAtributos() {
        return $this->atributos;
    }

    function setAtributos($atributos) {
        $this->atributos = $atributos;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setActivo($activo) {
        return $this->activo = $activo;
    }

    function getActivo() {
        return $this->activo;
    }

    function setCreated_at($created_at) {
        $this->created_at = $created_at;
    }

    function getCreated_at() {
        return $this->created_at;
    }

    function setModified_at($modified_at) {
        $this->modified_at = $modified_at;
    }

    function getModified_at() {
        return $this->modified_at;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getApellido() {
        return $this->apellido;
    }

    function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    function getDni() {
        return $this->dni;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

    function getDomicilio() {
        return $this->domicilio;
    }

    function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;
    }

    function getProvincia() {
        return $this->provincia;
    }

    function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    function getLocalidad() {
        return $this->localidad;
    }

    function setLocalidad($localidad) {
        $this->localidad = $localidad;
    }

    function getCodpostal() {
        return $this->codpostal;
    }

    function setCodpostal($codpostal) {
        $this->codpostal = $codpostal;
    }

    function getTelfijo() {
        return $this->telfijo;
    }

    function setTelfijo($telfijo) {
        $this->telfijo = $telfijo;
    }

    function getTelcelular() {
        return $this->telcelular;
    }

    function setTelcelular($telcelular) {
        $this->telcelular = $telcelular;
    }

    function getFoto() {
        return $this->foto;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getPassword() {
        return $this->password;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function getNosconocio() {
        return $this->nosconocio;
    }

    function setNosconocio($nosconocio) {
        $this->nosconocio = $nosconocio;
    }

    function getTipousuario() {
        return $this->tipousuario;
    }

    function setTipousuario($tipousuario) {
        $this->tipousuario = $tipousuario;
    }

    public function getDatosArray() {
        $array = array("id" => $this->getId(),
            "nombre" => $this->getNombre(),
            "apellido" => $this->getApellido(),
            "dni" => $this->getDni(),
            "domicilio" => $this->getDomicilio(),
            "provincia" => $this->getProvincia(),
            "localidad" => $this->getLocalidad(),
            "codpostal" => $this->getCodpostal(),
            "telfijo" => $this->getTelfijo(),
            "telcelular" => $this->getTelcelular(),
            "foto" => $this->getFoto(),
            "email" => $this->getEmail(),
            "password" => $this->getPassword(),
            "nosconocio" => $this->getNosconocio(),
            "tipousuario" => $this->getTipousuario(),
            "acciones" => $this->getAcciones());
        return $array;
    }

    function getAcciones() {
        return '<a class="edit ml10" href="' . base_url("admin-guardavida") . '/' . $this->getId() . '" title="Editar">
            <i class="fa fa-search"></i>
            </a> &nbsp;&nbsp;<a class="edit ml10" href="' . base_url("admin-guardavida/borrar/" . $this->getId()) . '" title="' . (!$this->getActivo() ? "Eliminar" : "Recuperar") . '">
            <i class="glyphicon glyphicon-' . (!$this->getActivo() ? "trash" : "check") . '"></i>
            </a> ';
    }

    function getAtributoById($atr_id) {
        $response = "";
        foreach ($this->getGuarda_atributos() as $atributo) {
            if ($atr_id == $atributo->getAtributo()->getId()) {
                $response= $atributo->getValor();
                break;
            }
        }
        return $response;
    }
    
}

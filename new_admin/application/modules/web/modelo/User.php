<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * User
 * 
 * @Table(name="users") 
 * @Entity 
 */
class User {

    /**
     * @var integer $id
     *
     * @Column(name="usr_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $nombre
     *
     * @Column(name="usr_nombre", type="string" ,length=150 )
     * 
     */
    protected $nombre;

    /**
     * @var string $fbid
     *
     * @Column(name="usr_fbid", type="string" ,length=200 ,nullable=true)
     * 
     */
    protected $fbid;

    /**
     * @var string $fbuser
     *
     * @Column(name="usr_fbuser", type="string" ,length=200 ,nullable=true)
     * 
     */
    protected $fbuser;

    /**
     * @var string $email
     *
     * @Column(name="usr_email", type="string" ,length=150 ,nullable=true)
     * 
     */
    protected $email;

    /**
     * @var string $clave
     *
     * @Column(name="usr_clave", type="string" ,length=200 ,nullable=true)
     * 
     */
    protected $clave;

    /**
     * @var string $telefono
     *
     * @Column(name="usr_telefono", type="string" ,length=80 ,nullable=true)
     * 
     */
    protected $telefono;

    /**
     * @var string $direccion
     *
     * @Column(name="usr_direccion", type="string" ,length=200 ,nullable=true)
     * 
     */
    protected $direccion;

    /**
     * @var string $barrio
     *
     * @Column(name="usr_barrio", type="string" ,length=200 ,nullable=true)
     * 
     */
    protected $barrio;

    /**
     * @var string $localidad
     *
     * @Column(name="usr_localidad", type="string" ,length=200 ,nullable=true)
     * 
     */
    protected $localidad;

    /**
     * @var string $horario_entrega
     *
     * @Column(name="usr_horario_entrega", type="string" ,length=100 ,nullable=true)
     * 
     */
    protected $horario_entrega;

    /**
     * @var string $direccion_secundaria
     *
     * @Column(name="usr_direccion_secundaria", type="string" ,length=200 ,nullable=true)
     * 
     */
    protected $direccion_secundaria;

    /**
     * @var string $fecha_in
     *
     * @Column(name="usr_fecha_in", type="string" ,length=50 ,nullable=true)
     * 
     */
    protected $fecha_in;

    /**
     * @var integer $cant_logeo
     *
     * @Column(name="usr_cant_logeo", type="integer" ,length=4 ,nullable=true)
     * 
     */
    protected $cant_logeo;

    /**
     * @var string $last_logeo
     *
     * @Column(name="usr_last_login", type="string" ,length=50 ,nullable=true)
     * 
     */
    protected $last_logeo;

    /**
     * @var string $activo
     *
     * @Column(name="usr_activo", type="string"  ,nullable=true)
     * 
     */
    protected $activo;

    /**
     * @OneToMany(targetEntity="Vinoconsumido", mappedBy="usuario")
     * */
    private $vinos_consumidos;

    function __construct() {
        $this->vinos_consumidos = new Doctrine\Common\Collections\ArrayCollection;
    }

    function getVinos_consumidos() {
        return $this->vinos_consumidos;
    }

    function setVinos_consumidos($vinos_consumidos) {
        $this->vinos_consumidos = $vinos_consumidos;
    }

    function getId() {
        return $this->id;
    }

    function setId($usr_id) {
        $this->id = $usr_id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getFbid() {
        return $this->fbid;
    }

    function setFbid($fbid) {
        $this->fbid = $fbid;
    }

    function getFbuser() {
        return $this->fbuser;
    }

    function setFbuser($fbuser) {
        $this->fbuser = $fbuser;
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getClave() {
        return $this->clave;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function getBarrio() {
        return $this->barrio;
    }

    function setBarrio($barrio) {
        $this->barrio = $barrio;
    }

    function getLocalidad() {
        return $this->localidad;
    }

    function setLocalidad($localidad) {
        $this->localidad = $localidad;
    }

    function getHorario_entrega() {
        return $this->horario_entrega;
    }

    function setHorario_entrega($horario_entrega) {
        $this->horario_entrega = $horario_entrega;
    }

    function getDireccion_secundaria() {
        return $this->direccion_secundaria;
    }

    function setDireccion_secundaria($direccion_secundaria) {
        $this->direccion_secundaria = $direccion_secundaria;
    }

    function getFecha_in() {
        return $this->fecha_in;
    }

    function setFecha_in($fecha_in) {
        $this->fecha_in = $fecha_in;
    }

    function getCant_logeo() {
        return $this->cant_logeo;
    }

    function setCant_logeo($cant_logeo) {
        $this->cant_logeo = $cant_logeo;
    }

    function getLast_logeo() {
        return $this->last_logeo;
    }

    function setLast_logeo($last_logeo) {
        $this->last_logeo = $last_logeo;
    }

    function getActivo() {
        return $this->activo;
    }

    function setActivo($activo) {
        $this->activo = $activo;
    }

    public function getDatosArray() {
        $array = array("id" => $this->getId(),
            "usr_nombre" => $this->getNombre(),
            "usr_fbid" => $this->getFbid(),
            "usr_fbuser" => $this->getFbuser(),
            "usr_email" => $this->getEmail(),
            "usr_clave" => $this->getClave(),
            "usr_telefono" => $this->getTelefono(),
            "usr_direccion" => $this->getDireccion(),
            "usr_direccion_completa" => $this->getDireccion() . ' ' . $this->getBarrio() . ' ' . $this->getLocalidad() . ' Horario:' . $this->getHorario_entrega(),
            "usr_barrio" => $this->getBarrio(),
            "usr_localidad" => $this->getLocalidad(),
            "usr_horario_entrega" => $this->getHorario_entrega(),
            "usr_direccion_secundaria" => $this->getDireccion_secundaria(),
            "usr_fecha_in" => $this->getFecha_in(),
            "usr_cant_logeo" => $this->getCant_logeo(),
            "usr_last_logeo" => $this->getLast_logeo(),
            "usr_activo" => $this->getActivo());
        return $array;
    }

}

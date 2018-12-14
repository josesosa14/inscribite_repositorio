<?php

defined("BASEPATH") OR exit("No direct script access allowed");

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Listadifusion
 * 
 * @Table(name="listadifusion") 
 * @Entity 
 */
class Listadifusion {

    /**
     * @var integer $id
     *
     * @Column(name="lis_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $nombre
     *
     * @Column(name="lis_nombre", type="string" ,length=200 )
     * 
     */
    protected $nombre;

    /**
     * @var datetime $fecha
     *
     * @Column(name="lis_fecha", type="datetime")
     * 
     */
    protected $fecha;

    /** @var Usuario $usuario
     * @OneToOne(targetEntity="Usuario")
     * @JoinColumn(name="lis_usuario", referencedColumnName="usuario_id")
     * */
    private $usuario;

    /** @var Listadifusionrenglones[] $emails
     * @OneToMany(targetEntity="Listadifusionrenglones", mappedBy="lista")
     */
    private $emails;

    public function __construct() {
        $this->emails = new ArrayCollection();
    }

    function getEmails() {
        return $this->emails;
    }

    function getId() {
        return $this->id;
    }

    function setId($lis_id) {
        $this->id = $lis_id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getDatosArray() {
        $array = array("id" => $this->getId(),
            "lis_nombre" => $this->getNombre(),
            "lis_fecha" => $this->getFecha()->format("d/m/Y"),
            "lis_usuario" => $this->getUsuario()->getNombreUsuario());
        return $array;
    }

}

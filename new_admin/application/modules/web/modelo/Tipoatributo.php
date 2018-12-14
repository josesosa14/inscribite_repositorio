<?php

defined("BASEPATH") OR exit("No direct script access allowed");

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tipoatributo
 * 
 * @Table(name="tipoatributo") 
 * @Entity 
 */
class Tipoatributo {

    /**
     * @var integer $id
     *
     * @Column(name="tip_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean $activo
     *
     * @Column(name="tip_activo", type="boolean")
     */
    private $activo;

    /**
     * @var datetime $created_at
     *
     * @Column(name="tip_created_at", type="datetime",nullable=false)
     */
    private $created_at;

    /**
     * @var datetime $modified_at
     *
     * @Column(name="tip_modified_at", type="datetime",nullable=true)
     */
    private $modified_at;

    /**
     * @var string $nombre
     *
     * @Column(name="tip_nombre", type="string",nullable=true)
     * 
     */
    protected $nombre;

    /**
     * @var Atributo[] $atributos
     * @OneToMany(targetEntity="Atributo", mappedBy="tipoAtributo")
     */
    private $atributos;

    public function __construct() {
        $this->atributos = new ArrayCollection();
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

    public function getDatosArray() {
        $array = array("id" => $this->getId(),
            "nombre" => $this->getNombre(),
            "acciones" => $this->getAcciones());
        return $array;
    }

    function getAcciones() {
        return '<a class="edit ml10" href="' . base_url("admin-tipoatributo") . '/' . $this->getId() . '" title="Editar">
            <i class="fa fa-search"></i>
            </a> &nbsp;&nbsp;<a class="edit ml10" href="' . base_url("admin-tipoatributo/borrar/" . $this->getId()) . '" title="' . ($this->getActivo() ? "Eliminar" : "Recuperar") . '">
            <i class="glyphicon glyphicon-' . ($this->getActivo() ? "trash" : "check") . '"></i>
            </a> ';
    }

}

<?php

defined("BASEPATH") OR exit("No direct script access allowed");

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Atributo
 * 
 * @Table(name="atributo") 
 * @Entity 
 */
class Atributo {

    /**
     * @var integer $id
     *
     * @Column(name="atr_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean $activo
     *
     * @Column(name="atr_activo", type="boolean")
     */
    private $activo;

    /**
     * @var datetime $created_at
     *
     * @Column(name="atr_created_at", type="datetime",nullable=false)
     */
    private $created_at;

    /**
     * @var datetime $modified_at
     *
     * @Column(name="atr_modified_at", type="datetime",nullable=true)
     */
    private $modified_at;

    /**
     * @var string $nombre
     *
     * @Column(name="atr_nombre", type="string",nullable=true)
     * 
     */
    protected $nombre;

    /**
     * @var Tipoatributo $tipoAtributo

     * @OneToOne(targetEntity="Tipoatributo")

     * @JoinColumn(name="atr_tip_id", referencedColumnName="tip_id")

     * */
    private $tipoAtributo;

    function getTipoAtributo() {
        return $this->tipoAtributo;
    }

    function setTipoAtributo($tipoAtributo) {
        $this->tipoAtributo = $tipoAtributo;
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
            "tipo" => $this->getTipoAtributo()->getNombre(),
            "nombre" => $this->getNombre(),
            "acciones" => $this->getAcciones());
        return $array;
    }

    function getAcciones() {
        return '<a class="edit ml10" href="' . base_url("admin-atributo") . '/' . $this->getId() . '" title="Editar">
            <i class="fa fa-search"></i>
            </a> &nbsp;&nbsp;<a class="edit ml10" href="' . base_url("admin-atributo/borrar/" . $this->getId()) . '" title="' . (!$this->getActivo() ? "Eliminar" : "Recuperar") . '">
            <i class="glyphicon glyphicon-' . (!$this->getActivo() ? "trash" : "check") . '"></i>
            </a> ';
    }

}

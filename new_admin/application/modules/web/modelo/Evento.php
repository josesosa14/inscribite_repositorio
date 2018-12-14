<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Pago
 *
 * @Table(name="inscribite_eventos")
 * @Entity
 */
class Evento {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var $codigo
     *
     * @Column(name="codigo", type="integer")
     */
    private $codigo;

    /**
     * @var $ver
     *
     * @Column(name="ver", type="integer")
     */
    private $ver;

    /**
     * @var $nombre
     *
     * @Column(name="nombre", type="string")
     */
    private $nombre;

    /**
     * @var $empresa
     *
     * @Column(name="empresa", type="string")
     */
    private $empresa;

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getVer() {
        return $this->ver;
    }

    function setVer($ver) {
        $this->ver = $ver;
    }

    function getId() {
        return $this->id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

}

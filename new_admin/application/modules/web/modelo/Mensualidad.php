<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Mensualidad
 *
 * @Table(name="mensualidades")
 * @Entity
 */
class Mensualidad {

    /**
     * @var integer $id
     *
     * @Column(name="men_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var $nombre
     *
     * @Column(name="men_nombre", type="string")
     */
    private $nombre;

    /**
     * @var $codigo
     *
     * @Column(name="men_codigo", type="string")
     */
    private $codigo;

    /**
     * @OneToOne(targetEntity="Empresa")
     * @JoinColumn(name="men_empresa", referencedColumnName="emp_id")
     */
    private $empresa;

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

}

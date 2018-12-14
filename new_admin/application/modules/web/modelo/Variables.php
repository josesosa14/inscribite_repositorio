<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Variables
 * 
 * @Table(name="variables") 
 * @Entity 
 */
class Variables {

    /**
     * @var integer $id
     *
     * @Column(name="var_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var $porc_comision_rp
     *
     * @Column(name="var_porc_comision_rp", type="float")
     * 
     */
    protected $porc_comision_rp;

    /**
     * @var $porc_comision_pf
     *
     * @Column(name="var_porc_comision_pf", type="float")
     * 
     */
    protected $porc_comision_pf;

    /**
     * @var $porc_comision_pmc
     *
     * @Column(name="var_porc_comision_pmc", type="float")
     * 
     */
    protected $porc_comision_pmc;

    /**
     * @var $porc_efectivo_rp
     *
     * @Column(name="var_porc_efectivo_rp", type="float")
     * 
     */
    protected $porc_efectivo_rp;

    /**
     * @var $porc_efectivo_pf
     *
     * @Column(name="var_porc_efectivo_pf", type="float")
     * 
     */
    protected $porc_efectivo_pf;

    /**
     * @var $porc_efectivo_pmc
     *
     * @Column(name="var_porc_efectivo_pmc", type="float")
     * 
     */
    protected $porc_efectivo_pmc;

    /**
     * @var $porc_iva
     *
     * @Column(name="var_porc_iva", type="float")
     * 
     */
    protected $porc_iva;

    /**
     * @var $comision_cliente
     *
     * @Column(name="var_comision_cliente", type="float")
     * 
     */
    protected $comision_cliente;

    function getComision_cliente() {
        return $this->comision_cliente;
    }

    function setComision_cliente($comision_cliente) {
        $this->comision_cliente = $comision_cliente;
    }

    function getId() {
        return $this->id;
    }

    function setId($var_id) {
        $this->id = $var_id;
    }

    function getPorc_comision_rp() {
        return $this->porc_comision_rp;
    }

    function setPorc_comision_rp($porc_comision_rp) {
        $this->porc_comision_rp = $porc_comision_rp;
    }

    function getPorc_comision_pf() {
        return $this->porc_comision_pf;
    }

    function setPorc_comision_pf($porc_comision_pf) {
        $this->porc_comision_pf = $porc_comision_pf;
    }

    function getPorc_comision_pmc() {
        return $this->porc_comision_pmc;
    }

    function setPorc_comision_pmc($porc_comision_pmc) {
        $this->porc_comision_pmc = $porc_comision_pmc;
    }

    function getPorc_efectivo_rp() {
        return $this->porc_efectivo_rp;
    }

    function setPorc_efectivo_rp($porc_efectivo_rp) {
        $this->porc_efectivo_rp = $porc_efectivo_rp;
    }

    function getPorc_efectivo_pf() {
        return $this->porc_efectivo_pf;
    }

    function setPorc_efectivo_pf($porc_efectivo_pf) {
        $this->porc_efectivo_pf = $porc_efectivo_pf;
    }

    function getPorc_efectivo_pmc() {
        return $this->porc_efectivo_pmc;
    }

    function setPorc_efectivo_pmc($porc_efectivo_pmc) {
        $this->porc_efectivo_pmc = $porc_efectivo_pmc;
    }

    function getPorc_iva() {
        return $this->porc_iva;
    }

    function getIvaImporte() {
        return $this->getPorc_iva() + 1;
    }

    function setPorc_iva($porc_iva) {
        $this->porc_iva = $porc_iva;
    }

    public function getDatosArray() {
        $array = array("id" => $this->getId(),
            "var_porc_comision_rp" => $this->getPorc_comision_rp(),
            "var_porc_comision_pf" => $this->getPorc_comision_pf(),
            "var_porc_comision_pmc" => $this->getPorc_comision_pmc(),
            "var_porc_efectivo_rp" => $this->getPorc_efectivo_rp(),
            "var_porc_efectivo_pf" => $this->getPorc_efectivo_pf(),
            "var_porc_efectivo_pmc" => $this->getPorc_efectivo_pmc(),
            "var_porc_iva" => $this->getPorc_iva());
        return $array;
    }

}

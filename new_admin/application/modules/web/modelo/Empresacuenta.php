<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Empresacuenta
 * 
 * @Table(name="empresa_banco") 
 * @Entity 
 */
class Empresacuenta {

    /**
     * @var integer $id
     *
     * @Column(name="empb_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $cbu
     *
     * @Column(name="empb_cbu", type="string" ,length=35 )
     * 
     */
    protected $cbu;

    /**
     * @var string $titular
     *
     * @Column(name="empb_titular", type="string" ,length=150 )
     * 
     */
    protected $titular;

    /**
     * @var string $tipo_cuenta
     *
     * @Column(name="empb_tipo_cuenta", type="string" ,length=150 )
     * 
     */
    protected $tipo_cuenta;

    /**
     * @var string $nro_cuenta
     *
     * @Column(name="empb_nro_cuenta", type="string" ,length=20 )
     * 
     */
    protected $nro_cuenta;

    /**
     * @var integer $cuit
     *
     * @Column(name="empb_cuit_titular", type="integer" ,length=20 )
     * 
     */
    protected $cuit;

    /**
     * @OneToOne(targetEntity="Empresa")
     * @JoinColumn(name="empb_emp_id", referencedColumnName="emp_id")
     * */
    private $empresa;

    /**
     * @var boolean $activa
     *
     * @Column(name="empb_activa", type="boolean"  )
     * 
     */
    protected $activa;

    /**
     * @var integer $preferente
     *
     * @Column(name="empb_preferente", type="integer"  )
     * 
     */
    protected $default;

    /**
     * @var string $banco
     *
     * @Column(name="empb_nombre", type="string" ,length=150 )
     * 
     */
    protected $banco;
    
    function getDefault() {
        return $this->default;
    }

    function setDefault($default) {
        $this->default = $default;
    }

    
    function getId() {
        return $this->id;
    }

    function getCbu() {
        return $this->cbu;
    }

    function getTitular() {
        return $this->titular;
    }

    function getTipo_cuenta() {
        return $this->tipo_cuenta;
    }

    function getNro_cuenta() {
        return $this->nro_cuenta;
    }

    function getCuit() {
        return $this->cuit;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function getBanco() {
        return $this->banco;
    }

    function getActiva() {
        return $this->activa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCbu($cbu) {
        $this->cbu = $cbu;
    }

    function setTitular($titular) {
        $this->titular = $titular;
    }

    function setTipo_cuenta($tipo_cuenta) {
        $this->tipo_cuenta = $tipo_cuenta;
    }

    function setNro_cuenta($nro_cuenta) {
        $this->nro_cuenta = $nro_cuenta;
    }

    function setCuit($cuit) {
        $this->cuit = $cuit;
    }

    function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setActiva($activa) {
        $this->activa = $activa;
    }

    public function getDatosArray() {
        $array = array("id" => $this->getId(),
            "emp_cbu" => $this->getCbu(),
            "emp_nro_cuenta" => $this->getNro_cuenta(),
            "emp_cuit" => $this->getCuit(),
            "emp_empresa" => $this->getEmpresa()->getNombre(),
            "emp_tipo_cuenta" => $this->getTipo_cuenta(),
            "emp_activa" => $this->getActiva());
        return $array;
    }

}

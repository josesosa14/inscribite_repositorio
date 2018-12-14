<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Pago
 *
 * @Table(name="pago")
 * @Entity
 */
class Pago {

    /**
     * @var integer $id
     *
     * @Column(name="pag_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var $fechaCreacion
     *
     * @Column(name="pag_fecha_in", type="datetime", length=120, nullable=true)
     */
    private $fechaCreacion;

    /**
     * @OneToOne(targetEntity="Empresa")
     * @JoinColumn(name="pag_emp_id", referencedColumnName="emp_id")
     */
    private $empresa;

    /**
     * @OneToOne(targetEntity="Evento")
     * @JoinColumn(name="pag_evt_id", referencedColumnName="id")
     */
    private $evento;

    /**
     * @OneToOne(targetEntity="Mensualidad")
     * @JoinColumn(name="pag_men_id", referencedColumnName="men_id")
     */
    private $mensualidad;

    /**
     * @var $fechaEjecucion
     *
     * @Column(name="pag_fecha", type="datetime", length=120, nullable=true)
     */
    private $fechaEjecucion;

    /**
     * @var $fecha_pagado
     *
     * @Column(name="pag_pagado_fecha", type="datetime")
     */
    private $fecha_pagado;

    /**
     * @var $tipo
     *
     * @Column(name="pag_tipo", type="string")
     */
    private $tipo;

    /**
     * @OneToMany(targetEntity="Pago_renglones", mappedBy="pago", cascade={"persist", "remove"}, orphanRemoval=true)
     * */
    private $renglones;

    /**
     * @OneToOne(targetEntity="Liquidacion")
     * @JoinColumn(name="pag_liq_id", referencedColumnName="liq_id")
     */
    private $liquidacion;

    /**
     * @var $comision_cliente
     *
     * @Column(name="pag_comision", type="float")
     * 
     */
    protected $comision_cliente;

    function getComisionCliente() {
        return $this->comision_cliente;
    }

    function setComisionCliente($comision) {
        $this->comision_cliente = $comision;
    }

    function getMensualidad() {
        return $this->mensualidad;
    }

    function setMensualidad($mensualidad) {
        $this->mensualidad = $mensualidad;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getEvento() {
        return $this->evento;
    }

    function setEvento($evento) {
        $this->evento = $evento;
    }

    function getFecha_pagado() {
        return $this->fecha_pagado;
    }

    function setFecha_pagado($fecha_pagado) {
        $this->fecha_pagado = $fecha_pagado;
    }

    public function __construct() {
        $this->renglones = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function getFechaEjecucion() {
        return $this->fechaEjecucion;
    }

    function getRenglones() {
        return $this->renglones;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    function setFechaEjecucion($fechaEjecucion) {
        $this->fechaEjecucion = $fechaEjecucion;
    }

    function setRenglones($renglones) {
        $this->renglones = $renglones;
    }

    function totalPago() {
        $total = 0.00;
        foreach ($this->getRenglones() as $renglon) {
            $total = $total + $renglon->getImporte();
        }
        return $total;
    }

    public function getDatosArray() {
        $acciones = '<a  class="editarPago" href="editar_pago/' . $this->getId() . '"><i class="fa fa-edit large-icon"></i></a>';
        $acciones .= '<a  class="" href="#" onclick = "return borrarPago(' . $this->getId() . ');"><i class="fa fa-trash-o large-icon"></i></a>';

        $array = array("pag_id" => $this->getId(),
            "pag_emp_id" => $this->getEmpresa() ? $this->getEmpresa()->getId() : "sin empresa",
            "pag_emp_nombre" => $this->getEmpresa()->getNombre(),
            "pag_evento" => $this->getEvento() ? $this->getEvento()->getNombre() : "",
            "pag_mensualidad" => $this->getMensualidad() ? $this->getMensualidad()->getNombre() : "",
            "pag_total" => $this->getImporteNeto(),
            "pag_fecha" => $this->getFechaEjecucion()->format("d/m/Y"),
            "pag_acciones" => $acciones
        );
        return $array;
    }

    function getImporteNeto() {
        return round($this->totalPago() - $this->getComision(), 2);
    }

    function getComision() {
        return $this->getImporteComision() + $this->getIVA();
    }

    function getImporteComision() {
        return $this->totalPago() * $this->getComisionCliente();
    }

    function getIVA() {
        return $this->getImporteComision() * 0.21;
    }

    function getCantidadRegistros(){
        return count($this->getRenglones());
    }
}

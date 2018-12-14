<?php

defined("BASEPATH") OR exit("No direct script access allowed");

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Liquidacion
 * 
 * @Table(name="liquidacion") 
 * @Entity 
 */
class Liquidacion {

    /**
     * @var integer $id
     *
     * @Column(name="liq_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var $fecha
     *
     * @Column(name="liq_fecha", type="date")
     * 
     */
    protected $fecha;

    /**
     * @var $fecha_pagada
     *
     * @Column(name="liq_fecha_pagada", type="date")
     * 
     */
    protected $fecha_pagada;

    /**
     * @var $fecha_visible_cliente
     *
     * @Column(name="liq_fecha_visible_cliente", type="date")
     * 
     */
    protected $fecha_visible_cliente;

    /**
     * @var $fecha_hasta
     *
     * @Column(name="liq_fecha_hasta", type="date")
     * 
     */
    protected $fecha_hasta;

    /**
     * @var Empresa $cliente
     * @OneToOne(targetEntity="Empresa")
     * @JoinColumn(name="liq_emp_id", referencedColumnName="emp_id")
     */
    private $cliente;

    /**
     * @var Evento $evento
     * @OneToOne(targetEntity="Evento")
     * @JoinColumn(name="liq_evt_id", referencedColumnName="id")
     */
    private $evento;

    /**
     * @var Mensualidad $mensualidad
     * @OneToOne(targetEntity="Mensualidad")
     * @JoinColumn(name="liq_men_id", referencedColumnName="men_id")
     */
    private $mensualidad;

    /**
     * @OneToMany(targetEntity="Pago", mappedBy="liquidacion")
     */
    private $pagos;

    /**
     * @var Liquidacioncuentas[] $cuentas
     * @OneToMany(targetEntity="Liquidacioncuentas", mappedBy="liquidacion")
     */
    private $cuentas;

    function getCuentas() {
        return $this->cuentas;
    }

    function setCuentas(array $cuentas) {
        $this->cuentas = $cuentas;
    }

    public function __construct() {
        $this->cuentas = new ArrayCollection();
    }

    function getMensualidad() {
        return $this->mensualidad;
    }

    function setMensualidad($mensualidad) {
        $this->mensualidad = $mensualidad;
    }

    function getPagos() {
        return $this->pagos;
    }

    function setPagos($pagos) {
        $this->pagos = $pagos;
    }

    function getId() {
        return $this->id;
    }

    function setId($liq_id) {
        $this->id = $liq_id;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function getFecha_pagada() {
        return $this->fecha_pagada;
    }

    function setFecha_pagada($fecha_pagada) {
        $this->fecha_pagada = $fecha_pagada;
    }

    function getFecha_visible_cliente() {
        return $this->fecha_visible_cliente;
    }

    function setFecha_visible_cliente($fecha_visible_cliente) {
        $this->fecha_visible_cliente = $fecha_visible_cliente;
    }

    function getFecha_hasta() {
        return $this->fecha_hasta;
    }

    function setFecha_hasta($fecha_hasta) {
        $this->fecha_hasta = $fecha_hasta;
    }

    function getCliente() {
        return $this->cliente;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function getEvento() {
        return $this->evento;
    }

    function getEventoMostrar() {
        return $this->getEvento() ? $this->getEvento()->getNombre() : $this->getMensualidad()->getNombre();
    }

    function setEvento($evento) {
        $this->evento = $evento;
    }

    public function getDatosArray() {
        $array = array("id" => $this->getId(),
            "liq_fecha" => $this->getFecha()->format("d/m/Y"),
            "liq_fecha_pagada" => $this->getFecha_pagada(),
            "liq_periodo" => "Hasta " . $this->getFecha_hasta()->format("d/m/Y"),
            "liq_fecha_visible_cliente" => $this->getFecha_visible_cliente(),
            "liq_fecha_hasta" => $this->getFecha_hasta(),
            "liq_cliente" => $this->getCliente()->getNombre(),
            "liq_cant_registros" => $this->getTotalRegistros(),
            "liq_total" => $this->getTotal(),
            "liq_codigo" => $this->getEvento() ? $this->getEvento()->getCodigo() : ($this->getMensualidad()?$this->getMensualidad()->getCodigo():"no encontró código"),
            "liq_acciones" => $this->getAcciones(),
            "liq_evento" => $this->getEvento() ? "Evento:" . $this->getEvento()->getNombre() : ($this->getMensualidad()?"Mensualidad:" . $this->getMensualidad()->getNombre():"no encontró código"));

        return $array;
    }

    private function getAcciones() {
        if (!$_SESSION["desde_inscribite"]) {
            $acciones = '<a  class="ver"  href="renglonePagosLiquidacion/' . $this->getId() . '" title="Cuentas de pago"><i class="fa fa-search large-icon"></i></a>';
            $acciones .= '<a  class="ver"  href="reportePagosLiquidacion/' . $this->getId() . '" title="Renglones"><i class="glyphicon glyphicon-book large-icon"></i></a>';
            if (!$this->getFecha_pagada()) {
                $acciones .= '<a  class="delete"  href="admin-liquidacion/borrar/' . $this->getId() . '"><i class="fa fa-trash-o large-icon"></i></a>';
                $acciones .= '<a title="pagar" class="" href="admin-liquidacion/pagar/' . $this->getId() . '"><i class="fa fa-dollar large-icon"></i></a>';
            }
        } else {
            $acciones = '<a  class="ver"  href="http://www.inscribiteonline.com.ar/empresas/cuentas_liquidacion.php?liq_id=' . $this->getId() . '" title="Cuentas de pago"><i class="fa fa-search large-icon"></i></a>';
        }
        //$acciones .= '<a title="reporte" class="" href="admin-liquidacion/reporte/' . $this->getId() . '"><i class="glyphicon glyphicon-book large-icon"></i></a>';
        return $acciones;
    }

    function getTotal() {
        /* @var $pago Pago */
        $total = 0.00;
        if ($this->getPagos()) {
            foreach ($this->getPagos() as $pago) {
                $total = $total + $pago->getImporteNeto();
            }
        }
        return $total;
    }

    function getTotalCobrado() {
        /* @var $pago Pago */
        $total = 0.00;
        foreach ($this->getPagos() as $pago) {
            $total = $total + $pago->totalPago();
        }
        return $total;
    }

    function getIVA() {
        /* @var $pago Pago */
        $total = 0.00;
        foreach ($this->getPagos() as $pago) {
            $total = $total + $pago->getIVA();
        }
        return $total;
    }

    function getComision() {
        /* @var $pago Pago */
        $total = 0.00;
        foreach ($this->getPagos() as $pago) {
            $total = $total + $pago->getImporteComision();
        }
        return $total;
    }

    function getTotalRegistros() {
        /* @var $pago Pago */
        $total = 0.00;
        foreach ($this->getPagos() as $pago) {
            $total = $total + $pago->getCantidadRegistros();
        }
        return $total;
    }

}

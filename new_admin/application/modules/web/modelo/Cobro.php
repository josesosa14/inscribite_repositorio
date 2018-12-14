<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Cobro
 * 
 * @Table(name="cobro") 
 * @Entity 
 */
class Cobro {

    /**
     * @var integer $id
     *
     * @Column(name="cob_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var $fecha
     *
     * @Column(name="cob_fecha", type="date")
     * 
     */
    protected $fecha;

    /**
     * @var string $adjunto
     *
     * @Column(name="cob_adjunto", type="string" ,length=150 ,nullable=true)
     * 
     */
    protected $adjunto;

    /**
     * @var integer $cantregistros
     *
     * @Column(name="cob_cantregistros", type="integer")
     * 
     */
    protected $cantregistros;

    /**
     * @var $importe
     *
     * @Column(name="cob_importe", type="decimal")
     * 
     */
    protected $importe;

    /**
     * @var $neto
     *
     * @Column(name="cob_neto", type="decimal")
     * 
     */
    protected $neto;

    /**
     * @var $iva
     *
     * @Column(name="cob_iva", type="decimal")
     * 
     */
    protected $iva;

    /**
     * @var $comisiones
     *
     * @Column(name="cob_comisiones", type="decimal")
     * 
     */
    protected $comisiones;

    /**
     * @var $retenciones
     *
     * @Column(name="cob_retenciones", type="decimal")
     * 
     */
    protected $retenciones;

    /**
     * @var $ajustes
     *
     * @Column(name="cob_ajustes", type="decimal")
     * 
     */
    protected $ajustes;

    /**
     * @var $cant_pagos
     *
     * @Column(name="cob_cant_pagos", type="integer")
     * 
     */
    protected $cant_pagos;

    /**
     * @var string $mediopago
     *
     * @Column(name="cob_med_tipo", type="string" ,length=30 )
     * 
     */
    protected $mediopago;

    /**
     * @var $liquidado
     *
     * @Column(name="cob_pagado", type="boolean")
     * 
     */
    protected $liquidado;

    /**
     * @ManyToMany(targetEntity="Decodificado_renglones")
     * @JoinTable(name="cobro_renglones",
     *      joinColumns={@JoinColumn(name="cor_cob_id", referencedColumnName="cob_id")},
     *      inverseJoinColumns={@JoinColumn(name="cor_dec_id", referencedColumnName="dec_id")}
     *      )
     */
    private $renglones;

    /**
     * @var $porc_comision
     *
     * @Column(name="cob_porc_comision", type="float")
     * 
     */
    protected $porc_comision;

    /**
     * @var $porc_efectivo
     *
     * @Column(name="cob_porc_efectivo", type="float")
     * 
     */
    protected $porc_efectivo;

    function getPorc_comision() {
        return $this->porc_comision;
    }

    function getPorc_efectivo() {
        return $this->porc_efectivo;
    }

    function setPorc_comision($porc_comision) {
        $this->porc_comision = $porc_comision;
    }

    function setPorc_efectivo($porc_efectivo) {
        $this->porc_efectivo = $porc_efectivo;
    }

    function getDiferencia() {
        /* @var $dec_renglon Decodificado_renglones */
        $total = 0.00;
        foreach ($this->getRenglones() as $dec_renglon) {
            $total = $total + $dec_renglon->getImporte();
        }
        return ($total - $this->getImporte());
    }

    function getIva() {
        return $this->iva;
    }

    function getComisiones() {
        return $this->comisiones;
    }

    function setIva($iva) {
        $this->iva = $iva;
    }

    function setNeto($neto) {
        $this->neto = $neto;
    }

    function getNeto() {
        return $this->neto;
    }

    function setComisiones($comisiones) {
        $this->comisiones = $comisiones;
    }

    function getRenglones() {
        return $this->renglones;
    }

    public function __construct() {
        $this->renglones = new Doctrine\Common\Collections\ArrayCollection;
    }

    function getLiquidado() {
        return $this->liquidado;
    }

    function setLiquidado($liquidado) {
        $this->liquidado = $liquidado;
    }

    function getId() {
        return $this->id;
    }

    function setId($cob_id) {
        $this->id = $cob_id;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function getAdjunto() {
        return $this->adjunto;
    }

    function setAdjunto($adjunto) {
        $this->adjunto = $adjunto;
    }

    function getCantregistros() {
        return $this->cantregistros;
    }

    function setCantregistros($cantregistros) {
        $this->cantregistros = $cantregistros;
    }

    function getImporte() {
        return $this->importe;
    }

    function setImporte($importe) {
        $this->importe = $importe;
    }

    function getRetenciones() {
        return $this->retenciones;
    }

    function setRetenciones($retenciones) {
        $this->retenciones = $retenciones;
    }

    function getAjustes() {
        return $this->ajustes;
    }

    function setAjustes($ajustes) {
        $this->ajustes = $ajustes;
    }

    function getMediopago() {
        return $this->mediopago;
    }

    function setMediopago($mediopago) {
        $this->mediopago = $mediopago;
    }

    public function getDatosArray() {
        $acciones = '<a class="delete" href="borrarcobro/' . $this->getId() . '" title="Eliminar"><i class="glyphicon glyphicon-trash large-icon"></i></a><a  class="reporte" href="xls_cobro_renglones/' . $this->getId() . '" title="Reporte"><i class="glyphicon glyphicon-book large-icon"></i></a>';
        //if (!$this->getCant_pagos()) {
        $acciones .= '<a title="Generar pagos" class="" href="admin-cobro/generaPagos/' . $this->getId() . '"><i class="fa fa-dollar large-icon"></i></a>';
        //}
        $array = array("id" => $this->getId(),
            "cob_fecha" => $this->getFecha()->format("d/m/Y"),
            "cob_adjunto" => $this->getAdjunto(),
            "cob_cantregistros" => $this->muestraCantidadRegistros(),
            "cob_importe" => round($this->getImporte()),
            "cob_iva" => $this->getIva(),
            "cob_comisiones" => $this->getComisiones(),
            "cob_neto" => $this->getNeto(),
            "cob_diferencia" => round($this->getDiferencia()),
            "cob_retenciones" => $this->getRetenciones(),
            "cob_ajustes" => $this->getAjustes(),
            "cob_cant_pagos" => $this->getCant_pagos(),
            "acciones" => $acciones,
            "cob_mediopago" => $this->getMediopago());
        return $array;
    }

    function muestraCantidadRegistros() {
        if ($this->getCantregistros() && ($this->getCantregistros() <> $this->getCantidadRenglones())) {
            $response = "A:" . $this->getCantregistros() . " R:" . $this->getCantidadRenglones();
        } else {
            $response = $this->getCantidadRenglones();
        }
        return $response;
    }

    function getCantidadRenglones() {
        return count($this->getRenglones());
    }

    function getCant_pagos() {
        return $this->cant_pagos;
    }

    function setCant_pagos($cant_pagos) {
        $this->cant_pagos = $cant_pagos;
    }

}

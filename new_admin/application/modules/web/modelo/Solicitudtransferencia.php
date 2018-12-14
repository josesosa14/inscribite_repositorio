<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Solicitudtransferencia
 * 
 * @Table(name="solicitud_transferencias") 
 * @Entity 
 */
class Solicitudtransferencia {

    /**
     * @var integer $id
     *
     * @Column(name="sot_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ManyToOne(targetEntity="Pago", cascade={"persist"}))
     * @JoinColumn(name="sot_pag_id", referencedColumnName="pag_id")
     * */
    private $pago;
    
    /**
     * @var $fechaCreacion
     *
     * @Column(name="sot_fecha_in", type="datetime", length=120, nullable=true)
     */
    private $fechaCreacion;
    
    /**
     * @var $observaciones
     *
     * @Column(name="sot_observaciones", type="text", nullable=true)
     */
    private $observaciones;
    
    function getId() {
        return $this->id;
    }

    function getPago() {
        return $this->pago;
    }

    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPago($pago) {
        $this->pago = $pago;
    }

    function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }
    
    function getDatosArray(){
        $array = array("id" => $this->getId(),
            "sot_pago" => $this->getPago()->getId(),
            "sot_observaciones" => $this->getObservaciones(),
        );
        return $array;
    }
}

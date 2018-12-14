<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Decodificador
 * 
 * @Table(name="decodificador") 
 * @Entity 
 */
class Decodificador {

    /**
     * @var integer $id
     *
     * @Column(name="dec_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**

     * @OneToOne(targetEntity="Mediodecodificado")

     * @JoinColumn(name="dec_pagofacil", referencedColumnName="med_id")

     * */
    private $pagofacil;

    /**

     * @OneToOne(targetEntity="Mediodecodificado")

     * @JoinColumn(name="dec_pagofacilinterior", referencedColumnName="med_id")

     * */
    private $pagofacilinterior;

    /**

     * @OneToOne(targetEntity="Mediodecodificado")

     * @JoinColumn(name="dec_rapipago", referencedColumnName="med_id")

     * */
    private $rapipago;

    /**

     * @OneToOne(targetEntity="Mediodecodificado")

     * @JoinColumn(name="dec_pagomiscuentas", referencedColumnName="med_id")

     * */
    private $pagomiscuentas;

    /**
     * @var string $tarjeta
     *
     * @Column(name="dec_tarjeta", type="string" ,length=200 )
     * 
     */
    protected $tarjeta;

    /**
     * @var string $observaciones
     *
     * @Column(name="dec_observaciones", type="string" ,length=300 ,nullable=true)
     * 
     */
    protected $observaciones;

    

    function getPagofacilinterior() {
        return $this->pagofacilinterior;
    }

    function setPagofacilinterior($pagofacilinterior) {
        $this->pagofacilinterior = $pagofacilinterior;
    }

    function getId() {
        return $this->id;
    }

    function setId($dec_id) {
        $this->id = $dec_id;
    }

    function getPagofacil() {
        return $this->pagofacil;
    }

    function setPagofacil($pagofacil) {
        $this->pagofacil = $pagofacil;
    }

    function getRapipago() {
        return $this->rapipago;
    }

    function setRapipago($rapipago) {
        $this->rapipago = $rapipago;
    }

    function getPagomiscuentas() {
        return $this->pagomiscuentas;
    }

    function setPagomiscuentas($pagomiscuentas) {
        $this->pagomiscuentas = $pagomiscuentas;
    }

    function getTarjeta() {
        return $this->tarjeta;
    }

    function setTarjeta($tarjeta) {
        $this->tarjeta = $tarjeta;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    public function getDatosArray() {
        $array = array("id" => $this->getId(),
            "dec_pagofacil" => $this->getPagofacil() ? $this->getPagofacil()->getNombre_archivo() . " $" . number_format($this->getPagofacil()->getTotal(), 2, ".", ",") . "  " . $this->getPagofacil()->getCant_registros() : "",
            "dec_pagofacilinterior" => $this->getPagofacilinterior() ? $this->getPagofacilinterior()->getNombre_archivo() . " $" . number_format($this->getPagofacilinterior()->getTotal(), 2, ".", ",") . "  " . $this->getPagofacilinterior()->getCant_registros() : "",
            "dec_rapipago" => $this->getRapipago() ? $this->getRapipago()->getNombre_archivo() . " $" . number_format($this->getRapipago()->getTotal(), 2, ",", ".") . " " . $this->getRapipago()->getCant_registros() : "",
            "dec_pagomiscuentas" => $this->getPagomiscuentas() ? $this->getPagomiscuentas()->getNombre_archivo() . " $" . number_format($this->getPagomiscuentas()->getTotal(), 2, ",", ".") . " " . $this->getPagomiscuentas()->getCant_registros() : "",
            "dec_tarjeta" => $this->getTarjeta(),
            "acciones" => '<a class="delete" href="borrardecodificador/' . $this->getId() . '" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a><a  class="reporte" href="xls_decodificador/' . $this->getId() . '" title="Reporte"><i class="glyphicon glyphicon-book"></i></a>',
            "dec_observaciones" => $this->getObservaciones());
        return $array;
    }

}

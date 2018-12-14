<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Mediodecodificado
 * 
 * @Table(name="mediodecodificado") 
 * @Entity 
 */
class Mediodecodificado {

    /**
     * @var integer $id
     *
     * @Column(name="med_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $tipo
     *
     * @Column(name="med_tipo", type="string" ,length=50 )
     * 
     */
    protected $tipo;

    /**
     * @var integer $cant_registros
     *
     * @Column(name="med_cant_registros", type="integer" ,length=4 )
     * 
     */
    protected $cant_registros;

    /**
     * @var string $total
     *
     * @Column(name="med_total", type="string" ,length=50 )
     * 
     */
    protected $total;

    /**
     * @var string $fecha
     *
     * @Column(name="med_fecha", type="date")
     * 
     */
    protected $fecha;

    /**
     * @var string $nombre_archivo
     *
     * @Column(name="med_nombre_archivo", type="string" ,length=120 )
     * 
     */
    protected $nombre_archivo;

    /**
     * @var Decodificado_renglones[] $renglones
     * @OneToMany(targetEntity="Decodificado_renglones", mappedBy="cabecera")
     * @OrderBy({"id" = "ASC"})
     */
    protected $renglones;

    /**

     * @OneToOne(targetEntity="Decodificador")

     * @JoinColumn(name="med_dec_id", referencedColumnName="dec_id")

     * */
    private $decodificador;

    function getDecodificador() {
        return $this->decodificador;
    }

    function setDecodificador($decodificador) {
        $this->decodificador = $decodificador;
    }

    function __construct() {
        $this->renglones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function getRenglones() {
        return $this->renglones;
    }

    function setRenglones($renglones) {
        $this->renglones = $renglones;
    }

    function getId() {
        return $this->id;
    }

    function setId($med_id) {
        $this->id = $med_id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getCant_registros() {
        $cant = $this->getTotalRegistrosArchivo();
        if ($this->getTipo() == "pmc") {
            //$cant=$cant-2;
        }
        $estado = "";
        $href_reprocesar = "";
        if ($cant > $this->getRenglones()->count()) {
            $estado = "danger";
        }
        $href_reprocesar = "&nbsp;<a href='" . base_url("reprocesar-medio/" . $this->getId()) . "'>Reprocesar</a>";
        return "<span class='" . $estado . "'>Pro:" . $this->getRenglones()->count() . " R:" . $cant . " A:<a target='_BLANK' href='" . base_url("public/decodificados/" . ($this->getTipo()=="pfc" || $this->getTipo()=="pfi"?"pf":$this->getTipo()) . "/" . $this->getNombre_archivo()) . "'>Archivo</a>" . $href_reprocesar . "</span>";
    }

    function getTotalRegistrosArchivo() {
        return $this->cant_registros;
    }

    function setCant_registros($cant_registros) {
        $this->cant_registros = $cant_registros;
    }

    function getTotal() {
        return $this->total;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function getNombre_archivo() {
        return $this->nombre_archivo;
    }

    function setNombre_archivo($nombre_archivo) {
        $this->nombre_archivo = $nombre_archivo;
    }

    public function getDatosArray() {
        $array = array("id" => $this->getId(),
            "med_tipo" => $this->getTipo(),
            "med_cant_registros" => $this->getRenglones()->count(),
            "med_total" => $this->getTotal(),
            "med_fecha" => $this->getFecha(),
            "med_nombre_archivo" => $this->getNombre_archivo());
        return $array;
    }
}

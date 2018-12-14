<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Vinoconsumido
 * 
 * @Table(name="vinoconsumido") 
 * @Entity 
 */
class Vinoconsumido {

    /**
     * @var integer $id
     *
     * @Column(name="vic_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="User")
     * @JoinColumn(name="vic_consumidor", referencedColumnName="usr_id")
     * */
    private $usuario;

    /**
     * @OneToOne(targetEntity="Vino")
     * @JoinColumn(name="vic_vino", referencedColumnName="vin_id")
     * */
    private $vino;

    /**
     * @var integer $calidad
     *
     * @Column(name="vic_calidad", type="integer")
     * 
     */
    protected $calidad;

    /**
     * @var integer $preciobeneficio
     *
     * @Column(name="vic_preciobeneficio", type="integer")
     * 
     */
    protected $preciobeneficio;

    /**
     * @var integer $favorito
     *
     * @Column(name="vic_favoritos")
     * 
     */
    protected $favorito;

    /**
     * @var integer $comprado
     *
     * @Column(name="vic_comprado")
     * 
     */
    protected $comprado;

    /**
     * @var integer $deacuerdo_wineid
     *
     * @Column(name="vic_de_acuerdo_wineid")
     * 
     */
    protected $deacuerdo_wineid;

    /**
     * @var integer $comentarios
     *
     * @Column(name="vic_comentarios",type="string")
     * 
     */
    protected $comentarios;

    /**
     * @var integer $fecha
     *
     * @Column(name="vic_fecha",type="date")
     * 
     */
    protected $fecha;

    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getVino() {
        return $this->vino;
    }

    function getCalidad() {
        return $this->calidad;
    }

    function getPreciobeneficio() {
        return $this->preciobeneficio;
    }

    function getFavorito() {
        return $this->favorito;
    }

    function getComprado() {
        return $this->comprado;
    }

    function getDeacuerdo_wineid() {
        return $this->deacuerdo_wineid;
    }

    function getComentarios() {
        return $this->comentarios;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setVino($vino) {
        $this->vino = $vino;
    }

    function setCalidad($calidad) {
        $this->calidad = $calidad;
    }

    function setPreciobeneficio($preciobeneficio) {
        $this->preciobeneficio = $preciobeneficio;
    }

    function setFavorito($favorito) {
        $this->favorito = $favorito;
    }

    function setComprado($comprado) {
        $this->comprado = $comprado;
    }

    function setDeacuerdo_wineid($deacuerdo_wineid) {
        $this->deacuerdo_wineid = $deacuerdo_wineid;
    }

    function setComentarios($comentarios) {
        $this->comentarios = $comentarios;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

}

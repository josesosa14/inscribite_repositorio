<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Vino
 * 
 * @Table(name="vino") 
 * @Entity 
 */
class Vino {

    /**
     * @var integer $id
     *
     * @Column(name="vin_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $nombre
     *
     * @Column(name="vin_nombre", type="string" ,length=100 )
     * 
     */
    protected $nombre;

    /**
     * @var string $bodega
     *
     * @Column(name="vin_bodega", type="string" ,length=100 )
     * 
     */
    protected $bodega;

    /**
     * @var string $cosecha
     *
     * @Column(name="vin_cosecha", type="string" ,length=100 )
     * 
     */
    protected $cosecha;

    /**
     * @var string $region
     *
     * @Column(name="vin_region", type="string" ,length=100 ,nullable=true)
     * 
     */
    protected $region;

    /**
     * @var string $apelacion
     *
     * @Column(name="vin_apelacion", type="string" ,length=100 ,nullable=true)
     * 
     */
    protected $apelacion;

    /**
     * @var string $descripcion
     *
     * @Column(name="vin_descripcion", type="string" )
     * 
     */
    protected $descripcion;

    /**
     * @var string $pais
     *
     * @Column(name="vin_pais", type="string" ,length=100 ,nullable=true)
     * 
     */
    protected $pais;

    /**
     * @var string $variedad
     *
     * @Column(name="vin_variedad", type="string" ,length=100 )
     * 
     */
    protected $variedad;

    /**
     * @var string $corte
     *
     * @Column(name="vin_corte", type="string" ,length=100 ,nullable=true)
     * 
     */
    protected $corte;

    /**
     * @var string $foto
     *
     * @Column(name="vin_foto", type="string" ,length=100 ,nullable=true)
     * 
     */
    protected $foto;

    /**
     * @var integer $pts_ws
     *
     * @Column(name="vin_pts_ws", type="integer" ,length=10 ,nullable=true)
     * 
     */
    protected $pts_ws;

    /**
     * @var integer $pts_parker
     *
     * @Column(name="vin_pts_parker", type="integer" ,length=10 ,nullable=true)
     * 
     */
    protected $pts_parker;

    /**
     * @var integer $pts_atkien
     *
     * @Column(name="vin_pts_atkien", type="integer" ,length=10 ,nullable=true)
     * 
     */
    protected $pts_atkien;

    /**
     * @var integer $pts_suckling
     *
     * @Column(name="vin_pts_suckling", type="integer" ,length=10 ,nullable=true)
     * 
     */
    protected $pts_suckling;

    /**
     * @var integer $pts_stanzer
     *
     * @Column(name="vin_pts_stanzer", type="integer" ,length=10 ,nullable=true)
     * 
     */
    protected $pts_stanzer;

    /**
     * @var string $crianza
     *
     * @Column(name="vin_crianza", type="string" ,length=100 ,nullable=true)
     * 
     */
    protected $crianza;

    /**
     * @var string $alcohol
     *
     * @Column(name="vin_alcohol", type="string" ,length=20 ,nullable=true)
     * 
     */
    protected $alcohol;

    /**
     * @var string $enologo
     *
     * @Column(name="vin_enologo", type="string" ,length=100 ,nullable=true)
     * 
     */
    protected $enologo;

    /**
     * @var integer $precio_sugerido
     *
     * @Column(name="vin_precio_sugerido", type="integer" ,length=10 )
     * 
     */
    protected $precio_sugerido;

    /**
     * @var integer $precio
     *
     * @Column(name="vin_precio", type="integer" ,length=10 )
     * 
     */
    protected $precio;

    /**
     * @var integer $precioCosto
     *
     * @Column(name="vin_precio_costo", type="integer" ,length=10 )
     * 
     */
    protected $precioCosto;

    /**
     * @var integer $caja
     *
     * @Column(name="vin_caja", type="integer" ,length=10 )
     * 
     */
    protected $caja;

    /**
     * @var string $sin_wineid
     *
     * @Column(name="vin_sin_wineid", type="string" ,length=5 ,nullable=true)
     * 
     */
    protected $sin_wineid;

    /**
     * @ManyToMany(targetEntity="Atributo")
     * @JoinTable(name="vino_atributo",
     *      joinColumns={@JoinColumn(name="var_vin_id", referencedColumnName="vin_id")},
     *      inverseJoinColumns={@JoinColumn(name="var_atr_id", referencedColumnName="atr_id")}
     *      )
     */
    private $atributos;

    /**
     * @OneToMany(targetEntity="Vinoatributo", mappedBy="vino")
     * */
    private $valores_atributos;

    function getDescripcion() {
        return $this->descripcion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function getApelacion() {
        return $this->apelacion;
    }

    function getPts_atkien() {
        return $this->pts_atkien;
    }

    function getPts_suckling() {
        return $this->pts_suckling;
    }

    function getPts_stanzer() {
        return $this->pts_stanzer;
    }

    function getPrecioCosto() {
        return $this->precioCosto;
    }

    function setApelacion($apelacion) {
        $this->apelacion = $apelacion;
    }

    function setPts_atkien($pts_atkien) {
        $this->pts_atkien = $pts_atkien;
    }

    function setPts_suckling($pts_suckling) {
        $this->pts_suckling = $pts_suckling;
    }

    function setPts_stanzer($pts_stanzer) {
        $this->pts_stanzer = $pts_stanzer;
    }

    function setPrecioCosto($precioCosto) {
        $this->precioCosto = $precioCosto;
    }

    function getValores_atributos() {
        return $this->valores_atributos;
    }

    function setValores_atributos($valores_atributos) {
        $this->valores_atributos = $valores_atributos;
    }

    function __construct() {
        $this->atributos = new Doctrine\Common\Collections\ArrayCollection;
    }

    function getAtributos() {
        return $this->atributos;
    }

    function setAtributos($atributos) {
        $this->atributos = $atributos;
    }

    function getId() {
        return $this->id;
    }

    function setId($vin_id) {
        $this->id = $vin_id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getBodega() {
        return $this->bodega;
    }

    function setBodega($bodega) {
        $this->bodega = $bodega;
    }

    function getCosecha() {
        return $this->cosecha;
    }

    function setCosecha($cosecha) {
        $this->cosecha = $cosecha;
    }

    function getRegion() {
        return $this->region;
    }

    function setRegion($region) {
        $this->region = $region;
    }

    function getPais() {
        return $this->pais;
    }

    function setPais($pais) {
        $this->pais = $pais;
    }

    function getVariedad() {
        return $this->variedad;
    }

    function setVariedad($variedad) {
        $this->variedad = $variedad;
    }

    function getCorte() {
        return $this->corte;
    }

    function setCorte($corte) {
        $this->corte = $corte;
    }

    function getFoto() {
        return $this->foto;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function getPts_ws() {
        return $this->pts_ws;
    }

    function setPts_ws($pts_ws) {
        $this->pts_ws = $pts_ws;
    }

    function getPts_parker() {
        return $this->pts_parker;
    }

    function setPts_parker($pts_parker) {
        $this->pts_parker = $pts_parker;
    }

    function getCrianza() {
        return $this->crianza;
    }

    function setCrianza($crianza) {
        $this->crianza = $crianza;
    }

    function getAlcohol() {
        return $this->alcohol;
    }

    function setAlcohol($alcohol) {
        $this->alcohol = $alcohol;
    }

    function getEnologo() {
        return $this->enologo;
    }

    function setEnologo($enologo) {
        $this->enologo = $enologo;
    }

    function getPrecio_sugerido() {
        return $this->precio_sugerido;
    }

    function setPrecio_sugerido($precio_sugerido) {
        $this->precio_sugerido = $precio_sugerido;
    }

    function getPrecio() {
        return $this->precio;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function getCaja() {
        return $this->caja;
    }

    function setCaja($caja) {
        $this->caja = $caja;
    }

    function getSin_wineid() {
        return $this->sin_wineid;
    }

    function setSin_wineid($sin_wineid) {
        $this->sin_wineid = $sin_wineid;
    }

    public function getDatosArray() {
        $array = array("id" => $this->getId(),
            "vin_nombre" => $this->getNombre(),
            "vin_bodega" => utf8_encode($this->getBodega()),
            "vin_cosecha" => $this->getCosecha() ? $this->getCosecha() : "",
            "vin_region" => $this->getRegion() ? $this->getRegion() : "",
            "vin_variedad" => $this->getVariedad() ? $this->getVariedad() : "",
            "vin_foto" => $this->getFoto() ? $this->getFoto() : "",
            "vin_precio_sugerido" => $this->getPrecio_sugerido() ? $this->getPrecio_sugerido() : "",
            "vin_precio" => $this->getPrecio() ? $this->getPrecio() : "",
            "vin_caja" => $this->getCaja() ? $this->getCaja() : "NO",
            "vin_sin_wineid" => $this->getSin_wineid() ? $this->getSin_wineid() : "");
        return $array;
    }

}

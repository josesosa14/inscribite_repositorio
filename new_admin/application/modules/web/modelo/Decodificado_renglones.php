<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Decodificado_renglones
 * 
 * @Table(name="decodificado_renglones") 
 * @Entity 
 */
class Decodificado_renglones {

    /**
     * @var integer $id
     *
     * @Column(name="dec_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $dni
     *
     * @Column(name="dec_dni", type="string" ,length=50 )
     * 
     */
    protected $dni;

    /**
     * @var string $codigo
     *
     * @Column(name="dec_codigo", type="string" ,length=50 )
     * 
     */
    protected $codigo;

    /**
     * @var string $importe
     *
     * @Column(name="dec_importe", type="string" ,length=50 )
     * 
     */
    protected $importe;

    /**
     * @var string $fechapago
     *
     * @Column(name="dec_fechapago", type="date")
     * 
     */
    protected $fechapago;

    /**
     * @var string $fechaacreditacion
     *
     * @Column(name="dec_fechaacreditacion", type="date")
     * 
     */
    protected $fechaacreditacion;

    /**

     * @OneToOne(targetEntity="Mediodecodificado")

     * @JoinColumn(name="dec_med_id", referencedColumnName="med_id")

     * */
    private $cabecera;

    /**
     * @var string $tipo_decodificacion
     *
     * @Column(name="dec_tipo_ingreso", type="string" ,length=50 )
     * 
     */
    protected $tipo_decodificacion;

    /**
     * @var datetime $enviado
     *
     * @Column(name="dec_enviado", type="datetime")
     * 
     */
    protected $enviado;

    function getEnviado() {
        return $this->enviado;
    }

    function setEnviado(datetime $enviado) {
        $this->enviado = $enviado;
    }

    function getTipo_decodificacion() {
        return $this->tipo_decodificacion;
    }

    function setTipo_decodificacion($tipo_decodificacion) {
        $this->tipo_decodificacion = $tipo_decodificacion;
    }

    function getCabecera() {
        return $this->cabecera;
    }

    function setCabecera($cabecera) {
        $this->cabecera = $cabecera;
    }

    function getFechaacreditacion() {
        return $this->fechaacreditacion;
    }

    function setFechaacreditacion($fechaacreditacion) {
        $this->fechaacreditacion = $fechaacreditacion;
    }

    function getId() {
        return $this->id;
    }

    function setId($dec_id) {
        $this->id = $dec_id;
    }

    function getDni() {
        return $this->dni;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function getImporte() {
        return $this->importe;
    }

    function setImporte($importe) {
        $this->importe = $importe;
    }

    function getFechapago() {
        return $this->fechapago;
    }

    function setFechapago($fechapago) {
        $this->fechapago = $fechapago;
    }

    public function getDatosArray() {
        $array = array("id" => $this->getId(),
            "dec_mediodecodificado" => $this->getMediodecodificado(),
            "dec_dni" => $this->getDni(),
            "dec_codigo" => $this->getCodigo(),
            "dec_importe" => $this->getImporte(),
            "dec_fechapago" => $this->getFechapago());
        return $array;
    }

}

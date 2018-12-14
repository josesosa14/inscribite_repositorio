<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * SolicitudtransferenciaRenglones
 * 
 * @Table(name="solicitud_transferencias_renglones") 
 * @Entity 
 */
class SolicitudtransferenciaRenglones {

    /**
     * @var integer $id
     *
     * @Column(name="str_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ManyToOne(targetEntity="Solicitudtransferencia", cascade={"persist"}))
     * @JoinColumn(name="str_sot_id", referencedColumnName="sot_id")
     * */
    private $solicitudTransferencia;
    
    /**
     * @ManyToOne(targetEntity="Tipo_pago", cascade={"persist"}))
     * @JoinColumn(name="str_tip_id", referencedColumnName="tipo_pago_id")
     * */
    private $tipoPago;
    
    /**

     * @ManyToOne(targetEntity="Banco")

     * @JoinColumn(name="str_ban_id", referencedColumnName="ban_id")

     * 
     */
    private $banco;
    
     /**

     * @var integer $cuit

     *

     * @Column(name="str_cuit", type="integer", nullable=true)

     */
    private $cuit;
    
    /**

     * @var integer $cuit

     *

     * @Column(name="str_cbu", type="integer", nullable=true)

     */
    private $cbu;
    
    /**

     * @var float $importe

     *

     * @Column(name="str_importe", type="decimal", nullable=true)

     */
    private $importe;
    
    function getId() {
        return $this->id;
    }

    function getSolicitudTransferencia() {
        return $this->solicitudTransferencia;
    }

    function getBanco() {
        return $this->banco;
    }

    function getCuit() {
        return $this->cuit;
    }

    function getCbu() {
        return $this->cbu;
    }

    function getImporte() {
        return $this->importe;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setSolicitudTransferencia($solicitudTransferencia) {
        $this->solicitudTransferencia = $solicitudTransferencia;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setCuit($cuit) {
        $this->cuit = $cuit;
    }

    function setCbu($cbu) {
        $this->cbu = $cbu;
    }

    function setImporte($importe) {
        $this->importe = $importe;
    }
    
    function getTipoPago() {
        return $this->tipoPago;
    }

    function setTipoPago($tipoPago) {
        $this->tipoPago = $tipoPago;
    }
}

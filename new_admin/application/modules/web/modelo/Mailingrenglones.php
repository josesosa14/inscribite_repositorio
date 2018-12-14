<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Mailingrenglones
 * 
 * @Table(name="mailing_renglones") 
 * @Entity 
 */
class Mailingrenglones {

    /**
     * @var integer $id
     *
     * @Column(name="mar_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @var Mailing $mail_cabecera
     * @OneToOne(targetEntity="Mailing")
     * @JoinColumn(name="mar_mai_id", referencedColumnName="mai_id")
     * */
    private $mail_cabecera;

    /** @var Guardavida $guardavida
     * @OneToOne(targetEntity="Guardavida")
     * @JoinColumn(name="mar_guardavida", referencedColumnName="gua_id")
     * */
    private $guardavida;

    /**
     * @var string $destino
     *
     * @Column(name="mar_destino", type="string" ,length=200 )
     * 
     */
    private $destino;

    /**
     * @var datetime $enviado
     *
     * @Column(name="mar_enviado", type="datetime")
     * 
     */
    private $enviado;

    /**
     * @var datetime $fecha_in
     *
     * @Column(name="mar_fecha_in", type="datetime")
     * 
     */
    private $fecha_in;

    /**
     * @var string $adjunto
     *
     * @Column(name="mar_adjunto", type="string")
     * 
     */
    private $adjunto;

    /**
     * @var string $mensaje
     *
     * @Column(name="mar_mensaje", type="string")
     * 
     */
    private $mensaje;

    function getGuardavida() {
        return $this->guardavida;
    }

    function setGuardavida(Guardavida $guardavida) {
        $this->guardavida = $guardavida;
    }

    function getAdjunto() {
        return $this->adjunto;
    }

    function getMensaje() {
        return $this->mensaje;
    }

    function setAdjunto($adjunto) {
        $this->adjunto = $adjunto;
    }

    function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    function getId() {
        return $this->id;
    }

    function getMail_cabecera() {
        return $this->mail_cabecera;
    }

    function getDestino() {
        return $this->destino;
    }

    function getEnviado() {
        return $this->enviado;
    }

    function getFecha_in() {
        return $this->fecha_in;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setMail_cabecera(Mailing $mail_cabecera) {
        $this->mail_cabecera = $mail_cabecera;
    }

    function setDestino($destino) {
        $this->destino = $destino;
    }

    function setEnviado(datetime $enviado) {
        $this->enviado = $enviado;
    }

    function setFecha_in(datetime $fecha_in) {
        $this->fecha_in = $fecha_in;
    }

}

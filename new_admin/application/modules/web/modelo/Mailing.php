<?php

defined("BASEPATH") OR exit("No direct script access allowed");

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Mailing
 * 
 * @Table(name="mailing") 
 * @Entity 
 */
class Mailing {

    /**
     * @var integer $id
     *
     * @Column(name="mai_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $subject
     *
     * @Column(name="mai_subject", type="string" ,length=300 )
     * 
     */
    protected $subject;

    /**
     * @var string $mensaje
     *
     * @Column(name="mai_mensaje", type="string"  )
     * 
     */
    protected $mensaje;

    /**
     * @var string $adjunto
     *
     * @Column(name="mai_adjunto", type="string" ,length=200 )
     * 
     */
    protected $adjunto;

    /**
     * @var datetime $fecha_in
     *
     * @Column(name="mai_fecha_in", type="datetime" )
     * 
     */
    protected $fecha_in;

    /**
     * @var datetime $enviado
     *
     * @Column(name="mai_enviado", type="datetime")
     * 
     */
    protected $enviado;

    /**
     * @var Mailingrenglones[] $destinos
     * @OneToMany(targetEntity="Mailingrenglones", mappedBy="mail_cabecera", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $destinos;
    
     /** @var Usuario $usuario
     * @OneToOne(targetEntity="Usuario")
     * @JoinColumn(name="mai_usu_id", referencedColumnName="usuario_id")
     * */
    private $usuario;

    public function __construct() {
        $this->destinos = new ArrayCollection();
    }

    function getDestinos() {
        return $this->destinos;
    }

    function setDestinos($destinos) {
        $this->destinos = $destinos;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function getId() {
        return $this->id;
    }

    function setId($mai_id) {
        $this->id = $mai_id;
    }

    function getSubject() {
        return $this->subject;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

    function getMensaje() {
        return $this->mensaje;
    }

    function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    function getAdjunto() {
        return $this->adjunto;
    }

    function setAdjunto($adjunto) {
        $this->adjunto = $adjunto;
    }

    function getFecha_in() {
        return $this->fecha_in;
    }

    function setFecha_in($fecha_in) {
        $this->fecha_in = $fecha_in;
    }

    function getEnviado() {
        return $this->enviado;
    }

    function setEnviado($enviado) {
        $this->enviado = $enviado;
    }

    public function getDatosArray() {
        $array = array("id" => $this->getId(),
            "mai_subject" => $this->getSubject(),
            "mai_mensaje" => $this->getMensaje(),
            "mai_adjunto" => $this->getAdjunto() ? "si" : "no",
            "mai_fecha_in" => $this->getFecha_in()->format("d/m/Y"),
            "mai_enviado" => $this->getEnviado());
        return $array;
    }

}

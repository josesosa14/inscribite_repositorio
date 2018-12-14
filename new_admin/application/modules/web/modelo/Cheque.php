<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cobro
 *
 * @author Nicolas
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**

 * Cheque

 *

 * @Table(name="cheque")

 * @Entity

 */
class Cheque {

    /**

     * @var integer $id

     *

     * @Column(name="cheque_id", type="integer", nullable=false)

     * @Id

     * @GeneratedValue(strategy="AUTO")

     */
    private $id;

    /**

     * @var string $numero

     *

     * @Column(name="cheque_numero", type="string")

     */
    private $numero;

    /**

     * @Column(name="cheque_fecha_ingreso", type="datetime")

     */
    private $fechaIngreso;

    /**
     * @ManyToOne(targetEntity="Banco")
     * @JoinColumn(name="cheque_banco_id", referencedColumnName="ban_id")
     * */
    private $banco;

    /**

     * @Column(name="cheque_fecha_vencimiento", type="datetime")

     */
    private $fechaVencimiento;

    /**

     * @Column(name="cheque_importe", type="float")

     */
    private $importe;

    /**

     * @ManyToOne(targetEntity="Estado_cheque")

     * @JoinColumn(name="cheque_estado", referencedColumnName="estado_cheque_id")

     * */
    private $estadoCheque;

    /**


     * @Column(name="cheque_fecha_salida", type="datetime")

     */
    private $fechaSalida;

    /**

     * @Column(name="cheque_activo", type="integer")

     */
    private $activo;

    /**

     * @var string $comentario

     *

     * @Column(name="cheque_comentario", type="string")

     */
    private $comentario;

    /**

     * @Column(name="cheque_destino", type="integer")

     */
    private $destino;

    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function getFechaIngreso() {
        return ($this->fechaIngreso !== NULL) ? $this->fechaIngreso->format("Y-m-d") : NULL;
    }

    function getBanco() {
        return $this->banco;
    }

    function getFechaVencimiento() {
        return ($this->fechaVencimiento !== NULL) ? $this->fechaVencimiento->format("Y-m-d") : NULL;
    }

    function getImporte() {
        return $this->importe;
    }

    function getEstadoCheque() {
        return $this->estadoCheque;
    }

    function getFechaSalida() {
        return ($this->fechaSalida !== NULL) ? $this->fechaSalida->format("Y-m-d") : NULL;
    }

    function getActivo() {
        return $this->activo;
    }

    function getDestino() {
        return $this->destino;
    }

    function getComentario() {
        return $this->comentario;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setFechaIngreso($fechaIngreso) {
        $this->fechaIngreso = $fechaIngreso;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setFechaVencimiento($fechaVencimiento) {
        $this->fechaVencimiento = $fechaVencimiento;
    }

    function setImporte($importe) {
        $this->importe = $importe;
    }

    function setEstadoCheque($estadoCheque) {
        $this->estadoCheque = $estadoCheque;
    }

    function setFechaSalida($fechaSalida) {
        $this->fechaSalida = $fechaSalida;
    }

    function setActivo($activo) {
        $this->activo = $activo;
    }

    function setDestino($destino) {
        $this->destino = $destino;
    }

    function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    public function __construct() {
        $this->setActivo(1);
        $this->setFechaIngreso(new DateTime());
        $this->setFechaVencimiento(new DateTime());
    }

    public function actualizar($estadoCheque, $comentario, $fec_salida = "") {
        $this->setEstadoCheque($estadoCheque, $comentario);
        $this->setComentario($comentario);
        if ($fec_salida) {
            $this->setFechaSalida(new \DateTime($fec_salida));
        }
    }

    function obtenerArray() {
        $arreglo = array("id" => $this->id,
            "numero" => $this->numero,
            "fechaIngreso" => (($this->fechaIngreso !== NULL) ? $this->fechaIngreso->format("Y-m-d") : ""),
            "banco" => $this->banco->obtenerArray(),
            "fechaIngreso" => (($this->fechaVencimiento !== NULL) ? $this->fechaVencimiento->format("Y-m-d") : ""),
            "importe" => $this->importe,
            "estadoCheque" => $this->estadoCheque->obtenerArray(),
            "fechaIngreso" => (($this->fechaSalida !== NULL) ? $this->fechaSalida->format("Y-m-d") : ""),
            "comentario" => $this->comentario,
            "activo" => $this->activo
        );
        return $arreglo;
    }

    function getDatos($bancos, $estados) {
        $select_bancos = "<select name='cheque[" . $this->getId() . "][chq_banco]'>";
        foreach ($bancos as $banco) {
            $select_bancos.="<option " . ($this->getBanco()->getId() == $banco->getId() ? "selected" : "") . " value='" . $banco->getId() . "'>" . $banco->getNombre() . "</option>";
        }
        $select_bancos.="</select>";

        $select_estados = "<select name='cheque[" . $this->getId() . "][chq_estado]'>";
        foreach ($estados as $estado) {
            $select_estados.="<option " . ($this->getEstadoCheque()->getId() == $estado->getId() ? "selected" : "") . " value='" . $estado->getId() . "'>" . $estado->getNombre() . "</option>";
        }
        $select_estados.="</select>";

        $arreglo = array("chq_id" => "<input type='hidden' name='cheque[" . $this->getId() . "][chq_id]' value='" . $this->getId() . "'/>",
            "chq_numero" => $this->getNumero(),
            "chq_fecha_ingreso" => (new \DateTime($this->getFechaIngreso()))->format("d/m/Y"),
            "chq_banco" => $select_bancos,
            "chq_fecha_vencimiento" => "<input type='text' class='date' name='cheque[" . $this->getId() . "][chq_fecha_vencimiento]' value='" . (($this->getFechaVencimiento() !== NULL) ? (new \DateTime($this->getFechaVencimiento()))->format("d/m/Y") : "") . "'/>",
            "chq_importe" => $this->getImporte(),
            "chq_estado" => $select_estados,
            "chq_fecha_salida" => "<input type='text' class='date' name='cheque[" . $this->getId() . "][chq_fecha_salida]' value='" . (($this->getFechaSalida() !== NULL) ? (new \DateTime($this->getFechaSalida()))->format("d/m/Y") : "") . "'/>",
            "chq_comentario" => "<input type='text' name='cheque[" . $this->getId() . "][chq_comentario]' value='" . $this->getComentario() . "'/>",
            "chq_activo" => $this->getActivo()
        );
        return $arreglo;
    }

}

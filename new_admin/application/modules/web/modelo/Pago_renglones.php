<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**

 * Pago_renglones

 *

 * @Table(name="pagos_renglones")

 * @Entity

 */
class Pago_renglones {

    /**

     * @var integer $id

     *

     * @Column(name="par_id", type="integer", nullable=false)

     * @Id

     * @GeneratedValue(strategy="AUTO")

     */
    private $id;

    /**

     * @ManyToOne(targetEntity="Pago", cascade={"persist"}))

     * @JoinColumn(name="par_pag_id", referencedColumnName="pag_id")

     * */
    private $pago;

    /**

     * @ManyToOne(targetEntity="Tipo_pago", cascade={"persist"})

     * @JoinColumn(name="par_tip_id", referencedColumnName="tipo_pago_id")

     * */
    private $tipoPago;

    /**
     * @OneToOne(targetEntity="Empresacuenta")
     * @JoinColumn(name="par_empb_id", referencedColumnName="empb_id")
     * */
    private $cuenta;

    /**

     * @var float $importe

     *

     * @Column(name="par_importe", type="decimal", nullable=true)

     */
    private $importe;

    /**

     * @var string $numero

     *

     * @Column(name="par_numero", type="string", nullable=true)

     */
    private $numero;

    /**
     * @var $fechaEjecucion
     *
     * @Column(name="par_fecha", type="datetime", length=120, nullable=true)
     */
    private $fechaEjecucion;

    function getFechaEjecucion() {
        return $this->fechaEjecucion;
    }

    function setFechaEjecucion($fechaEjecucion) {
        $this->fechaEjecucion = $fechaEjecucion;
    }

    function getId() {
        return $this->id;
    }

    function getPago() {
        return $this->pago;
    }

    function getTipoPago() {
        return $this->tipoPago;
    }

    function getImporte() {
        return $this->importe;
    }

    function getNumero() {
        return $this->numero;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPago($pago) {
        $this->pago = $pago;
    }

    function setTipoPago($tipoPago) {
        $this->tipoPago = $tipoPago;
    }

    function setImporte($importe) {
        $this->importe = $importe;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function getCuenta() {
        return $this->cuenta;
    }

    function setCuenta($cuenta) {
        $this->cuenta = $cuenta;
    }

}

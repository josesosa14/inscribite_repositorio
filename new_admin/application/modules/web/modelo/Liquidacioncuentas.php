<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Liquidacioncuentas
 * 
 * @Table(name="liquidacion_cuentas") 
 * @Entity 
 */
class Liquidacioncuentas {

    /**
     * @var integer $id
     *
     * @Column(name="lic_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @var Liquidacion $liquidacion
     * @OneToOne(targetEntity="Liquidacion")
     * @JoinColumn(name="lic_liq_id", referencedColumnName="liq_id")
     * */
    private $liquidacion;

    /** @var Empresacuenta $cuenta
     * @OneToOne(targetEntity="Empresacuenta")
     * @JoinColumn(name="lic_empb_id", referencedColumnName="empb_id")
     * */
    private $cuenta;

    /**
     * @var float $importe
     *
     * @Column(name="lic_importe", type="float")
     */
    private $importe;

    function getId() {
        return $this->id;
    }

    function getLiquidacion() {
        return $this->liquidacion;
    }

    function getCuenta() {
        return $this->cuenta;
    }

    function getImporte() {
        return $this->importe;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLiquidacion(Liquidacion $liquidacion) {
        $this->liquidacion = $liquidacion;
    }

    function setCuenta(Empresacuenta $cuenta) {
        $this->cuenta = $cuenta;
    }

    function setImporte($importe) {
        $this->importe = $importe;
    }

}

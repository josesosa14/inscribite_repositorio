<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Vinoatributo
 * 
 * @Table(name="vino_atributo") 
 * @Entity 
 */
class Vinoatributo {

    /**
     * @var integer $id
     *
     * @Column(name="var_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="Atributo")
     * @JoinColumn(name="var_atr_id", referencedColumnName="atr_id")
     * */
    private $atributo;

    /**
     * @OneToOne(targetEntity="Vino")
     * @JoinColumn(name="var_vin_id", referencedColumnName="vin_id")
     * */
    private $vino;

    /**
     * @var integer $valor
     *
     * @Column(name="var_valor", type="integer")
     * 
     */
    protected $valor;

    function getId() {
        return $this->id;
    }

    function getAtributo() {
        return $this->atributo;
    }

    function getVino() {
        return $this->vino;
    }

    function getValor() {
        return $this->valor;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setAtributo($atributo) {
        $this->atributo = $atributo;
    }

    function setVino($vino) {
        $this->vino = $vino;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    public function getDatosArray() {
        $array = array(
            "id" => $this->getId(),
            "atributo" => $this->getAtributo()->getNombre(),
            "valor" => $this->getValor(),
            "tipo" => $this->getAtributo()->getTipo()->getNombre(),
            "tipo_id" => $this->getAtributo()->getTipo()->getId()
        );
        return $array;
    }

}

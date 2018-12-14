<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Guardavidaatributo
 * 
 * @Table(name="guardavida_atributos") 
 * @Entity 
 */
class Guardavidaatributo {

    /**
     * @var integer $id
     *
     * @Column(name="gat_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $valor
     *
     * @Column(name="gat_valor", type="string")
     * 
     */
    protected $valor;

    /**
     * @var Guardavida $guardavida

     * @OneToOne(targetEntity="Guardavida")

     * @JoinColumn(name="gat_gua_id", referencedColumnName="gua_id")

     * */
    private $guardavida;

    /**
     * @var Atributo $atributo

     * @OneToOne(targetEntity="Atributo")

     * @JoinColumn(name="gat_atr_id", referencedColumnName="atr_id")

     * */
    private $atributo;

    function getId() {
        return $this->id;
    }

    function getValor() {
        return $this->valor;
    }

    function getGuardavida() {
        return $this->guardavida;
    }

    function getAtributo() {
        return $this->atributo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setGuardavida(Guardavida $guardavida) {
        $this->guardavida = $guardavida;
    }

    function setAtributo(Atributo $atributo) {
        $this->atributo = $atributo;
    }

}

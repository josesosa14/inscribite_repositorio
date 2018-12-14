<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Listadifusionrenglones
 * 
 * @Table(name="listadifusion_renglones") 
 * @Entity 
 */
class Listadifusionrenglones {

    /**
     * @var integer $id
     *
     * @Column(name="ldr_id", type="integer",nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @var Guardavida $usuario
     * @OneToOne(targetEntity="Guardavida")
     * @JoinColumn(name="ldr_usu_id", referencedColumnName="gua_id")
     * */
    private $usuario;

    /** @var Listadifusion $lista 
     * @OneToOne(targetEntity="Listadifusion")
     * @JoinColumn(name="ldr_lis_id", referencedColumnName="lis_id")
     * */
    private $lista;

    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getLista() {
        return $this->lista;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario(Guardavida $usuario) {
        $this->usuario = $usuario;
    }

    function setLista(Listadifusion $lista) {
        $this->lista = $lista;
    }

}

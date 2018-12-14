<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tipo_pago
 *
 * @author MONICA
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**

 * Tipo_Pago

 *

 * @Table(name="tipo_pago")

 * @Entity

 */
class Tipo_pago {

    /**

     * @var integer $id

     *

     * @Column(name="tipo_pago_id", type="integer", nullable=false)

     * @Id

     * @GeneratedValue(strategy="AUTO")

     */
    private $id;

    /**

     * @var string $nombre

     *

     * @Column(name="tipo_pago_nombre", type="string")

     */
    private $nombre;

    function getId() {

        return $this->id;
    }

    function getNombre() {

        return $this->nombre;
    }

    function setId($id) {

        $this->id = $id;
    }

    function setNombre($nombre) {

        $this->nombre = $nombre;
    }

    public function __construct($nombre) {
        $this->actualizar($nombre);
    }

    public function actualizar($nombre) {
        $this->setNombre($nombre);
    }

    function obtenerArray() {
        $arreglo = array("id" => $this->id,
            "nombre" => $this->nombre
        );
        return $arreglo;
    }

}

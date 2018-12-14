<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**

 * Estado_cheque

 *

 * @Table(name="estado_cheque")

 * @Entity

 */
class Estado_cheque {

    /**

     * @var integer $id

     *

     * @Column(name="estado_cheque_id", type="integer", nullable=false)

     * @Id

     * @GeneratedValue(strategy="AUTO")

     */
    private $id;

    /**

     * @var string $nombre

     *

     * @Column(name="estado_cheque_nombre", type="string", length=120, nullable=true)

     */
    private $nombre;

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
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

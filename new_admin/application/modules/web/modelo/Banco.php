<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Banco
 *
 * @author MONICA
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**

 * Banco

 *

 * @Table(name="banco")

 * @Entity

 */
class Banco {

    /**

     * @var integer $id

     *

     * @Column(name="ban_id", type="integer", nullable=false)

     * @Id

     * @GeneratedValue(strategy="AUTO")

     */
    private $id;

    /**

     * @var string $nombre

     *

     * @Column(name="ban_nombre", type="string", nullable=true)

     */
    private $nombre;

    /**
     * @var integer $activo
     *
     * @Column(name="ban_activo", type="integer", nullable=true)
     */
    private $activo;

    function getId() {

        return $this->id;
    }

    function getNombre() {

        return $this->nombre;
    }

    function getActivo() {
        return $this->activo;
    }

    function setNombre($nombre) {
        return $this->nombre = $nombre;
    }

    function setActivo($activo) {
        return $this->activo = $activo;
    }

    public function __construct($nombre) {
        $this->setActivo(1);
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

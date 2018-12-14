<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Permiso
 *
 * @Table(name="permiso")
 * @Entity
 */
class Permiso {

    /**
     * @var integer $id
     *
     * @Column(name="permiso_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string $nombre
     *
     * @Column(name="permiso_nombre", type="string", length=32, nullable=false)
     */
    private $nombre;
    /**
     * @var string $descripcion
     *
     * @Column(name="permiso_descripcion", type="string", length=128, nullable=false)
     */
    private $descripcion;
    /**
     * @var string $peso
     *
     * @Column(name="permiso_peso", type="integer", nullable=true)
     */
    private $peso;
    /**
     * @var string $fechaCreacion
     *
     * @Column(name="permiso_fecha_in", type="string", nullable=true)
     */
    private $fechaCreacion;

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getPeso() {
        return $this->peso;
    }

    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        if (!$nombre) {
            $this->nombre = "";
        } else {
            $this->nombre = $nombre;
        }
    }

    function setDescripcion($descripcion) {
        if (!$descripcion) {
            $this->descripcion = "";
        } else {
            $this->descripcion = $descripcion;
        }
    }

    function setPeso($peso) {
        if (!$peso) {
            $this->peso = 1;
        } else {
            $this->peso = $peso;
        }
    }

    function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    function setear($nombre, $descripcion, $peso = false) {
        $this->setNombre($nombre);
        $this->setDescripcion($descripcion);
        $this->setPeso($peso);
    }

}

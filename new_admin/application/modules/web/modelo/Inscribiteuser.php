<?php

defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Inscribiteuser
 * 
 * @Table(name="inscribite_usuarios") 
 * @Entity 
 */
class Inscribiteuser {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer",nullable=false)
     
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $nombre
     *
     * @Column(name="nombre", type="string")
     * 
     */
    protected $nombre;

    /**
     * @var string $apellido
     *
     * @Column(name="apellido", type="string")
     * 
     */
    protected $apellido;

    /**
     * @var integer $dni
     * @Id
     * @Column(name="dni", type="integer")
     * 
     */
    protected $dni;

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellido() {
        return $this->apellido;
    }

    function getDni() {
        return $this->dni;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

}

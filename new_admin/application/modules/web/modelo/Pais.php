<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pais
 *
 * @Table(name="pais")
 * @Entity
 */
class Pais {

    /**
     * @var integer $id
     *
     * @Column(name="pais_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $nombre
     *
     * @Column(name="pais_nombre", type="string", length=256, nullable=false)
     */
    protected $nombre;

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

    function setear($nombre) {
        $this->setNombre($nombre);
    }

}

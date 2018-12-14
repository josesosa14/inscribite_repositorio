<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Localidad
 *
 * @Table(name="localidades")
 * @Entity
 */
class Localidad {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nombre
     *
     * @Column(name="nombre", type="string", length=200, nullable=true)
     */
    private $nombre;
    
    /**
     * @OneToOne(targetEntity="Provincia")
     * @JoinColumn(name="id_provincia", referencedColumnName="id")
     * */
    private $provincia;
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getProvincia() {
        return $this->provincia;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setProvincia($provincia) {
        $this->provincia = $provincia;
    }


}

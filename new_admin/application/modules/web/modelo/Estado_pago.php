<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use \Doctrine\Common\Collections\ArrayCollection;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pago
 *
 * @author MONICA
 */

/**

 * Estado_Pago

 *

 * @Table(name="estado_pago")

 * @Entity

 */
class Estado_pago {

    /**

     * @var integer $id

     *

     * @Column(name="id_estado_pago", type="integer", nullable=false)

     * @Id

     * @GeneratedValue(strategy="AUTO")

     */
    private $id;

    /**

     * @var string $nombre

     *

     * @Column(name="nombre_estado_pago", type="string", length=120, nullable=true)

     */
    private $nombre;

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
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

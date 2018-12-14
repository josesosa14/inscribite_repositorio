<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**

 * Usuariorol

 *

 * @Table(name="usuario_rol")

 * @Entity

 */
class Usuariorol {

    /**

     * @var integer $id

     *

     * @Column(name="ur_id", type="integer", nullable=false)

     * @Id

     * @GeneratedValue(strategy="AUTO")

     */
    private $id;

    /**

     * @OneToOne(targetEntity="Usuario")
     * @JoinColumn(name="ur_usuario_id", referencedColumnName="usuario_id")

     * 
     */
    private $usuario;

    /**

     * @OneToOne(targetEntity="Rol")
     * @JoinColumn(name="ur_rol_id", referencedColumnName="rol_id")
     * 
     */
    private $rol;

    /**

     * @var string $fecha

     *

     * @Column(name="ur_fecha_in", type="date", nullable=true)

     */
    private $fecha;

    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getRol() {
        return $this->rol;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setRol($rol) {
        $this->rol = $rol;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function __construct($usuario, $rol, $fecha) {
        $this->setFecha(new \DateTime($fecha));
        $this->actualizar($usuario, $rol);
    }

    public function actualizar($usuario, $rol) {
        $this->setUsuario($usuario);
        $this->setRol($rol);
    }

}

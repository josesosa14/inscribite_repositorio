<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**

 * Rolpermiso

 *

 * @Table(name="rol_permiso")

 * @Entity

 */
class Rolpermiso {

    /**

     * @var integer $id

     *

     * @Column(name="ven_id", type="integer", nullable=false)

     * @Id

     * @GeneratedValue(strategy="AUTO")

     */
    private $id;

    /**

     * @OneToOne(targetEntity="Permiso")
     * @JoinColumn(name="rp_permiso_id", referencedColumnName="permiso_id")

     * 
     */
    private $permiso;

    /**

     * @OneToOne(targetEntity="Rol")
     * @JoinColumn(name="rp_rol_id", referencedColumnName="rol_id")

     * 
     */
    private $rol;

    /**

     * @var string $fecha

     *

     * @Column(name="rp_fecha_in", type="date", nullable=true)

     */
    private $fecha;

    function getId() {
        return $this->id;
    }

    function getPermiso() {
        return $this->permiso;
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

    function setPermiso($permiso) {
        $this->permiso = $permiso;
    }

    function setRol($rol) {
        $this->rol = $rol;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function __construct($permiso, $rol, $fecha) {
        $this->setFecha(new \DateTime($fecha));
        $this->actualizar($permiso, $rol);
    }

    public function actualizar($permiso, $rol) {
        $this->setPermiso($permiso);
        $this->setRol($rol);
    }

}

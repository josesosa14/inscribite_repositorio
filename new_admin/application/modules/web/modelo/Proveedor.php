<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**

 * Proveedor

 *

 * @Table(name="proveedor")

 * @Entity

 */
class Proveedor {

    /**

     * @var integer $id

     *

     * @Column(name="proveedor_id", type="integer", nullable=false)

     * @Id

     * @GeneratedValue(strategy="AUTO")

     */
    private $id;

    /**

     * @var string $razon_social

     *

     * @Column(name="proveedor_razon_social", type="string", length=120, nullable=true)

     */
    private $razon_social;

    /**

     * @var integer $activo

     *

     * @Column(name="proveedor_activo", type="integer", length=1, nullable=true)

     */

    /**
     * @ManyToOne(targetEntity="Provincia")
     * @JoinColumn(name="proveedor_provincia", referencedColumnName="id")
     * */
    private $provincia;

    /**

     * @var string $localidad

     *

     * @Column(name="proveedor_localidad")

     */
    private $localidad;
    private $activo;

    /**

     * @ManyToOne(targetEntity="Condiva")

     * @JoinColumn(name="proveedor_condiva_id", referencedColumnName="condiva_id")

     * */
    private $condicion_iva;

    /**

     * @var string $cuit

     *

     * @Column(name="proveedor_cuit", type="string", length=15, nullable=true)

     */
    private $cuit;

    /**

     * @var string $contacto

     *

     * @Column(name="proveedor_contacto", type="string", length=200, nullable=true)

     */
    private $contacto;

    /**

     * @var string $servicio

     *

     * @Column(name="proveedor_servicio", type="string", length=200, nullable=true)

     */
    private $servicio;

    /**

     * @var string $comentario

     *

     * @Column(name="proveedor_comentario", type="string", length=500, nullable=true)

     */
    private $comentario;

    /**

     * @var integer $telefono

     *

     * @Column(name="proveedor_telefono", type="string", length=500, nullable=true)

     */
    private $telefono;

    /**

     * @var integer $cp

     *

     * @Column(name="proveedor_cp", type="integer")

     */
    private $cp;

    /**

     * @var string $altura

     *

     * @Column(name="proveedor_altura", type="string")

     */
    private $altura;

    /**

     * @var string $piso

     *

     * @Column(name="proveedor_piso", type="string")

     */
    private $piso;

    /**

     * @var string $calle

     *

     * @Column(name="proveedor_calle", type="string")

     */
    private $calle;

    /**

     * @var string $dpto

     *

     * @Column(name="proveedor_dpto", type="string")

     */
    private $dpto;

    function getId() {
        return $this->id;
    }

    function getRazon_social() {
        return $this->razon_social;
    }

    function getActivo() {
        return $this->activo;
    }

    function getProvincia() {
        return $this->provincia;
    }

    function getLocalidad() {
        return $this->localidad;
    }

    function getCalle() {
        return $this->calle;
    }

    function getCondicion_iva() {
        return $this->condicion_iva;
    }

    function getCuit() {
        return $this->cuit;
    }

    function getContacto() {
        return $this->contacto;
    }

    function getServicio() {
        return $this->servicio;
    }

    function getComentario() {
        return $this->comentario;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getCp() {
        return $this->cp;
    }

    function getAltura() {
        return $this->altura;
    }

    function getPiso() {
        return $this->piso;
    }

    function getDpto() {
        return $this->dpto;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    function setLocalidad($localidad) {
        $this->localidad = $localidad;
    }

    function setRazon_social($razon_social) {
        $this->razon_social = $razon_social;
    }

    function setActivo($activo) {
        $this->activo = $activo;
    }

    function setCalle($calle) {
        $this->calle = $calle;
    }

    function setCondicion_iva($condicion_iva) {
        $this->condicion_iva = $condicion_iva;
    }

    function setCuit($cuit) {
        $this->cuit = $cuit;
    }

    function setContacto($contacto) {
        $this->contacto = $contacto;
    }

    function setServicio($servicio) {
        $this->servicio = $servicio;
    }

    function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setCp($cp) {
        $this->cp = $cp;
    }

    function setAltura($altura) {
        $this->altura = $altura;
    }

    function setPiso($piso) {
        $this->piso = $piso;
    }

    function setDpto($dpto) {
        $this->dpto = $dpto;
    }

    public function __construct() {
        $this->setActivo(0);
    }

    public function setea($information, $provincia, $condiva) {
        $this->setProvincia($provincia);
        $this->setCondicion_iva($condiva);
        $this->setAltura($information['proveedor_altura']);
        $this->setCalle($information['proveedor_calle']);
        $this->setComentario($information['proveedor_comentario']);
        $this->setContacto($information['proveedor_contacto']);
        $this->setCp($information['proveedor_cp']);
        $this->setCuit($information['proveedor_cuit']);
        $this->setDpto($information['proveedor_dpto']);
        $this->setLocalidad($information['proveedor_localidad']);
        $this->setPiso($information['proveedor_piso']);
        $this->setRazon_social($information['proveedor_razon_social']);
        $this->setServicio($information['proveedor_servicio']);
        $this->setTelefono($information['proveedor_telefono']);
    }

    function obtenerArray() {
        $arreglo = array("id" => $this->id,
            "razonSocial" => $this->razon_social,
            "activo" => $this->activo,
            "cuit" => $this->cuit,
            "servicio" => $this->servicio,
            "condicionIva" => $this->condicion_iva->getId(),
            "cond_iva_nombre" => $this->condicion_iva->getNombre(),
            "contacto" => $this->contacto,
            "comentario" => $this->comentario,
            "calle" => $this->calle,
            "numero" => $this->altura,
            "piso" => $this->piso,
            "departamento" => $this->dpto,
            "localidad" => $this->localidad,
            "provincia" => $this->provincia->getId(),
            "codigoPostal" => $this->cp,
            "telefono" => $this->telefono
        );
        return $arreglo;
    }

}

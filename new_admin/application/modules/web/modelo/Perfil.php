<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Perfil
 *
 * @Table(name="baires_perfiles")
 * @Entity
 *
 *
 */
class Perfil {
    /**
     *      @var integer $id
     *      @Column(name="id", type="integer", nullable=false)
     *      @Id
     *      @GeneratedValue(strategy="CUSTOM")
     *      @CustomIdGenerator(class="Super_generator")
     */
    protected $id;
    /**
     *
     *      @var string $descripcion
     *
     *      @Column(name="descripcion", type="string", length=255)
     */
    protected $descripcion;
    /**
     *
     *      @var integer $estado
     *
     *      @Column(name="estado", type="integer")
     */
    protected $estado;

    /**
     * Class Perfil
     * @param    $id
     * @param    $descripcion
     * @param    $estado
     */
    public function __construct($id, $descripcion, $estado)
    {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
    }
    /**
     * Gets the value of id.
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Sets the value of id.
     *
     * @param integer $id es el id de la base OJO
     *
     * @return self
     */
    protected function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * Gets the value of descripcion.
     *
     * @return string $descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    /**
     * Sets the value of descripcion.
     *
     * @param string $descripcion texto descriptivo
     *
     * @return self
     */
    protected function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }
    /**
     * Gets the value of estado.
     *
     * @return integer $estado
     */
    public function getEstado()
    {
        return $this->estado;
    }
    /**
     * Sets the value of estado.
     *
     * @param integer $estado si es 1 está vivo, si es 2 está muerto
     *
     * @return self
     */
    protected function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }
}

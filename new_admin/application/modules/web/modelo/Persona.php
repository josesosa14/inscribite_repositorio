<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Persona
 *
 * @Table(name="persona")
 * @Entity
 */
class Persona {

    /**
     * @var integer $id
     *
     * @Column(name="persona_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $nombres
     *
     * @Column(name="persona_nombres", type="string", length=128, nullable=false)
     */
    protected $nombres;

    /**
     * @var string $apellidos
     *
     * @Column(name="persona_apellidos", type="string", length=128, nullable=false)
     */
    protected $apellidos;

    /**
     * @var string $fechaNacimiento
     *
     * @Column(name="persona_fecha_nacimiento", type="string", length=128, nullable=false)
     */
    protected $fechaNacimiento;

    /**
     * @var integer $tipoDeDocumento
     *
     * @Column(name="persona_tipo_documento_id", type="integer", length=2, nullable=false)
     */
    protected $tipoDeDocumento;

    /**
     * @var integer $nroDocumento
     *
     * @Column(name="persona_nro_documento", type="integer", length=128, nullable=false)
     */
    protected $nroDocumento;

    /**
     * @var string $email
     *
     * @Column(name="persona_email", type="string", length=64, nullable=true)
     */
    protected $email;

    /**
     * @var string $telefono
     *
     * @Column(name="persona_telefono", type="string", length=25, nullable=true)
     */
    protected $telefono;

    /**
     * Persona constructor.
     * @param string $nombres
     * @param string $apellidos
     * @param string $fechaNacimiento
     * @param $tipoDeDocumento
     * @param int $nroDocumento
     * @param string $email
     * @param string $telefono
     */
    public function setear($nombres, $apellidos, $fechaNacimiento, $tipoDeDocumento, $nroDocumento, $email, $telefono)
    {
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->tipoDeDocumento = $tipoDeDocumento;
        $this->nroDocumento = $nroDocumento;
        $this->email = $email;
        $this->telefono = $telefono;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param string $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return string
     */
    public function getFechaNacimiento()
    {
        $fechaNacimiento = "";
        if($this->fechaNacimiento != null) {
            $date = DateTime::createFromFormat('Y-m-d', $this->fechaNacimiento);
            $fechaNacimiento = $date->format('d/m/Y');
        }        
        return $fechaNacimiento;
    }

    /**
     * @param string $fechaNacimiento
     */
    public function setFechaNacimiento($fechaNacimiento)
    {

        $date = DateTime::createFromFormat('d/m/Y', $fechaNacimiento );
        $fecha = $date->format('Y-m-d');

        $this->fechaNacimiento = $fecha;
    }

    /**
     * @return mixed
     */
    public function getTipoDeDocumento()
    {
        return $this->tipoDeDocumento;
    }

    /**
     * @param mixed $tipoDeDocumento
     */
    public function setTipoDeDocumento($tipoDeDocumento)
    {
        $this->tipoDeDocumento = $tipoDeDocumento;
    }

    /**
     * @return int
     */
    public function getNroDocumento()
    {
        return $this->nroDocumento;
    }

    /**
     * @param int $nroDocumento
     */
    public function setNroDocumento($nroDocumento)
    {
        $this->nroDocumento = $nroDocumento;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }


    function getTipoDocumentoNombre() {
        return $this->getTipoDeDocumento()->getNombre();
    }

}

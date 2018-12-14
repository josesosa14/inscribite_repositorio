<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Usuario
 *
 * @Table(name="usuario")
 * @Entity
 */
class Usuario {

    /**
     * @var integer $id
     *
     * @Column(name="usuario_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nombreUsuario
     *
     * @Column(name="usuario_nombre", type="string", length=16, nullable=false)
     */
    private $nombreUsuario;

    /**
     * @var string $password
     *
     * @Column(name="usuario_password", type="string", length=256, nullable=false)
     */
    private $password;

    /**
     * @OneToOne(targetEntity="Persona")
     * @JoinColumn(name="usuario_persona_id", referencedColumnName="persona_id")
     * */
    private $persona;

    /**
     * @var string $email
     *
     * @Column(name="usuario_email", type="string", length=64, nullable=false)
     */
    private $email;

    /**
     * @ManyToMany(targetEntity="Rol")
     * @JoinTable(name="usuario_rol",
     *      joinColumns={@JoinColumn(name="ur_usuario_id", referencedColumnName="usuario_id")},
     *      inverseJoinColumns={@JoinColumn(name="ur_rol_id", referencedColumnName="rol_id")}
     *      )
     */
    private $roles;

    /**
     * @var integer $activo
     *
     * @Column(name="usuario_activo", type="integer", length=11, nullable=false)
     */
    private $activo;

    /**
     * @var string $lastlogin
     *
     * @Column(name="usuario_last_login", type="datetime", length=32, nullable=false)
     */
    private $lastlogin;

    /**
     * @var string $fechacreacion
     *
     * @Column(name="usuario_fecha_in", type="datetime", length=32, nullable=false)
     */


    private $fechacreacion;

    function getId() {
        return $this->id;
    }

    function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    function getPassword() {
        return $this->password;
    }

    function getPersona() {
        return $this->persona;
    }

    function getEmail() {
        return $this->email;
    }

    /**
     * [getRoles description]
     * @return Array  array de roles
     */
    function getRoles() {
        return $this->roles;
    }

    function getActivo() {
        return $this->activo;
    }

    function getLastLogin() {
        if($this->lastlogin != null || $this->lastlogin != "") {
            //return $this->lastlogin->format("d/m/Y H:i:s");
            return $this->lastlogin;
        } else {
            return "";
        }

    }

    function getFechaCreacion() {
        //return $this->fechacreacion->format("d/m/Y H:i:s");
        return $this->fechacreacion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setPersona($persona) {
        $this->persona = $persona;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    /**
     * [setRoles description]
     * @param Array $roles array con objetos de tipo rol
     */
    function setRoles($roles) {
        $this->roles = $roles;
    }

    function setActivo($activo) {
        $this->activo = $activo;
    }

    function setLastLogin($lastLogin) {
        $this->lastlogin = $lastLogin;
    }

    function setFechaCreacion($fechaCreacion) {
        $this->fechacreacion = $fechaCreacion;
    }

    public function __construct($persona, $email, $nombre, $activo = 1) {
        $this->roles = new Doctrine\Common\Collections\ArrayCollection();
        $this->actualizar($persona, $email, $nombre, $activo);
    }

    public function actualizar($persona, $email, $nombre, $activo) {
        $this->setPersona($persona);
        $this->setNombreUsuario($nombre);
        $this->setEmail($email);
        $this->setActivo($activo);
    }

    public function getArrayRoles(){
        $array = array();
        foreach($this->getRoles()[0]->getPermisos() as $k => $rol){
            $array[$k]['id'] = $rol->getId();
            $array[$k]['nombre'] = $rol->getNombre();        
        }
        return $array;
    }
}

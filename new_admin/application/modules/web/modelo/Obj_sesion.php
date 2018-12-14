<?php
class Obj_sesion {
    private $logged;
    private $usuarioId;
    private $nombre_usuario;
    private $usuario_rol;
    private $nombre;
    private $apellido;
    private $telefono;
    private $email;
    function __construct() {
        if(isset($_SESSION['logged']) && $_SESSION['logged'] == TRUE) {
            $this->logged = $_SESSION['logged'];
            $this->usuarioId = $_SESSION['usuario_id'];
            $this->nombre_usuario = $_SESSION['nombre_usuario'];
            $this->usuario_rol = $_SESSION['usuario_rol'];
            $this->nombre = $_SESSION['nombre'];
            $this->apellido = $_SESSION['apellido'];
            $this->telefono = $_SESSION['telefono'];
            $this->email = $_SESSION['email'];
        } else {
            $this->logged = FALSE;
        }
    }
    public function isLogged() {
        return $this->logged;
    }
    public function setLogged($logged) {
        $this->logged = $logged;
        return $this;
    }
    /**
     * [getUsuarioId devuelve el id del usuario]
     * @return int id del usuario 
     */
    public function getUsuarioId() {
        return $this->usuarioId;
    }
    public function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;
        return $this;
    }
    /**
     * [getNombreUsuario description]
     * @return string nombre del Usuario != nombre de la persona
     */
    public function getNombreUsuario() {
        return $this->nombre_usuario;
    }
    /**
     * [setNombreUsuario description]
     * @param string $nombre_usuario cambia nombre usuario
     */
    public function setNombreUsuario($nombre_usuario) {
        $this->nombre_usuario = $nombre_usuario;
        return $this;
    }
    public function getUsuarioRol() {
        return $this->usuario_rol;
    }
    public function setUsuarioRol($usuario_rol) {
        $this->usuario_rol = $usuario_rol;
        return $this;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }
    public function getApellido() {
        return $this->apellido;
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido;
        return $this;
    }
    public function getTelefono() {
        return $this->telefono;
    }
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
        return $this;
    }
    /**
     * [getEmail description]
     * @return string [description]
     */
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
}
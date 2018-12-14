<?php 

defined("BASEPATH") OR exit("No direct script access allowed");


/**
 * Consulta
 * 
 * @Table(name="consulta") 
 * @Entity 
 */
class Consulta {


/**
 * @var integer $id
 *
 * @Column(name="con_id", type="integer",nullable=false)
 * @Id
 * @GeneratedValue(strategy="AUTO")
 */
protected $id;

/**
 * @var string $nombre
 *
 * @Column(name="con_nombre", type="string" ,length=200 )
 * 
 */
protected $nombre;

/**
 * @var string $email
 *
 * @Column(name="con_email", type="string" ,length=200 )
 * 
 */
protected $email;

/**
 * @var string $telefono
 *
 * @Column(name="con_telefono", type="string" ,length=100 )
 * 
 */
protected $telefono;

/**
 * @var string $comentarios
 *
 * @Column(name="con_comentarios", type="string" ,length=500 )
 * 
 */
protected $comentarios;

function getId() {
return $this->id;
}

function setId($con_id) {
$this->id = $con_id;
}
function getNombre() {
return $this->nombre;
}

function setNombre($nombre) {
$this->nombre = $nombre;
}
function getEmail() {
return $this->email;
}

function setEmail($email) {
$this->email = $email;
}
function getTelefono() {
return $this->telefono;
}

function setTelefono($telefono) {
$this->telefono = $telefono;
}
function getComentarios() {
return $this->comentarios;
}

function setComentarios($comentarios) {
$this->comentarios = $comentarios;
}
public function getDatosArray(){
$array = array("id" => $this->getId(),
"con_nombre" => $this->getNombre(), 
"con_email" => $this->getEmail(), 
"con_telefono" => $this->getTelefono(), 
"con_comentarios" => $this->getComentarios());
return $array;
}}
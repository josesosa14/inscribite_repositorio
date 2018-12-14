<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Evento_model extends A_Model {

    public function __construct() {
        parent::__construct();
    }

    function getEventosActivos() {
        return $this->orm->createQuery("SELECT e FROM Evento e WHERE e.codigo>0 and e.id>0")->getResult();
    }
    
    

}

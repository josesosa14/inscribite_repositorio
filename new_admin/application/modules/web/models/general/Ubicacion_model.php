<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ubicacion_model extends A_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getPaises() {
        $query = 'select * from pais';
        $sth = $this->prepare($query);
        $sth->execute();
        $paises = $sth->fetchAll(PDO::FETCH_OBJ);
        return $paises;
    }

    public function getProvincias() {
        $query = 'select * from provincias';
        $sth = $this->prepare($query);
        $sth->execute();
        $provincias = $sth->fetchAll(PDO::FETCH_OBJ);
        foreach ($provincias as $provincia) {
            $provincia->nombre = utf8_encode($provincia->nombre);
        }
        return $provincias;
    }

    public function getLocalidadex($provincia_id) {
        $query = 'select * from localidades where id_provincia = ' . $provincia_id;
        $sth = $this->prepare($query);
        $sth->execute();
        $localidades = $sth->fetchAll(PDO::FETCH_OBJ);
        foreach ($localidades as $localidad) {
            $localidad->nombre = utf8_encode($localidad->nombre);
        }
        return $localidades;
    }

    public function getJSONLocalidades($provincia_id) {
        $where = array(
            "id_provincia" => $provincia_id,
        );
        $query = $this->db->get_where("localidades", $where);
        $localidades = $query->result();
        foreach ($localidades as $localidad) {
            $localidad->nombre = utf8_encode($localidad->nombre);
        }
        return $localidades;
    }

}

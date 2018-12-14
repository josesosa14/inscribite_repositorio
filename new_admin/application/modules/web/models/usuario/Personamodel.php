<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PersonaModel extends A_Model {

    public function __construct() {
        parent::__construct();
        $this->setTabla("persona");
    }

    public function borrarPersona(Persona $persona) {
        $this->db->delete($this->getTabla(), array('persona_id' => $persona->getId()));
    }

    public static function datosAObjeto($datos) {
        $persona = new Persona();
        $persona->setId($datos->persona_id);
        $persona->setNombres($datos->persona_nombres);
        $persona->setApellidos($datos->persona_apellidos);
        $persona->setFechaNacimiento($datos->persona_fecha_nacimiento);
        $persona->setNroDocumento($datos->persona_nro_documento);
        $persona->setCuit($datos->persona_cuit);
        return $persona;
    }

    public function guardar(Persona $persona) {

        if ($persona->getId() != "") {
            $datos = $this->personaADAtos($persona);
            $this->db->where('persona_id', $persona->getId());
            $this->db->update($this->getTabla(), $datos);
        } else {
            $datos = $this->personaADAtos($persona);
            $this->db->insert($this->getTabla(), $datos);
            $this->persona->setId($this->db->insert_id());
        }
        return $persona;
    }

    public function personaADAtos(Persona $persona) {
        $datos = array(
            "persona_nombres" => $persona->getNombres(),
            "persona_apellidos" => $persona->getApellidos()
        );
        return $datos;
    }

    function buscar($id = false) {
        if ($id) {
            $where = array(
                "persona_id" => $id
            );
            $query = $this->db->get_where($this->getTabla(), $where);
            if ($query->num_rows() > 0) {
                return $this->datosAObjeto($query->row());
            } else {
                return false;
            }
        }
    }

    function listar() {
        $query = $this->db->get($this->getTabla());
        $personas = array();
        foreach ($query->result() as $datos) {
            array_push($personas, $this->datosAObjeto($datos));
        }
        return $personas;
    }

}

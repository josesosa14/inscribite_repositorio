<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PermisoModel extends A_Model {

    

    public function __construct() {
        parent::__construct();
        $this->setTabla("permiso");
        
        
    }

    public function borrarPermiso(Permiso $permiso) {
        $this->db->delete($this->getTabla(), array('permiso_id' => $permiso->getId()));
    }

    public static function datosAObjeto($datos) {
        $permiso = new Permiso();
        $permiso->setId($datos->permiso_id);
        $permiso->setNombre($datos->permiso_nombre);
        $permiso->setDescripcion($datos->permiso_descripcion);
        $permiso->setPeso($datos->permiso_peso);
        $permiso->setFechaCreacion($datos->permiso_fecha_in);
        return $permiso;
    }

    public function guardar(Permiso $permiso) {
        
        if ($this->permiso->getId() != "") {
            $datos = $this->objetoADatos($permiso);
            $this->db->where('permiso_id', $permiso->getId());
            $this->db->update($this->getTabla(), $datos);
        } else {
            $datos = $this->objetoADatos($permiso);
            $this->db->insert($this->getTabla(), $datos);
            $this->permiso->setId($this->db->insert_id());
        }
    }

    public function objetoADatos(Permiso $permiso) {
        $datos = array(
            "permiso_nombre" => $permiso->getNombre(),
            "permiso_descripcion" => $permiso->getDescripcion(),
            "permiso_peso" => $permiso->getPeso(),
        );
        return $datos;
    }

    function buscar($id) {
        $where = array(
            "permiso_id" => $id
        );
        $query = $this->db->get_where($this->getTabla(), $where);
        if ($query->num_rows() > 0) {
            return $this->datosAObjeto($query->row());
        } else {
            return false;
        }
    }

    function listar() {
        $query = $this->db->get($this->getTabla());
        $permisos = array();
        foreach ($query->result() as $datos) {
            array_push($permisos, $this->datosAObjeto($datos));
        }
        return $permisos;
    }

    function getPermisosPorRol($idRol) {
        $where = array(
            "rp_rol_id" => $idRol
        );
        $query = $this->db->get_where("roles_y_permisos", $where);
        $permisos = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $permiso = $this->datosAObjeto($row);
                array_push($permisos, $permiso);
            }
        }
        return $permisos;
    }

}

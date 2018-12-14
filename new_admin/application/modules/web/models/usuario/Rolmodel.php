<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RolModel extends A_Model {

    public function __construct() {
        parent::__construct();
        $this->setTabla("rol");
        //$this->cargarClase("usuario/rol");
        $this->load->model("usuario/permisoModel");
    }

    public function borrarRol(Rol $rol) {
        $this->db->delete($this->getTabla(), array('rol_id' => $rol->getId()));
    }

    public static function datosAObjeto($datos) {
        $rol = new Rol();
        $rol->setId($datos->rol_id);
        $rol->setNombre($datos->rol_nombre);
        $rol->setDescripcion($datos->rol_descripcion);
        $rol->setPeso($datos->rol_peso);
        $rol->setFechaCreacion($datos->rol_fecha_in);
        return $rol;
    }

    public function guardar(Rol $rol) {

        if ($rol->getId() != "") {
            $datos = $this->rolADatos($rol);
            $this->db->where('rol_id', $rol->getId());
            $this->db->update($this->getTabla(), $datos);
            $this->limpiarPermisosDeUnRol($rol);
            $this->guardarPermisosDeUnRol($rol);
        } else {
            $datos = $this->rolADatos($rol);
            $this->db->insert($this->getTabla(), $datos);
            $this->rol->setId($this->db->insert_id());
        }
    }

    public function rolADatos(Rol $rol) {
        $datos = array(
            "rol_nombre" => $rol->getNombre(),
            "rol_descripcion" => $rol->getDescripcion(),
            "rol_peso" => $rol->getPeso(),
        );
        return $datos;
    }

    function buscar($id) {
        $where = array(
            "rol_id" => $id
        );
        $query = $this->db->get_where($this->getTabla(), $where);
        if ($query->num_rows() > 0) {
            $rol = $this->datosAObjeto($query->row());
            $rol->setPermisos($this->permisoModel->getPermisosPorRol($rol->getId()));
            return $rol;
        } else {
            return false;
        }
    }

    function listar() {
        $query = $this->db->get($this->getTabla());
        $roles = array();
        foreach ($query->result() as $datos) {
            $rol = $this->datosAObjeto($datos);
            $rol->setPermisos($this->permisoModel->getPermisosPorRol($rol->getId()));
            array_push($roles, $rol);
        }
        return $roles;
    }

    function asignarPermisoARol(Rol $rol, Permiso $permisoNuevo) {
        $respuesta = true;
        foreach ($rol->getPermisos() as $permiso) {
            if ($permiso->getId() == $permisoNuevo->getId()) {
                $respuesta = false;
            }
        }
        if ($respuesta) {
            $datos = array(
                "rol_id" => $rol->getId(),
                "permiso_id" => $permisoNuevo->getId()
            );
            $this->db->insert("rol_permiso", $datos);
            $rol->agregarPermiso($permisoNuevo);
        }
    }

    function quitarPermisoARol($idRol, $idPermiso) {
        $where = array(
            "rol_id" => $idRol,
            "permiso_id" => $idPermiso
        );
        $this->db->delete("rol_permiso", $where);
    }

    function limpiarPermisosDeUnRol(Rol $rol) {
        $where = array(
            "rp_rol_id" => $rol->getId(),
        );
        $this->db->delete("rol_permiso", $where);
    }

    function guardarPermisosDeUnRol(Rol $rol) {
        $permisos = array();
        foreach ($rol->getPermisos() as $permiso) {
            $datos = array(
                "rp_rol_id" => $rol->getId(),
                "rp_permiso_id" => $permiso->getId()
            );
            array_push($permisos, $datos);
        }
        if(count($permisos)>0) {
            $this->db->insert_batch("rol_permiso",$permisos);
        }
    }
    
    function getRolesPorUsuario($idUsuario) {
        $where = array(
            "ur_usuario_id" => $idUsuario
        );
        $query = $this->db->get_where("usuario_rol", $where);
        $roles = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $where = array(
                    "rol_id" => $row->ur_rol_id
                );
                $query = $this->db->get_where($this->getTabla(), $where);
                $datos = $query->row();
                $rol = $this->datosAObjeto($datos);
                array_push($roles, $rol);
            }
        }
        return $roles;
    }

}

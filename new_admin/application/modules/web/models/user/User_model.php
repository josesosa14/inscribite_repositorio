<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class User_model extends A_Model {

    public function __construct() {

        parent::__construct();
    }

    public function getById($id) {
        return $this->getCollectionByid("User", $id);
    }

    public function insertar($information) {
        if ($information["usr_id"]) {
            $user = $this->getCollectionByid("User", $information["usr_id"]);
        } else {
            $user = new User();
            $this->orm->persist($user);
        }
        $user->setNombre($information["usr_nombre"]);
        $user->setFbid($information["usr_fbid"]);
        $user->setFbuser($information["usr_fbuser"]);
        $user->setEmail($information["usr_email"]);
        $user->setClave($information["usr_clave"]);
        $user->setTelefono($information["usr_telefono"]);
        $user->setDireccion($information["usr_direccion"]);
        $user->setBarrio($information["usr_barrio"]);
        $user->setLocalidad($information["usr_localidad"]);
        $user->setHorario_entrega($information["usr_horario_entrega"]);
        $user->setDireccion_secundaria($information["usr_direccion_secundaria"]);
        $user->setFecha_in($information["usr_fecha_in"]);
        $user->setCant_logeo($information["usr_cant_logeo"]);
        $user->setLast_logeo($information["usr_last_logeo"]);
        $user->setActivo($information["usr_activo"]);
        $this->orm->flush();
    }

    public function getUserAjax($information) {
        $out = array();
        $where_venta = "";
        if ($information["limit"]) {
            $limit = $information["limit"];
        } else {
            $limit = 20;
        }
        $offset = 0;
        if ($information["offset"]) {
            $offset = $information["offset"];
        }
        $orden = "ASC";
        switch ($information["order"]) {
            case "asc" :
                $orden = "ASC";
                break;
            case "desc" :
                $orden = "DESC";
                break;
        }

        $query = $this->orm->createQuery("SELECT c FROM User c WHERE c.activo = 1 $where_venta ORDER BY c.nombre ASC,c.email ASC")->setFirstResult($offset)->setMaxResults($limit);
        $users = $query->getResult();
        $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM User c WHERE c.activo = 1 $where_venta")->setMaxResults(1)->getSingleScalarResult();
        foreach ($users as $user) {
            $out [] = $user->getDatosArray();
        }
        $data ["rows"] = $out;
        return $data;
    }

    public function getPerfil() {
        return $this->orm->createQuery("SELECT u FROM User u WHERE u.id = :id")->setParameter("id", $_SESSION['usuario']->getId())->getSingleResult();
    }

    public function validar($information) {
        $usuario = $this->orm->createQuery("SELECT u FROM User u JOIN u.vinos_consumidos v WHERE u.nombre = :nombre OR u.email = :nombre AND u.clave = :password")
                        ->setParameters(array("nombre" => $information['email'], "password" => $information['password']))->getResult();
        if ($usuario) {
            $this->db->query("UPDATE users SET usr_cant_logeo = usr_cant_logeo+1,usr_last_login= NOW() WHERE usr_id={$usuario[0]->getId()}");
            $_SESSION['usuario'] = $usuario[0];
            return true;
        } else {
            return false;
        }
    }

    public function actualizaPerfil($information) {
        $user_logeado = $this->getPerfil();
        $usuario = $this->getCollectionByid("User", $user_logeado->getId());
        $usuario->setTelefono($information['celular']);
        $usuario->setNombre($information['nombre']);
        $usuario->setDireccion($information['direccion']);
        $usuario->setBarrio($information['barrio']);
        $usuario->setLocalidad($information['localidad']);
        $usuario->setHorario_entrega($information['horario_entrega']);
        $usuario->setEmail($information['email']);
        $this->orm->flush();
    }

}

<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Listadifusion_model extends A_Model {

    public function __construct() {

        parent::__construct();
    }

    public function getById($id) {
        return $this->getCollectionByid("Listadifusion", $id);
    }

    public function insertar($information) {
        try {
            if ($information["lis_id"]) {
                $listadifusion = $this->getCollectionByid("Listadifusion", $information["lis_id"]);
            } else {
                $listadifusion = new Listadifusion();
                $listadifusion->setFecha(new \DateTime());
                $this->orm->persist($listadifusion);
            }
            $listadifusion->setNombre($information["lis_nombre"]);     
            $listadifusion->setUsuario($this->orm->getReference("Usuario", $this->session->userdata["id_usuario"]));
            $this->orm->flush();
            $this->db->query("DELETE FROM listadifusion_renglones WHERE ldr_lis_id=".$listadifusion->getId());
            foreach ($information["renglones"] as $renglon) {
                $lista_renglon = new Listadifusionrenglones();
                $lista_renglon->setLista($listadifusion);
                $lista_renglon->setUsuario($this->orm->getReference("Guardavida", $renglon));
                $this->orm->persist($lista_renglon);
            }
            $this->orm->flush();
        } catch (Exception $ex) {
            echo $ex . '<br>';
            die('fallamos');
        }
    }

    public function getListadifusionAjax($information) {
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

        $query = $this->orm->createQuery("SELECT c FROM Listadifusion c  $where_venta")->setFirstResult($offset)->setMaxResults($limit);
        $listadifusions = $query->getResult();
        $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Listadifusion c $where_venta")->setMaxResults(1)->getSingleScalarResult();
        foreach ($listadifusions as $listadifusion) {
            $out [] = $listadifusion->getDatosArray();
        }
        $data ["rows"] = $out;
        return $data;
    }

}

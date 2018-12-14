<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Consulta_model extends A_Model {

    public function __construct() {

        parent::__construct();
    }

    public function getById($id) {
        return $this->getCollectionByid("Consulta", $id);
    }

    public function insertar($information) {
        if ($information["con_id"]) {
            $consulta = $this->getCollectionByid("Consulta", $information["con_id"]);
        } else {
            $consulta = new Consulta();
            $this->orm->persist($consulta);
        }
        //si viene por form web de imc
        if ($information['t'] == "imc") {
            if (is_numeric($information['con_email'])) {
                $consulta->setTelefono($information["con_email"]);
                $consulta->setEmail("");
            } else {
                $consulta->setEmail($information["con_email"]);
                $consulta->setTelefono("");
            }
            $consulta->setNombre(substr($information["con_email"], 0, strpos($information['con_email'], "@")));
            $consulta->setComentarios("Por calculadora de IMC ".$information['con_comentarios']);
        } else {
            $consulta->setNombre($information["con_nombre"]);
            $consulta->setEmail($information["con_email"]);
            $consulta->setTelefono($information["con_telefono"]);
            $consulta->setComentarios($information["con_comentarios"]);
        }
        $this->orm->flush();
    }

    public function getConsultaAjax($information) {
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

        $query = $this->orm->createQuery("SELECT c FROM Consulta c $where_venta")->setFirstResult($offset)->setMaxResults($limit);
        $consultas = $query->getResult();
        $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Consulta c $where_venta")->setMaxResults(1)->getSingleScalarResult();
        foreach ($consultas as $consulta) {
            $out [] = $consulta->getDatosArray();
        }
        $data ["rows"] = $out;
        return $data;
    }

}

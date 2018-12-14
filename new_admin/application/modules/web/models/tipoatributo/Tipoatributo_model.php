<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Tipoatributo_model extends A_Model {

    public function __construct() {

        parent::__construct();
    }

    public function getById($id) {
        return $this->getCollectionByid("Tipoatributo", $id);
    }

    public function borrar($id) {
        $objeto = $this->getCollectionByid("Tipoatributo", $id);
        if ($objeto->getActivo()) {
            $objeto->setActivo(0);
        } else {
            $objeto->setActivo(1);
        }
        $this->orm->flush();
    }

    public function insertar($information) {
        if ($information["tip_id"]) {
            $tipoatributo = $this->getCollectionByid("Tipoatributo", $information["tip_id"]);
        } else {
            $tipoatributo = new Tipoatributo();
            $tipoatributo->setCreated_at(new \DateTime());
            $this->orm->persist($tipoatributo);
        }
        $tipoatributo->setNombre($information["tip_nombre"]);
        $tipoatributo->setActivo(isset($information["tip_activo"]) ? 1 : 0);
        $tipoatributo->setModified_at(new \DateTime());
        $this->orm->flush();
    }

    public function getTipoatributoAjax($information) {
        $out = array();
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

        $sort = "c.nombre";
        if (isset($information["sort"])) {
            $sort = "c.{$information["sort"]}";
        }

        if (isset($information["search"])) {
            $where = "WHERE c.nombre like :busqueda";
            $query = $this->orm->createQuery("SELECT c FROM Tipoatributo c $where ORDER BY $sort $orden")->setParameter("busqueda", "%" . $information["search"] . "%")->setFirstResult($offset)->setMaxResults($limit);
            $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Tipoatributo c $where")->setParameter("busqueda", "%" . $information["search"] . "%")->setMaxResults(1)->getSingleScalarResult();
        } else {
            $query = $this->orm->createQuery("SELECT c FROM Tipoatributo c  ORDER BY $sort $orden")->setFirstResult($offset)->setMaxResults($limit);
            $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Tipoatributo c ")->setMaxResults(1)->getSingleScalarResult();
        }
        $tipoatributos = $query->getResult();
        foreach ($tipoatributos as $tipoatributo) {
            $out [] = $tipoatributo->getDatosArray();
        }
        $data ["rows"] = $out;
        return $data;
    }

    public function getTipoAtributos() {
        return $this->orm->createQuery("SELECT t FROM Tipoatributo t WHERE t.activo=1")->getResult();
    }

}

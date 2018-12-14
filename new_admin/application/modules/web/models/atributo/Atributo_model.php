<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Atributo_model extends A_Model {

    public function __construct() {

        parent::__construct();
    }

    public function getById($id) {
        return $this->getCollectionByid("Atributo", $id);
    }

    public function borrar($id) {
        $objeto = $this->getCollectionByid("Atributo", $id);
        if ($objeto->getActivo()) {
            $objeto->setActivo(0);
        } else {
            $objeto->setActivo(1);
        }
        $this->orm->flush();
    }

    public function insertar($information) {
        if ($information["atr_id"]) {
            $atributo = $this->getCollectionByid("Atributo", $information["atr_id"]);
        } else {
            $atributo = new Atributo();
            $atributo->setCreated_at(new \DateTime());
            $this->orm->persist($atributo);
        }
        $atributo->setTipoAtributo($this->orm->getReference("Tipoatributo", $information["tipo"]));
        $atributo->setNombre($information["atr_nombre"]);
        $atributo->setActivo(isset($information["atr_activo"]) ? 1 : 0);
        $atributo->setModified_at(new \DateTime());
        $this->orm->flush();
        
    }
    

    public function getAtributoAjax($information) {
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
            $query = $this->orm->createQuery("SELECT c FROM Atributo c $where ORDER BY $sort $orden")->setParameter("busqueda", "%" . $information["search"] . "%")->setFirstResult($offset)->setMaxResults($limit);
            $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Atributo c $where")->setParameter("busqueda", "%" . $information["search"] . "%")->setMaxResults(1)->getSingleScalarResult();
        } else {
            $query = $this->orm->createQuery("SELECT c FROM Atributo c  ORDER BY $sort $orden")->setFirstResult($offset)->setMaxResults($limit);
            $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Atributo c ")->setMaxResults(1)->getSingleScalarResult();
        }
        $atributos = $query->getResult();
        foreach ($atributos as $atributo) {
            $out [] = $atributo->getDatosArray();
        }
        $data ["rows"] = $out;
        return $data;
    }

}

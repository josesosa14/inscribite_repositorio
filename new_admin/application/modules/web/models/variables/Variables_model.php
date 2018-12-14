<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Variables_model extends A_Model {

    public function __construct() {

        parent::__construct();
    }

    public function getById($id) {
        return $this->getCollectionByid("Variables", $id);
    }

    public function insertar($information) {
        $variables=$this->getCollectionByid("Variables", 1);
        $variables->setPorc_comision_rp($information["var_porc_comision_rp"]);
        $variables->setPorc_comision_pf($information["var_porc_comision_pf"]);
        $variables->setPorc_comision_pmc($information["var_porc_comision_pmc"]);
        $variables->setPorc_efectivo_rp($information["var_porc_efectivo_rp"]);
        $variables->setPorc_efectivo_pf($information["var_porc_efectivo_pf"]);
        $variables->setPorc_efectivo_pmc($information["var_porc_efectivo_pmc"]);
        $variables->setPorc_iva($information["var_porc_iva"]);
        $this->orm->flush();
    }

    public function getVariablesAjax($information) {
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

        $query = $this->orm->createQuery("SELECT c FROM Variables c $where_venta")->setFirstResult($offset)->setMaxResults($limit);
        $variabless = $query->getResult();
        $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Variables c $where_venta")->setMaxResults(1)->getSingleScalarResult();
        foreach ($variabless as $variables) {
            $out [] = $variables->getDatosArray();
        }
        $data ["rows"] = $out;
        return $data;
    }

}

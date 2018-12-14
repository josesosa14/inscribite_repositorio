<?php 

        defined("BASEPATH") OR exit("No direct script access allowed");

        class Empresacuenta_model extends A_Model {

            public function __construct() {

                parent::__construct();

            }

            
            public function getById($id) {
               return $this->getCollectionByid("Empresacuenta", $id);
            }


            public function insertar($information) {
                if ($information["emp_id"]) {
$empresacuenta = $this->getCollectionByid("Empresacuenta", $information["emp_id"]);
} else {
$empresacuenta = new Empresacuenta();
$this->orm->persist($empresacuenta);
}
$empresacuenta->setCbu($information["emp_cbu"]);$empresacuenta->setAlias($information["emp_alias"]);$empresacuenta->setCuit($information["emp_cuit"]);$empresacuenta->setEmpresa($information["emp_empresa"]);$empresacuenta->setBanco($information["emp_banco"]);$empresacuenta->setActiva($information["emp_activa"]);$this->orm->flush();
}


public function getEmpresacuentaAjax($information) {
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

$query = $this->orm->createQuery("SELECT c FROM Empresacuenta c $where_venta")->setFirstResult($offset)->setMaxResults($limit);
$empresacuentas = $query->getResult();
$data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Empresacuenta c $where_venta")->setMaxResults(1)->getSingleScalarResult();
foreach ($empresacuentas as $empresacuenta) {
$out [] = $empresacuenta->getDatosArray();
}
$data ["rows"] = $out;
return $data;
}


}
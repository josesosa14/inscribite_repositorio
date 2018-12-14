<?php 

        defined("BASEPATH") OR exit("No direct script access allowed");

        class Decodificado_renglones_model extends A_Model {

            public function __construct() {

                parent::__construct();

            }

            
            public function getById($id) {
               return $this->getCollectionByid("Decodificado_renglones", $id);
            }


            public function insertar($information) {
                if ($information["dec_id"]) {
$decodificado_renglones = $this->getCollectionByid("Decodificado_renglones", $information["dec_id"]);
} else {
$decodificado_renglones = new Decodificado_renglones();
$this->orm->persist($decodificado_renglones);
}
$decodificado_renglones->setMediodecodificado($information["dec_mediodecodificado"]);$decodificado_renglones->setDni($information["dec_dni"]);$decodificado_renglones->setCodigo($information["dec_codigo"]);$decodificado_renglones->setImporte($information["dec_importe"]);$decodificado_renglones->setFechapago($information["dec_fechapago"]);$this->orm->flush();
}


public function getDecodificado_renglonesAjax($information) {
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

$query = $this->orm->createQuery("SELECT c FROM Decodificado_renglones c $where_venta")->setFirstResult($offset)->setMaxResults($limit);
$decodificado_rengloness = $query->getResult();
$data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Decodificado_renglones c $where_venta")->setMaxResults(1)->getSingleScalarResult();
foreach ($decodificado_rengloness as $decodificado_renglones) {
$out [] = $decodificado_renglones->getDatosArray();
}
$data ["rows"] = $out;
return $data;
}


}
<?php 

        defined("BASEPATH") OR exit("No direct script access allowed");

        class Mediodecodificado_model extends A_Model {

            public function __construct() {

                parent::__construct();

            }

            
            public function getById($id) {
               return $this->getCollectionByid("Mediodecodificado", $id);
            }


            public function insertar($information) {
                if ($information["med_id"]) {
$mediodecodificado = $this->getCollectionByid("Mediodecodificado", $information["med_id"]);
} else {
$mediodecodificado = new Mediodecodificado();
$this->orm->persist($mediodecodificado);
}
$mediodecodificado->setTipo($information["med_tipo"]);$mediodecodificado->setCant_registros($information["med_cant_registros"]);$mediodecodificado->setTotal($information["med_total"]);$mediodecodificado->setFecha($information["med_fecha"]);$mediodecodificado->setNombre_archivo($information["med_nombre_archivo"]);$this->orm->flush();
}


public function getMediodecodificadoAjax($information) {
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

$query = $this->orm->createQuery("SELECT c FROM Mediodecodificado c $where_venta")->setFirstResult($offset)->setMaxResults($limit);
$mediodecodificados = $query->getResult();
$data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Mediodecodificado c $where_venta")->setMaxResults(1)->getSingleScalarResult();
foreach ($mediodecodificados as $mediodecodificado) {
$out [] = $mediodecodificado->getDatosArray();
}
$data ["rows"] = $out;
return $data;
}


}
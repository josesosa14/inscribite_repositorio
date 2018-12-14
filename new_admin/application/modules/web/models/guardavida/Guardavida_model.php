<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Guardavida_model extends A_Model {
    /* @var $guardavida Guardavida */

    public function __construct() {

        parent::__construct();
    }

    public function getById($id) {
        return $this->getCollectionByid("Guardavida", $id);
    }

    public function borrar($id) {
        $objeto = $this->getCollectionByid("Guardavida", $id);
        if ($objeto->getActivo()) {
            $objeto->setActivo(0);
        } else {
            $objeto->setActivo(1);
        }
        $this->orm->flush();
    }

    public function insertar($information) {
        if ($information["gua_id"]) {
            $guardavida = $this->getCollectionByid("Guardavida", $information["gua_id"]);
        } else {
            $guardavida = new Guardavida();
            $guardavida->setCreated_at(new \DateTime());
            $this->orm->persist($guardavida);
        }
        $guardavida->setNombre($information["gua_nombre"]);
        $guardavida->setApellido($information["gua_apellido"]);
        $guardavida->setDni($information["gua_dni"]);
        $guardavida->setDomicilio($information["gua_domicilio"]);
        $guardavida->setProvincia($information["gua_provincia"]);
        $guardavida->setLocalidad($information["gua_localidad"]);
        $guardavida->setCodpostal($information["gua_codpostal"]);
        $guardavida->setTelfijo($information["gua_telfijo"]);
        $guardavida->setTelcelular($information["gua_telcelular"]);
        $guardavida->setEmail($information["gua_email"]);
        $guardavida->setPassword($information["gua_password"]);
        $guardavida->setNosconocio($information["gua_nosconocio"]);
        $guardavida->setTipousuario($information["gua_tipousuario"]);
        $guardavida->setActivo(isset($information["gua_activo"]) ? 1 : 0);
        $guardavida->setModified_at(new \DateTime());
        if (isset($_FILES['gua_foto']) && $_FILES['gua_foto']['name']) {
            $nombre_foto = guardarFoto($_FILES['gua_foto'], FOTOS_GUARDAVIDAS, uniqid("guardavida_"), true, 1024, 680, true);
            $guardavida->setFoto($nombre_foto);
        }
        $this->orm->flush();
        $this->insertaAtributos($guardavida, $information["atributos"]);
    }

    private function insertaAtributos(&$guardavida, $atributos) {
        $array_atributos = new Doctrine\Common\Collections\ArrayCollection;
        if ($atributos) {
            $this->limpiarArrayCollection($guardavida->getGuarda_atributos());
            foreach ($atributos as $atr_id => $valor_atributo) {
                $guarda_atributo = new Guardavidaatributo();
                $guarda_atributo->setGuardavida($guardavida);
                $guarda_atributo->setAtributo($this->orm->getReference("Atributo", $atr_id));
                $guarda_atributo->setValor($valor_atributo);
                $this->orm->persist($guarda_atributo);
                $array_atributos[] = $guarda_atributo;
            }
            $guardavida->setGuarda_atributos($array_atributos);
            $this->orm->flush();
        }
    }

    public function getGuardavidaAjax($information) {
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
            $where = "WHERE c.nombre like :busqueda OR c.apellido like :busqueda OR c.dni like :busqueda OR c.domicilio like :busqueda OR c.provincia like :busqueda OR c.localidad like :busqueda OR c.codpostal like :busqueda OR c.telfijo like :busqueda OR c.telcelular like :busqueda OR c.foto like :busqueda OR c.email like :busqueda OR c.password like :busqueda OR c.nosconocio like :busqueda OR c.tipousuario like :busqueda";
            $query = $this->orm->createQuery("SELECT c FROM Guardavida c $where ORDER BY $sort $orden")->setParameter("busqueda", "%" . $information["search"] . "%")->setFirstResult($offset)->setMaxResults($limit);
            $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Guardavida c $where")->setParameter("busqueda", "%" . $information["search"] . "%")->setMaxResults(1)->getSingleScalarResult();
        } else {
            $query = $this->orm->createQuery("SELECT c FROM Guardavida c  ORDER BY $sort $orden")->setFirstResult($offset)->setMaxResults($limit);
            $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Guardavida c ")->setMaxResults(1)->getSingleScalarResult();
        }
        $guardavidas = $query->getResult();
        foreach ($guardavidas as $guardavida) {
            $out [] = $guardavida->getDatosArray();
        }
        $data ["rows"] = $out;
        return $data;
    }

    function insertaDesdeWeb($information) {

        $guardavida = $this->getCollectionByid("Guardavida", $information["gua_id"]);
        $guardavida->setCreated_at(new \DateTime());
        $guardavida->setNombre($information["gua_nombre"]);
        $guardavida->setApellido($information["gua_apellido"]);
        $guardavida->setDni($information["gua_dni"]);
        $guardavida->setDomicilio($information["gua_domicilio"]);
        $guardavida->setProvincia($information["gua_provincia"]);
        $guardavida->setLocalidad($information["gua_localidad"]);
        $guardavida->setCodpostal($information["gua_codpostal"]);
        $guardavida->setTelfijo($information["gua_telfijo"]);
        $guardavida->setTelcelular($information["gua_telcelular"]);
        $guardavida->setEmail($information["gua_email"]);
        $guardavida->setPassword($information["gua_password"]);
        $guardavida->setNosconocio($information["gua_nosconocio"]);
        $guardavida->setTipousuario($information["gua_tipousuario"]);
        $guardavida->setActivo(isset($information["gua_activo"]) ? 1 : 0);
        $guardavida->setModified_at(new \DateTime());

        if (isset($_FILES['gua_foto']) && $_FILES['gua_foto']['name']) {
            $nombre_foto = guardarFoto($_FILES['gua_foto'], FOTOS_GUARDAVIDAS, uniqid("guardavida_"), true, 1024, 680, true);
            $guardavida->setFoto($nombre_foto);
        }
        $this->orm->persist($guardavida);
        $this->orm->flush();
        $this->mandaMail(TEST_MAIL2, "Nuevo guardavida registrado", "se han completado los datos de " . $guardavida->getEmail());
    }

    public function getEmailsByAjax($args) {
        /* @var $guardavida Guardavida */
        $usuarios = $this->orm->createQuery("SELECT u FROM Guardavida u WHERE u.email like :busqueda")->setParameter("busqueda", "%" . $args["q"]["term"] . "%")->getResult();
        if ($usuarios) {
            foreach ($usuarios as $usuario) {
                $data[] = array("id" => $usuario->getId(), "text" => $usuario->getEmail());
            }
        } else {
            $data[] = array("id" => "0", "text" => "No se encontraron resultados..");
        }
        $ret['results'] = $data;
        return $ret;
    }

    public function getGuardavidaByEmail($gua_id) {
        /* @var $guardavida Guardavida */
        $guardavida = $this->orm->createQuery("SELECT g FROM Guardavida g WHERE g.id=:id")->setParameter("id", $gua_id)->getSingleResult();
        if ($guardavida) {
            return $guardavida;
        }
        return false;
    }

}

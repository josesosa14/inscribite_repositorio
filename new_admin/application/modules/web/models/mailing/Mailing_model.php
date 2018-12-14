<?php

defined("BASEPATH") OR exit("No direct script access allowed");

Use Mailgun\Mailgun;

class Mailing_model extends A_Model {

    public function __construct() {

        parent::__construct();
    }

    public function getById($id) {
        return $this->getCollectionByid("Mailing", $id);
    }

    public function insertar($information) {
        if (isset($information["mai_id"])) {
            $mailing = $this->getCollectionByid("Mailing", $information["mai_id"]);
        } else {
            $mailing = new Mailing();
            $this->orm->persist($mailing);
        }
        $mailing->setSubject($information["mai_subject"]);
        $mailing->setMensaje($information["mai_message"]);
        $mailing->setFecha_in(new \DateTime());
        $usuario = $this->getCollectionByid("Usuario", $this->session->userdata["id_usuario"]);
        $mailing->setUsuario($usuario);
        $this->orm->flush();

        /* @var $lista Listadifusion */
        if (isset($information["listas"])) {
            foreach ($information["listas"] as $lista) {
                $lista = $this->getCollectionByid("Listadifusion", $lista);
                $mensaje = $mailing->getMensaje();
                if (isset($information["formulario_guardavida"])) {
                    $query = "insert into mailing_renglones(mar_mai_id,mar_destino,mar_fecha_in,mar_mensaje,mar_guardavida) select '{$mailing->getId()}' mai_id,gua_email,now(),
                CONCAT('$mensaje <br><a href=\'" . base_url("registro-guardavida/") . "',gua_id,'\'>Complete sus datos</a>')  mar_mensaje,gua_id
                from listadifusion
                inner join listadifusion_renglones on ldr_lis_id=lis_id
                inner join guardavida on gua_id=ldr_usu_id
                where lis_id=" . $lista->getId();
                } else {
                    $query = "insert into mailing_renglones(mar_mai_id,mar_destino,mar_fecha_in,mar_mensaje,mar_guardavida) select '{$mailing->getId()}' mai_id,gua_email,now(),
                '$mensaje'  mar_mensaje,gua_id
                from listadifusion
                inner join listadifusion_renglones on ldr_lis_id=lis_id
                inner join guardavida on gua_id=ldr_usu_id
                where lis_id=" . $lista->getId();
                }

                $this->db->query($query);
            }
        }
        if (isset($information["destinos"])) {
            foreach ($information["destinos"] as $k => $cada_destino) {
                $guardavida = $this->getCollectionByid("Guardavida", $cada_destino);
                if ($guardavida) {
                    $mailing_renglon = new Mailingrenglones();
                    $mailing_renglon->setMail_cabecera($mailing);
                    $mailing_renglon->setFecha_in(new \DateTime());
                    $mailing_renglon->setMensaje($mailing->getMensaje());
                    $mailing_renglon->setDestino($guardavida->getEmail());
                    $mailing_renglon->setGuardavida($guardavida);
                    if (isset($information["formulario_guardavida"])) {
                        $mailing_renglon->setMensaje($mailing->getMensaje() . '<br><a href="' . base_url("registro-guardavida/" . $guardavida->getId()) . '" ></a>');
                    }
                    $this->orm->persist($mailing_renglon);
                }
            }
            $this->orm->flush();
        }
        if (ENVIRONMENT == "local") {
            $cmdLinux = "php " . PATH_CLI_LOCAL . " enviarCorreo {$mailing->getId()} > /dev/null 2>&1 &";
        } else {
            $cmdLinux = "php " . PATH_CLI_DEV . " enviarCorreo {$mailing->getId()} > /dev/null 2>&1 &";
        }
        exec($cmdLinux);
    }

    public function getMailingAjax($information) {
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
        $orden = "DESC";
        switch ($information["order"]) {
            case "asc" :
                $orden = "ASC";
                break;
            case "desc" :
                $orden = "DESC";
                break;
        }

        $query = $this->orm->createQuery("SELECT c FROM Mailing c $where_venta ORDER BY c.id DESC")->setFirstResult($offset)->setMaxResults($limit);
        $mailings = $query->getResult();
        $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Mailing c $where_venta")->setMaxResults(1)->getSingleScalarResult();
        foreach ($mailings as $mailing) {
            $out [] = $mailing->getDatosArray();
        }
        $data ["rows"] = $out;
        return $data;
    }

    function nuevoMail($mail_id) {
        /* @var $mailing Mailing */
        /* @var $destino Mailingrenglones */
        $mailing = $this->getCollectionByid("Mailing", $mail_id);

        foreach ($mailing->getDestinos() as $destino) {
            $estado = $this->mandaMail($destino->getDestino(), $mailing->getSubject(), "EPSA", true);
            if ($estado) {
                $destino->setEnviado(new \DateTime());
                $this->orm->flush();
            }
        }
    }

}

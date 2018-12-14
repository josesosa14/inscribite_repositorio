<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Liquidacion_model extends A_Model {

    public function __construct() {

        parent::__construct();
    }

    public function getById($id) {
        return $this->getCollectionByid("Liquidacion", $id);
    }

    public function getByIdEmpresa($liq_id) {
        $liquidacion = $this->orm->createQuery("SELECT l FROM Liquidacion l WHERE l.id=:liquidacion")->setParameter("liquidacion", $liq_id)->getResult();
        if ($liquidacion) {
            return $liquidacion[0];
        } else {
            return false;
        }
    }

    private function buscoLiquidacionesAGenerar($information) {
        $ultima_liquidacion=$this->orm->createQuery("SELECT l FROM \Liquidacion l ORDER BY l.id DESC")->setMaxResults(1)->getSingleResult();
        $desde=$ultima_liquidacion->getFecha_hasta()->format("Y-m-d");
        $hasta = new \DateTime($information["liq_fecha_hasta"]);
        $query = "select cob_fecha,pag_id,aux.pag_emp_id,aux.tipo,aux.transaction_id from (select cob_fecha,pag_id,pag_emp_id,'inscripcion' tipo,pag_evt_id transaction_id
                FROM cobro
                inner join cobro_renglones on cor_cob_id=cob_id
                inner join pago on cor_pag_id=pag_id
                where pag_liq_id is null and pag_men_id is null
                AND (cob_fecha <= '{$hasta->format("Y-m-d")}')
                union all
                select cob_fecha,pag_id,pag_emp_id,'mensualidad' tipo,pag_men_id transaction_id
                FROM cobro
                inner join cobro_renglones on cor_cob_id=cob_id
                inner join pago on cor_pag_id=pag_id
                where pag_liq_id is null and pag_evt_id is null
                AND (cob_fecha <= '{$hasta->format("Y-m-d")}')  ) aux
                group by pag_id,cob_fecha,tipo,transaction_id,pag_emp_id
                ORDER BY transaction_id ASC
                ";
        return $this->db->query($query)->result();
    }

    public function insertar($information) {

        $pagos = $this->buscoLiquidacionesAGenerar($information);
        $hasta = new \DateTime($information["liq_fecha_hasta"]);
        if ($pagos) {
            $evento_anterior = 0;
            $liquidaciones_nuevas = array();
            foreach ($pagos as $k => $obj_pago) {
                $cliente = $this->getCollectionByid("Empresa", $obj_pago->pag_emp_id);
                if ($evento_anterior != $obj_pago->transaction_id) {
                    $evento_anterior = $obj_pago->transaction_id;
                    $liquidacion = new Liquidacion();
                    if ($obj_pago->tipo == "inscripcion") {
                        $query = "SELECT e FROM Evento e WHERE (e.codigo = '{$obj_pago->transaction_id}' or e.codigo='0{$obj_pago->transaction_id}' or e.codigo='00{$obj_pago->transaction_id}') ";
                        $evento = $this->orm->createQuery($query)->getResult();
                        if (!$evento) {
                            die("no encontramos el evento" .$query);
                        }
                        $liquidacion->setEvento($evento[0]);
                    } else {
                        $mensualidad = $this->getCollectionByid("Mensualidad", $obj_pago->transaction_id);
                        $liquidacion->setMensualidad($mensualidad);
                    }

                    $liquidacion->setFecha(new \DateTime());
                    $liquidacion->setCliente($cliente);
                    $liquidacion->setFecha_hasta($hasta);
                    $this->orm->persist($liquidacion);
                    $this->orm->flush();
                    $liquidaciones_nuevas[] = $liquidacion;
                }
                $pagos[$k]->liq_id = $liquidacion->getId();
            }

            foreach ($pagos as $obj_pago) {
                if ($obj_pago->tipo == "inscripcion") {
                    $this->db->query("UPDATE pago set pag_pagado_fecha=NOW(),pag_liq_id={$obj_pago->liq_id} WHERE pag_id={$obj_pago->pag_id} ");
                } else {
                    $this->db->query("UPDATE pago set pag_pagado_fecha=NOW(),pag_liq_id={$obj_pago->liq_id} WHERE pag_id={$obj_pago->pag_id} ");
                }
            }
            foreach ($liquidaciones_nuevas as $liquidacion) {
                //$this->mandaMail($liquidacion->getCliente()->getMail(), "Nueva liquidacion registrada", "Tiene una nueva liquidacion registrada de " . $obj_pago->tipo . " " . $liquidacion->getEventoMostrar() . "<br> Ingrese a su panel para cambiar sus cuentas de pago si lo desea.");
                $this->mandaMail(TEST_MAIL2, "Nueva liquidacion registrada", "Tiene una nueva liquidacion registrada de " . $obj_pago->tipo . " " . $liquidacion->getEventoMostrar() . "<br> Ingrese a su panel para cambiar sus cuentas de pago si lo desea.");
            }
        } else {
            die('nada para liquidar');
        }
    }

    public function getLiquidacionAjax($information, $emp_id = false) {
        /* @var $liquidacion Liquidacion */
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
        $where = "";
        if ($emp_id) {
            $where = "WHERE emp.id=" . addslashes($emp_id);
        }

        $query = $this->orm->createQuery("SELECT c FROM Liquidacion c JOIN c.cliente emp $where ORDER BY c.id DESC")->setFirstResult($offset)->setMaxResults($limit);
        $liquidacions = $query->getResult();
        $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Liquidacion c JOIN c.cliente emp $where")->setMaxResults(1)->getSingleScalarResult();
        foreach ($liquidacions as $liquidacion) {
            $out [] = $liquidacion->getDatosArray();
        }
        $data ["rows"] = $out;
        return $data;
    }

    function borrar($liq_id) {
        $liquidacion = $this->getCollectionByid("Liquidacion", $liq_id);
        $this->db->query("UPDATE pago SET pag_liq_id= NULL,pag_pagado_fecha=NULL WHERE pag_liq_id={$liquidacion->getId()}");
        $this->orm->remove($liquidacion);
        $this->orm->flush();
    }

    function pagar($liq_id) {
        /* @var $liquidacion Liquidacion */
        $liquidacion = $this->getCollectionByid("Liquidacion", $liq_id);
        $liquidacion->setFecha_pagada(new \DateTime());
        $this->orm->flush();
    }

    function insertaLiquidacionEmpresa($information) {
        /* @var $liquidacion Liquidacion */
        /* @var $empresa Empresa */
        $liquidacion = $this->getCollectionByid("Liquidacion", $information["liq_id"]);
        if ($information["destinos"]) {
            foreach ($liquidacion->getCuentas() as $cada_cuenta_liq) {
                $this->orm->remove($cada_cuenta_liq);
                $this->orm->flush();
            }
            $total = 0.00;
            foreach ($information["destinos"] as $cada_destino) {
                if ($cada_destino["importe"]) {
                    $total += $cada_destino["importe"];
                    if (isset($cada_destino["empb_id"])) {
                        $cuenta_banco = $this->getCollectionByid("Empresacuenta", $cada_destino["empb_id"]);
                    } else {
                        $cuenta_banco = new Empresacuenta();
                        if (!$liquidacion->getCliente()->getCuentaDefault()) {
                            $cuenta_banco->setDefault(1);
                        }
                        $cuenta_banco->setActiva(1);
                        $cuenta_banco->setBanco($cada_destino["banco"]);
                        $cuenta_banco->setCbu($cada_destino["cbu"]);
                        $cuenta_banco->setCuit($cada_destino["cuit"]);
                        $cuenta_banco->setEmpresa($liquidacion->getCliente());
                        $cuenta_banco->setNro_cuenta($cada_destino["nro_cuenta"]);
                        $cuenta_banco->setTipo_cuenta($cada_destino["tipo_cuenta"]);
                        $cuenta_banco->setTitular($cada_destino["titular"]);
                        $this->orm->persist($cuenta_banco);
                        $this->orm->flush();
                        $liquidacion->getCliente()->getCuentas()->add($cuenta_banco);
                    }
                    $cuenta = new Liquidacioncuentas();
                    $cuenta->setImporte($cada_destino["importe"]);
                    $cuenta->setLiquidacion($liquidacion);
                    $cuenta->setCuenta($cuenta_banco);
                    $this->orm->persist($cuenta);
                    $this->orm->flush();
                    $liquidacion->getCuentas()->add($cuenta);
                }
            }
            $this->orm->flush();
            if ($liquidacion->getTotal() > $total) {
                $uso_cuenta_default = false;
                foreach ($liquidacion->getCuentas() as $liq_cuenta) {
                    if ($liq_cuenta->getCuenta()->getId() == $liquidacion->getCliente()->getCuentaDefault()->getId()) {
                        $liq_cuenta->setImporte($liq_cuenta->getImporte() + ($liquidacion->getTotal() - $total));
                        $uso_cuenta_default = true;
                        break;
                    }
                }
                if (!$uso_cuenta_default) {
                    $cuenta = new Liquidacioncuentas();
                    $cuenta->setImporte($liquidacion->getTotal() - $total);
                    $cuenta->setLiquidacion($liquidacion);
                    $cuenta->setCuenta($liquidacion->getCliente()->getCuentaDefault());
                    $this->orm->persist($cuenta);
                    $liquidacion->getCuentas()->add($cuenta);
                }
            }
            $this->orm->flush();
        }
    }

    function xls_decodificador($liq_id) {
        $query = "select dec_id,med_fecha,CONCAT(usu.nombre,' ',usu.apellido) nombre,dni,par_importe,med_tipo,
                CASE WHEN ev.id IS NULL THEN men_codigo ELSE ev.codigo END codigo
                from liquidacion
                inner join pago on pag_liq_id=liq_id
                inner join pagos_renglones on par_pag_id=pag_id
                inner join decodificado_renglones on dec_id=par_dec_id
                inner join inscribite_usuarios usu on dni=dec_dni
                inner join mediodecodificado on med_id=dec_med_id
                left join inscribite_eventos ev on ev.id=liq_evt_id
                left join mensualidades on men_id=liq_men_id
                where liq_id=$liq_id";
        $q = $this->db->query($query);
        $sql["query"] = $q;
        $sql["fields"] = array("id", "fecha archivo", "nombre", "dni", "importe", "tipo", "codigo");
        to_excel($sql);
    }

}

<?php

/**
 *
 * @property Doctrine\ORM\EntityManager $orm Description 
 * 
 * */
class Pagomodel extends A_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('date');
    }

    private function insertar(Pago $pago) {
        $this->orm->persist($pago);
        $this->orm->flush();
    }

    public function insertaPago($information) {
        $proveedor = $this->getCollectionByid("Empresa", $information['emp_id']);

        if ($information['pag_id'] == 0) {
            $pago = new Pago();
            $pago->setFechaCreacion(new \DateTime());
            $this->orm->persist($pago);
        } else {
            $pago = $this->getCollectionByid("Pago", $information['pag_id']);
        }
        $pago->setFechaEjecucion(new \DateTime($information["pag_fecha"]));
        $pago->setEmpresa($proveedor);
        $this->orm->flush();
        $this->db->query("DELETE FROM pagos_renglones WHERE par_pag_id = '" . $pago->getId() . "'");
        foreach ($information["detalles"] as $detalle) {
            if ($detalle['par_importe'] > 0 && $detalle['estado'] != "delete") {
                $tipoPago = $this->orm->getReference("Tipo_Pago", $detalle['par_tipo']);
                $banco = $this->orm->getReference("Banco", $detalle['par_banco']);
                $pagoDetalle = new Pago_renglones();
                $pagoDetalle->setPago($pago);
                $pagoDetalle->setNumero($detalle['par_numero']);
                $pagoDetalle->setBanco($banco);
                $pagoDetalle->setImporte($detalle['par_importe']);
                $pagoDetalle->setTipoPago($tipoPago);
                $pagoDetalle->setFechaEjecucion(new \DateTime($information["pag_fecha"]));
                $this->orm->persist($pagoDetalle);
            }
        }

        $this->orm->flush();
    }

    public function getPagoById($id) {
        return $this->getCollectionByid("Pago", $id);
    }

    public function getPagos() {

        return $this->getAllCollection("Pago");
    }

    public function sellarPago($information) {
        $pago = $this->getPagoById($information['pago_id']);
        $estadoPago = $this->getCollectionById("Estado_pago", 2);
        $pago->setEstado($estadoPago);
        $this->orm->flush();
    }

    public function borrar($id) {
        $pago = $this->orm->createQuery("SELECT p FROM Pago p WHERE p.id = :id")->setParameter("id", $id)->getSingleResult();
        $this->db->query("UPDATE cobro SET cob_cant_pagos=0 WHERE cob_id=(select cor_cob_id from cobro_renglones where cor_pag_id=" . $pago->getId() . " LIMIT 1)");
        $this->db->query("UPDATE cobro_renglones SET cor_pag_id=0 WHERE cor_pag_id=" . $pago->getId());
        $pago_renglones = $this->orm->createQuery("SELECT r FROM Pago_renglones r WHERE r.pago = :id")->setParameter('id', $id)->getResult();

        foreach ($pago_renglones as $pr) {
            $this->orm->remove($pr);
        }
        $this->orm->remove($pago);
        $this->orm->flush();
    }

    public function getRenglonesGrilla($cobro_id = false) {
        if ($cobro_id) {
            $cobro = $this->getCollectionByid("Pago", $cobro_id);
            imprimirYMorir($cobro->getDetallesArray());
        } else {
            $this->generaRenglonesVacios();
        }
    }

    public function facturasSinPagar($pro_id) {
        $str = "select dop_id from documento_proveedor where dop_id not in(select paf_dop_id from pago_factura)
                    and dop_proveedor_id = ?";
        $ids = $this->db->query($str, array($pro_id))->result_array();
        $str_ids = "";
        if ($ids) {
            foreach ($ids as $k => $id) {
                if ($k == 0) {
                    $str_ids = $id['dop_id'];
                } else {
                    $str_ids .= "," . $id['dop_id'];
                }
            }
            $facturas = $this->orm->createQuery("SELECT f FROM Docproveedor f WHERE f.id IN($str_ids)")->getResult();
            return $facturas;
        }
    }

    public function renglonesPagoDocumentos($pro_id = false) {
        if ($pro_id) {
            $facturas = $this->facturasSinPagar($pro_id);
            return $this->generaRenglonesVaciosDocumentos($facturas);
        } else {
            return array("rows" => null, "total" => 0);
        }
    }

    public function generaRenglonesVaciosDocumentos($facturas) {
        $data = array("rows" => null, "total" => 0);
        if ($facturas) {
            foreach ($facturas as $i => $fac) {
                $factura = $fac->obtenerArray();
                $data['rows'][] = array(
                    "estado" => "<input type='checkbox' name='documento[" . $factura['id'] . "][doc_id]' value='" . $factura['id'] . "' />",
                    "documento" => '' . $factura['numero'] . '',
                    "fecha" => '' . date("d/m/Y", strtotime($factura['fecha'])) . '',
                    "importe" => '' . $factura['importe'] . ''
                );
            }
        }
        return $data;
    }

    //public function generaRenglonesDetalle($limit = 10, $pagoId = false) {
    public function generaRenglonesDetalle($pagoId = false) {
        $bancos = $this->orm->createQuery("SELECT b FROM Banco b WHERE b.activo = 1")->getResult();
        $tipo_pagos = $this->orm->createQuery("SELECT t FROM Tipo_pago t")->getResult();
        if ($pagoId)
            $pago_renglones = $this->orm->createQuery("SELECT p FROM pago_renglones p WHERE p.pago = :id")->setParameter('id', $pagoId)->getResult();
        $limit = 10;
        $data = array();
        $datos = false;

        $cont = 0;
        if ($pagoId) {
            foreach ($pago_renglones as $pr) {
                $clave = $cont + 99;
                $select_banco = '<select class="form-control" name="detalles[' . $clave . '][par_banco]">';
                foreach ($bancos as $banco) {
                    $select_banco .= '<option ' . ($banco->getId() == $pr->getBanco()->getId() ? "selected" : "") . ' value="' . $banco->getId() . '">' . $banco->getNombre() . '</option>';
                }
                $select_banco .= '</select>';

                $select_tipos = '<select id="forma2" class="form-control" name="detalles[' . $clave . '][par_tipo]">';
                foreach ($tipo_pagos as $tipo) {
                    $select_tipos .= '<option ' . ($tipo->getId() == $pr->getTipoPago()->getId() ? "selected" : "") . ' value="' . $tipo->getId() . '">' . utf8_encode($tipo->getNombre()) . '</option>';
                }
                $select_tipos .= '</select>';
                $data['rows'][] = array(
                    "control" => $pr->getId(),
                    "forma" => '<input type="hidden" class="id" name="detalles[' . $clave . '][id]" value="0"><input type="hidden" class="estado" name="detalles[' . $clave . '][estado]" value="0">' . $select_tipos,
                    "banco" => $select_banco,
                    "numero" => "<input type='text' class='form-control nombre' name='detalles[" . $clave . "][par_numero]' value=" . (!empty($pr->getNumero()) ? $pr->getNumero() : '' ) . " />",
                    "importe" => '<input type="text" class="form-control nombre" name="detalles[' . $clave . '][par_importe]" value=' . (!empty($pr->getImporte()) ? $pr->getImporte() : "" ) . ' >'
                );
                $cont ++;
            }
        }

        //pongo 99 porq sino nos indices se suman con los renglones ya cargados, supongo que un pago no va a tener más de 99 detalles
        for ($i = 0 + $cont; $i < $limit; $i++) {
            $clave = $i + 99;
            $select_banco = '<select class="form-control" name="detalles[' . $clave . '][par_banco]">';
            foreach ($bancos as $banco) {
                $select_banco .= '<option value="' . $banco->getId() . '">' . $banco->getNombre() . '</option>';
            }
            $select_banco .= '</select>';

            $select_tipos = '<select id="forma2" class="form-control" name="detalles[' . $clave . '][par_tipo]">';
            foreach ($tipo_pagos as $tipo) {
                $select_tipos .= '<option value="' . $tipo->getId() . '">' . utf8_encode($tipo->getNombre()) . '</option>';
            }
            $select_tipos .= '</select>';
            $data['rows'][] = array(
                "control" => 0,
                "forma" => '<input type="hidden" class="id" name="detalles[' . $clave . '][id]" value="0"><input type="hidden" class="estado" name="detalles[' . $clave . '][estado]" value="0">' . $select_tipos,
                "banco" => $select_banco,
                "numero" => "<input type='text' class='form-control nombre' name='detalles[" . $clave . "][par_numero]'  />",
                "importe" => '<input type="text" value="" class="form-control nombre" name="detalles[' . $clave . '][par_importe]">'
            );
        }

        return $data;
    }

    public function renglonesPagoDetalle($args = false) {
        if ($args)
            return $this->generaRenglonesDetalle($args);
        else
            return $this->generaRenglonesDetalle();
    }

    public function getPagoTableAjax($information) {
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

        $query = $this->orm->createQuery("SELECT p FROM Pago p $where_venta ORDER BY p.id DESC")->setFirstResult($offset)->setMaxResults($limit);
        $pagos = $query->getResult();
        $data ["total"] = $this->orm->createQuery("SELECT count(p) FROM Pago p $where_venta")->setMaxResults(1)->getSingleScalarResult();

        foreach ($pagos as $pago) {
            $out [] = $pago->getDatosArray();
        }
        $data ["rows"] = $out;

        return $data;
    }

    function getPagosAjax($args = false) {
        $out = array();
        if ($args ['limit']) {
            $limit = $args ['limit'];
        } else {
            $limit = 20;
        }
        $offset = 0;
        if ($args ['offset']) {
            $offset = $args ['offset'];
        }
        $orden = "DESC";
        switch ($args ['order']) {
            case 'asc' :
                $orden = "ASC";
                break;
            case 'desc' :
                $orden = "DESC";
                break;
        }
        $campo = "c.id";
        if (isset($args ['sort'])) {
            switch ($args ['sort']) {
                case 'numero' :
                    $campo = "c.id";
                    break;
                case 'fecha' :
                    $campo = "c.fecha";
                    break;
            }
        }

        if (isset($args['search'])) {
            $busqueda = $args['search'];

            //busco clientes
            $where = " WHERE (c.id = :busqueda";
            $where .= " OR cl.razon_social like :busqueda";
            $where .= " OR cl.cuit like :busqueda";
            $qb = $this->orm->createQuery("SELECT c FROM Pago c JOIN c.proveedor cl $where ORDER BY c.id DESC")
                            ->setParameter('busqueda', "%" . $busqueda . "%")
                            ->setFirstResult($offset)->setMaxResults($limit);
            $cobros = $qb->getResult();

            //busco total de clientes
            $qbTotal = $this->orm->createQuery("SELECT count(c) FROM Pago c $where")
                            ->setParameter('busqueda', "%" . $busqueda . "%")
                            ->setFirstResult($offset)->setMaxResults($limit);
            $data['total'] = $qbTotal->getSingleScalarResult();
        } else {
            $query = $this->orm->createQuery("SELECT c FROM Pago c ORDER BY c.id DESC")->setFirstResult($offset)->setMaxResults($limit);
            $cobros = $query->getResult();
            $data['total'] = $this->orm->createQuery("SELECT count(c) FROM Pago c ")->setMaxResults(1)->getSingleScalarResult();
        }

        foreach ($cobros as $cobro) {
            $out[] = $cobro->getDatos();
        }
        $data['rows'] = $out;
        return $data;
    }

    public function getDocumentosPago($pago_id) {
        $pago = $this->orm->createQuery("SELECT p FROM Pago p WHERE p.id = :pago")->setParameter("pago", $pago_id)->getSingleResult();
        $data = array();
        if ($pago->getFacturas()) {
            foreach ($pago->getFacturas() as $i => $fac) {
                $factura = $fac->getFactura()->obtenerArray();
                $data['rows'][] = array(
                    "estado" => "<input type='checkbox' name='documento[" . $factura['id'] . "][doc_id]' checked value='" . $factura['id'] . "' />",
                    "documento" => '' . $factura['numero'] . '',
                    "fecha" => '' . date("d/m/Y", strtotime($factura['fecha'])) . '',
                    "importe" => '' . $factura['importe'] . ''
                );
            }
        }
        $facturas = $this->facturasSinPagar($pago->getProveedor()->getId());
        if ($facturas) {
            foreach ($facturas as $i => $fac_a_pagar) {
                $factura = $fac_a_pagar->obtenerArray();
                $data['rows'][] = array(
                    "estado" => "<input type='checkbox' name='documento[" . $factura['id'] . "][doc_id]' value='" . $factura['id'] . "' />",
                    "documento" => '' . $factura['numero'] . '',
                    "fecha" => '' . date("d/m/Y", strtotime($factura['fecha'])) . '',
                    "importe" => '' . $factura['importe'] . ''
                );
            }
        }
        return $data;
    }

    public function getDetallesPago($pago_id) {
        $pago = $this->orm->createQuery("SELECT p FROM Pago p WHERE p.id = :pago")->setParameter("pago", $pago_id)->getSingleResult();
        $data = $this->generaRenglonesDetalle($pago->getDetalles());
        $data_extra = $this->generaRenglonesDetalle(false, 7);
        foreach ($data_extra['rows'] as $row) {
            $data['rows'][] = $row;
        }
        return $data;
    }

    public function getPagoByIdJson($id) {
        $pago = $this->getCollectionByid("Pago", $id);
        $array = array("pago_id" => $pago->getId(),
            "proveedor_id" => $pago->getProveedor()->getId(),
            "proveedor_razon" => $pago->getProveedor()->getRazon_social(),
            "proveedor_cuit" => $pago->getProveedor()->getCuit(),
            "proveedor_condiva" => $pago->getProveedor()->getCondicion_iva()->getNombre(),
            "fecha" => $pago->getFecha());
        return $array;
    }

    public function getJSONPagos($args) {
        $id = mb_strtoupper($args['q']['term'], 'utf-8');
        $pagos = $this->db->query("SELECT pag_id FROM pago WHERE pag_id like '%$id%' ORDER BY pag_id ASC")->result();
        if ($pagos) {
            foreach ($pagos as $pago) {
                //$data[] = array("id" => $pagos->pag_id, "text" => $cliente->emp_nombre);
                $data[] = array("id" => $pago->pag_id, "text" => $pago->pag_id);
            }
        } else {
            $data[] = array("id" => "0", "text" => "No se encontraron resultados..");
        }
        $ret['results'] = $data;
        return $ret;
    }

    public function marcarPagado($pag_id) {
        /* @var $pago Pago */
        $pago = $this->orm->createQuery("SELECT p FROM Pago p WHERE p.id=:id")->setParameter("id", $pag_id)->getSingleResult();
        $pago->setFecha_pagado(new \DateTime());
        $this->orm->flush();
    }

}

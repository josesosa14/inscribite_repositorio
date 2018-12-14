<?php

class Transferenciamodel extends A_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('date');
    }

    private function insertar(Pago $pago) {
        $this->orm->persist($pago);
        $this->orm->flush();
    }

    public function insertaPago($information) {

        $proveedor = $this->getCollectionByid("Proveedor", $information['dop_proveedor_id']);
        $estadoPago = $this->getCollectionById("Estado_pago", 1);
        if ($information['pago_id'] == 0) {
            $pago = new Pago($proveedor, $information["pago_fecha"], $estadoPago);
            $this->orm->persist($pago);
        } else {
            $pago = $this->getCollectionByid("Pago", $information['pago_id']);
        }
        $this->orm->flush();
        $facturas = new \Doctrine\Common\Collections\ArrayCollection;
        $detalles = new \Doctrine\Common\Collections\ArrayCollection;

        $this->db->query("DELETE FROM pago_detalle WHERE detalle_pago_id = " . $pago->getId());
        $this->db->query("DELETE FROM pago_factura WHERE paf_pago_id = " . $pago->getId());

        foreach ($information["documento"] as $factura) {
            $fac = $this->orm->getReference("Docproveedor", $factura['doc_id']);
            $pagoFactura = new Pago_Factura($fac, $pago, $fac->getImporte());
            $this->orm->persist($pagoFactura);
        }

        foreach ($information["detalles"] as $detalle) {
            if ($detalle['cod_importe'] > 0 && $detalle['estado'] != "delete") {
                $tipoPago = $this->orm->getReference("Tipo_Pago", $detalle['cod_tipo']);
                $banco = $this->orm->getReference("Banco", $detalle['cod_banco']);
                $cheque = NULL;
                if ($detalle['cod_tipo'] == 9) {
                    $cheque = new Cheque();
                    $cheque->setBanco($banco);
                    $cheque->setNumero($detalle['cod_numero']);
                    $cheque->setImporte($detalle['cod_importe']);
                    $cheque->setEstadoCheque($this->orm->getReference("Estado_cheque", 8));
                    $cheque->setDestino(2);
                    $cheque->setFechaIngreso(new \DateTime("NOW"));
                    $cheque->setFechaVencimiento(new \DateTime($detalle['cod_fecha']));
                    $this->orm->persist($cheque);
                }
                $pagoDetalle = new Pago_Detalle();
                $pagoDetalle->setPago($pago);
                $pagoDetalle->setNumero($detalle['cod_numero']);
                $pagoDetalle->setBanco($banco);
                $fecha = str_replace("/", "-", $detalle['cod_fecha']);
                $pagoDetalle->setFecha(new \DateTime($fecha));
                $pagoDetalle->setImporte($detalle['cod_importe']);
                $pagoDetalle->setTipoPago($tipoPago);
                $pagoDetalle->setCheque($cheque);
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

        $pago = $this->getCollectionByid("Pago", $id);

        if ($pago->getActivo() == 1) {

            $pago->setActivo(0);
        } else {

            $pago->setActivo(1);
        }

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

    public function renglonesPagoDetalle() {
        return $this->generaRenglonesDetalle();
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

}

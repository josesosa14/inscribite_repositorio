<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Solicitudtransferencia_model extends A_Model {

    public function __construct() {

        parent::__construct();
    }

    public function getById($id) {
        return $this->getCollectionByid("Solicitudtransferencia", $id);
    }

    /*public function insertar($information) {
        if ($information["sot_id"]) {
            $solicitudtransferencia = $this->getCollectionByid("Solicitudtransferencia", $information["sol_id"]);
        } else {
            $solicitudtransferencia = new Solicitudtransferencia();
            $this->orm->persist($solicitudtransferencia);
        }
        $solicitudtransferencia->setImporte($information["sol_importe"]);
        $solicitudtransferencia->setCbu($information["sol_cbu"]);
        $solicitudtransferencia->setCuit($information["sol_cuit"]);
        $solicitudtransferencia->setDestinatario($information["sol_destinatario"]);
        $solicitudtransferencia->setCliente($information["sol_cliente"]);
        $solicitudtransferencia->setPago($information["sol_pago"]);
        $this->orm->flush();
    }*/
    
    public function insertar($information) {
        $pago = $this->getCollectionByid("Pago", $information['sot_pago']);
        
        if ($information['sot_id'] == 0) {
            $solicitudTransferencia = new Solicitudtransferencia();
            $solicitudTransferencia->setFechaCreacion(new \DateTime());
            $this->orm->persist($solicitudTransferencia);
        } else {
            $solicitudTransferencia = $this->getCollectionByid("Solicitudtransferencia", $information['sot_id']);
        }
        $solicitudTransferencia->setObservaciones($information['sot_observaciones']);
        $solicitudTransferencia->setPago($pago);
        $this->orm->flush();
        $this->db->query("DELETE FROM solicitud_transferencias_renglones WHERE str_sot_id = '" . $solicitudTransferencia->getId() . "'");
        foreach ($information["detalles"] as $detalle) {
            if ($detalle['str_importe'] > 0 && $detalle['estado'] != "delete") {
                $tipoPago = $this->orm->getReference("Tipo_Pago", $detalle['str_tipo']);
                $banco = $this->orm->getReference("Banco", $detalle['str_banco']);
                $solTransReng = new SolicitudTransferenciaRenglones();
                $solTransReng->setSolicitudTransferencia($solicitudTransferencia);
                $solTransReng->setBanco($banco);
                $solTransReng->setTipoPago($tipoPago);
                $solTransReng->setImporte($detalle['str_importe']);
                $solTransReng->setCbu($detalle['str_cbu']);
                $solTransReng->setCuit($detalle['str_cuit']);
                $this->orm->persist($solTransReng);
            }
        }

        $this->orm->flush();
    }

    public function getSolTransTableAjax($information) {
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

        $query = $this->orm->createQuery("SELECT c FROM Solicitudtransferencia c $where_venta")->setFirstResult($offset)->setMaxResults($limit);
        $solicitudtransferencias = $query->getResult();
        $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Solicitudtransferencia c $where_venta")->setMaxResults(1)->getSingleScalarResult();
        foreach ($solicitudtransferencias as $solicitudtransferencia) {
            $solTransArray = $solicitudtransferencia->getDatosArray();
            $strs = $this->orm->createQuery("SELECT r FROM SolicitudTransferenciaRenglones r WHERE r.solicitudTransferencia = :id")->setParameter('id', $solTransArray['id'])->getResult();
            $sum = 0;
            foreach($strs as $str)
                $sum = $sum + $str->getImporte();
            $solTransArray ["str_importe"] = $sum;
            $solTransArray ["emp_nombre"] = $solicitudtransferencia->getPago()->getEmpresa()->getNombre();
            $out [] = $solTransArray;
        }
        $data ["rows"] = $out;
        return $data;
    }
    
    public function generaRenglonesDetalle($sotId = false) {
        $bancos = $this->orm->createQuery("SELECT b FROM Banco b WHERE b.activo = 1")->getResult();
        $tipo_pagos = $this->orm->createQuery("SELECT t FROM Tipo_pago t")->getResult();
        if($sotId)
            $strs = $this->orm->createQuery("SELECT r FROM SolicitudTransferenciaRenglones r WHERE r.solicitudTransferencia = :id")->setParameter('id', $sotId)->getResult();
        $limit = 10;
        $data = array();
        $datos = false;
            
        $cont = 0;
        if($sotId){
            foreach($strs as $str){
                $clave = $cont + 99;
                $select_banco = '<select class="form-control" name="detalles[' . $clave . '][str_banco]">';
                foreach ($bancos as $banco) {
                    $select_banco .= '<option ' . ($banco->getId() == $str->getBanco()->getId() ? "selected" : "")  . ' value="' . $banco->getId() . '">' . $banco->getNombre() . '</option>';
                }
                $select_banco .= '</select>';

                $select_tipos = '<select id="forma2" class="form-control" name="detalles[' . $clave . '][str_tipo]">';
                foreach ($tipo_pagos as $tipo) {
                    $select_tipos .= '<option ' . ($tipo->getId() == $str->getTipoPago()->getId() ? "selected" : "")  . ' value="' . $tipo->getId() . '">' . utf8_encode($tipo->getNombre()) . '</option>';
                }
                $select_tipos .= '</select>';
                $data['rows'][] = array(
                    "control" => $str->getId(),
                    "forma" => '<input type="hidden" class="id" name="detalles[' . $clave . '][id]" value="0"><input type="hidden" class="estado" name="detalles[' . $clave . '][estado]" value="0">' . $select_tipos,
                    "banco" => $select_banco,
                    "cbu" => '<input type="text" value="' . (!empty($str->getCbu()) ? $str->getCbu() : '') . '" class="form-control nombre" name="detalles[' . $clave . '][str_cbu]">',
                    "cuit" => "<input type='text' value='" . (!empty($str->getCuit()) ? $str->getCuit() : "") . "' class='form-control nombre' name='detalles[" . $clave . "][str_cuit]'  />",
                    "importe" => '<input type="text" value="' . (!empty($str->getImporte()) ? $str->getImporte() : '') . '" class="form-control nombre" name="detalles[' . $clave . '][str_importe]">'
                );
                $cont ++;
            }
        }

        //pongo 99 porq sino nos indices se suman con los renglones ya cargados, supongo que un pago no va a tener más de 99 detalles
        for ($i = 0 + $cont; $i < $limit; $i++) {
            $clave = $i + 99;
            $select_banco = '<select class="form-control" name="detalles[' . $clave . '][str_banco]">';
            foreach ($bancos as $banco) {
                $select_banco .= '<option value="' . $banco->getId() . '">' . $banco->getNombre() . '</option>';
            }
            $select_banco .= '</select>';

            $select_tipos = '<select id="forma2" class="form-control" name="detalles[' . $clave . '][str_tipo]">';
            foreach ($tipo_pagos as $tipo) {
                $select_tipos .= '<option value="' . $tipo->getId() . '">' . utf8_encode($tipo->getNombre()) . '</option>';
            }
            $select_tipos .= '</select>';
            $data['rows'][] = array(
                "control" => 0,
                "forma" => '<input type="hidden" class="id" name="detalles[' . $clave . '][id]" value="0"><input type="hidden" class="estado" name="detalles[' . $clave . '][estado]" value="0">' . $select_tipos,
                "banco" => $select_banco,
                "cbu" => '<input type="text" value="" class="form-control nombre" name="detalles[' . $clave . '][str_cbu]">',
                "cuit" => "<input type='text' class='form-control nombre' name='detalles[" . $clave . "][str_cuit]'  />",
                "importe" => '<input type="text" value="" class="form-control nombre" name="detalles[' . $clave . '][str_importe]">'
            );
        }

        return $data;
    }
    
    public function renglonesTransferenciaDetalle($args = false) {
        if ($args)
            return $this->generaRenglonesDetalle($args);
        else
            return $this->generaRenglonesDetalle();
    }
    
    public function borrarSolicitudTransferencia($id){
        $sot = $this->orm->createQuery("SELECT s FROM SolicitudTransferencia s WHERE s.id = :id")->setParameter("id", $id)->getSingleResult();
        $strs = $this->orm->createQuery("SELECT r FROM SolicitudTransferenciaRenglones r WHERE r.solicitudTransferencia = :id")->setParameter('id', $id)->getResult();

        foreach ($strs as $str)
            $this->orm->remove($str);
        $this->orm->remove($sot);
        $this->orm->flush();
    }

}

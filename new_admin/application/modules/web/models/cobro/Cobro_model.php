<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class Cobro_model extends A_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getById($id) {
        return $this->getCollectionByid("Cobro", $id);
    }

    public function insertar($information) {

        if ($information["cob_id"]) {
            $cobro = $this->getCollectionByid("Cobro", $information["cob_id"]);
        } else {
            $cobro = new Cobro();
            $this->orm->persist($cobro);
        }
        /* @var $variables Variables */
        $variables = $this->getCollectionByid("Variables", 1);

        $cobro->setFecha(new \DateTime($information["cob_fecha"]));
        $neto = $information["cob_importe"];
        $iibb = $information["cob_retenciones"] > 0 ? $information["cob_retenciones"] : 0;

        if ($information["cob_mediopago"] == "rp") {
            $divisor = (1 - ($variables->getPorc_comision_rp() * $variables->getIvaImporte()) - ($variables->getPorc_efectivo_rp() * $variables->getIvaImporte()));
            $total = $neto / $divisor;
            $total = $total + $iibb;
            $comisiones = $total * $variables->getPorc_comision_rp();
            $iva_comisiones = $comisiones * $variables->getPorc_iva();
            $costo_efectivo = $total * $variables->getPorc_efectivo_rp();
            $iva_costo_efectivo = $costo_efectivo * $variables->getPorc_iva();
            $iva = $iva_comisiones + $iva_costo_efectivo;
        } elseif ($information["cob_mediopago"] == "pf") {
            $divisor = (1 - ($variables->getPorc_comision_pf() * $variables->getIvaImporte()));
            $total = ($neto + $iibb) / $divisor;
            $comisiones = $total * $variables->getPorc_comision_pf();
            $iva = $comisiones * $variables->getPorc_iva();
        } else { //pmc
            $divisor = (1 - ($variables->getPorc_comision_pmc() * $variables->getIvaImporte()));
            $total = $neto / $divisor;
            $comisiones = $total * $variables->getPorc_comision_pmc();
            $iva = $comisiones * $variables->getPorc_iva();
        }

        $cobro->setNeto($neto);
        $cobro->setImporte($total);
        $cobro->setRetenciones($iibb);
        $cobro->setAjustes($information["cob_ajustes"]?$information["cob_ajustes"]:0.00);
        $cobro->setComisiones($comisiones);
        $cobro->setIva($iva);
        $cobro->setMediopago($information["cob_mediopago"]);
        $cobro->setLiquidado(false);

        $this->orm->flush();
        if (isset($_FILES['cob_adjunto']) && $_FILES['cob_adjunto']['name']) {
            $nombre_archivo = sube_archivo($_FILES["cob_adjunto"], COBROS, $cobro->getId());
            $cobro->setAdjunto($nombre_archivo);
        }
        $this->orm->flush();
        $this->buscaRenglonesCobro($cobro);
    }

    private function buscaRenglonesCobro(&$cobro) {
        $medio = "med_tipo =" . $cobro->getMediopago();
        if ($cobro->getMediopago() == "pf") {
            $medio = "(med_tipo='pfi' or med_tipo='pfc' or med_tipo='pf')";
        } else {
            $medio = "med_tipo='" . $cobro->getMediopago() . "'";
        }
        /* @var $cobro Cobro */
        $query = "select dec_id,dec_importe from decodificado_renglones
                    inner join mediodecodificado on med_id=dec_med_id
                    where $medio and dec_id not in(select cor_dec_id from cobro
                    inner join cobro_renglones on cor_cob_id=cob_id
                    where $medio)
                    ORDER BY med_fecha ASC,med_tipo ASC,dec_id asc";
        //echo $query;die;
        $ren_medio = $this->db->query($query)->result();
        $total_acumulado = 0.00;
        $ids_dec_id = "";
        $cont = 0;
        if ($ren_medio) {
            foreach ($ren_medio as $renglon) {
                $total_acumulado = $total_acumulado + $renglon->dec_importe;
                $cont++;
                if ($total_acumulado >= round($cobro->getImporte())) {
                    $ids_dec_id .= strlen($ids_dec_id > 0) ? "," . $renglon->dec_id : $renglon->dec_id;
                    break;
                } else {
                    $ids_dec_id .= strlen($ids_dec_id > 0) ? "," . $renglon->dec_id : $renglon->dec_id;
                }
            }
            $query = "insert into cobro_renglones(cor_cob_id,cor_dec_id) select '" . $cobro->getId() . "' cob_id,dec_id from decodificado_renglones where dec_id in($ids_dec_id) ORDER BY dec_id asc";

            $this->db->query($query);
            $this->generaPagos($cobro);
        }
        $cobro->setCantregistros($cont);
        $this->orm->flush();
    }

    public function generaTodosLosPagos() {
        $cobros = $this->getAllCollection("Cobro");
        foreach ($cobros as $cada_cobro) {
            $this->generaPagos($cada_cobro);
        }
    }

    public function generaPagos(&$cobro) {
        $tiene_pagos = $this->db->query("SELECT cor_pag_id FROM cobro_renglones WHERE cor_pag_id IS NOT NULL AND cor_cob_id=" . $cobro->getId())->result();
        if ($tiene_pagos) {
            return;
        }

        $query_pagos = "insert into pago (pag_cob_id,pag_fecha,pag_fecha_in,pag_emp_id,pag_evt_id,pag_men_id,pag_tipo,pag_comision)
            select '{$cobro->getId()}' cob_id,now() fecha_pago,now() fecha_in,emp_id,CASE WHEN max(tipo)='inscripciones' THEN evento ELSE NULL END evento,CASE WHEN max(tipo) ='mensualidades' THEN evento ELSE NULL END mensualidad,max(tipo) tipo,
            ROUND((case when max(emp_comision) > 0 THEN max(emp_comision) ELSE (select var_comision_cliente from variables) END),5) comision from (
            select cob_id,dec_dni,usu.nombre,cob_med_tipo,dec_importe,men_id evento,'mensualidades' tipo,emp_id,emp_comision
            from cobro
            inner join cobro_renglones on cor_cob_id=cob_id
            inner join decodificado_renglones on dec_id=cor_dec_id
            inner join facturas on fac_id=dec_codigo
            inner join inscribite_usuarios usu on dni=dec_dni
            inner join mensualidad_cuotas on mec_id=fac_mensualidad
            inner join mensualidades on men_id=mec_men_id
            inner join empresa on emp_id=men_empresa	
            WHERE fac_mensualidad>0
            union all 
            select cob_id,dec_dni,usu.nombre,cob_med_tipo,dec_importe,fac_evento_id evento,'inscripciones' tipo,emp_id,emp_comision
            from cobro
            inner join cobro_renglones on cor_cob_id=cob_id
            inner join decodificado_renglones on dec_id=cor_dec_id
            inner join facturas on fac_id=dec_codigo
            inner join inscribite_usuarios usu on dni=dec_dni
            inner join inscribite_eventos ev on ev.codigo=fac_evento_id
            inner join empresa on emp_nombre=ev.empresa
            WHERE fac_mensualidad=0
            UNION all
            select cob_id,dec_dni,usu.nombre,cob_med_tipo,dec_importe,deevento evento,'inscripciones' tipo,emp_id,emp_comision
            from cobro
            inner join cobro_renglones on cor_cob_id=cob_id
            inner join decodificado_renglones on dec_id=cor_dec_id
            inner join inscribite_inscripciones ins on ins.id=dec_codigo and ins.deusuario=dec_dni
            inner join inscribite_usuarios usu on dni=dec_dni
            inner join inscribite_eventos ev on ev.codigo=deevento
            inner join empresa on emp_nombre=ev.empresa
            ) aux
            where cob_id={$cobro->getId()}
            group by aux.emp_id,aux.evento";
        $this->db->query($query_pagos);

        $query_pagos_renglones = "insert into pagos_renglones(par_dec_id,par_pag_id,par_importe,par_tip_id)
                select dec_id,MAX(pag_id),MAX(dec_importe),'5' tipo_pago from (
                select dec_id,cor_id,cob_id,dec_dni,usu.nombre,cob_med_tipo,dec_importe,men_id evento,'mensualidades' tipo,emp_id,emp_comision,(select pag_id from pago where pag_emp_id=emp_id and pag_men_id=men_id and pag_cob_id=cob_id limit 1) pag_id
                from cobro
                inner join cobro_renglones on cor_cob_id=cob_id
                inner join decodificado_renglones on dec_id=cor_dec_id
                inner join facturas on fac_id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                inner join mensualidad_cuotas on mec_id=fac_mensualidad
                inner join mensualidades on men_id=mec_men_id
                inner join empresa on emp_id=men_empresa	
                WHERE fac_mensualidad>0
                union all 
                select dec_id,cor_id,cob_id,dec_dni,usu.nombre,cob_med_tipo,dec_importe,fac_evento_id evento,'inscripciones' tipo,emp_id,emp_comision,(select pag_id from pago where pag_emp_id=emp_id and pag_evt_id=fac_evento_id and pag_cob_id=cob_id limit 1) pag_id
                from cobro
                inner join cobro_renglones on cor_cob_id=cob_id
                inner join decodificado_renglones on dec_id=cor_dec_id
                inner join facturas on fac_id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                inner join inscribite_eventos ev on ev.codigo=fac_evento_id
                inner join empresa on emp_nombre=ev.empresa
                WHERE fac_mensualidad=0
                UNION all
                select dec_id,cor_id,cob_id,dec_dni,usu.nombre,cob_med_tipo,dec_importe,deevento evento,'inscripciones' tipo,emp_id,emp_comision,(select pag_id from pago where pag_emp_id=emp_id and pag_evt_id=deevento and pag_cob_id=cob_id limit 1) pag_id
                from cobro
                inner join cobro_renglones on cor_cob_id=cob_id
                inner join decodificado_renglones on dec_id=cor_dec_id
                inner join inscribite_inscripciones ins on ins.id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                inner join inscribite_eventos ev on ev.codigo=deevento
                inner join empresa on emp_nombre=ev.empresa) aux
                where cob_id={$cobro->getId()} group by dec_id";

        $this->db->query($query_pagos_renglones);

        $query_cobros_pagos = "update cobro_renglones tabla_a
                JOIN (
                select cor_id,pag_id from (
                select cor_id,cob_id,dec_dni,usu.nombre,cob_med_tipo,dec_importe,men_id evento,'mensualidades' tipo,emp_id,emp_comision,
                    (select pag_id from pago where pag_emp_id=emp_id and pag_men_id=men_id and pag_cob_id=cob_id LIMIT 1) pag_id
                from cobro
                inner join cobro_renglones on cor_cob_id=cob_id
                inner join decodificado_renglones on dec_id=cor_dec_id
                inner join facturas on fac_id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                inner join mensualidad_cuotas on mec_id=fac_mensualidad
                inner join mensualidades on men_id=mec_men_id
                inner join empresa on emp_id=men_empresa	
                WHERE fac_mensualidad>0
                union all 
                select cor_id,cob_id,dec_dni,usu.nombre,cob_med_tipo,dec_importe,fac_evento_id evento,'inscripciones' tipo,emp_id,emp_comision,
                (select pag_id from pago where pag_emp_id=emp_id and pag_evt_id=fac_evento_id and pag_cob_id=cob_id LIMIT 1) pag_id
                from cobro
                inner join cobro_renglones on cor_cob_id=cob_id
                inner join decodificado_renglones on dec_id=cor_dec_id
                inner join facturas on fac_id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                inner join inscribite_eventos ev on ev.codigo=fac_evento_id
                inner join empresa on emp_nombre=ev.empresa
                WHERE fac_mensualidad=0
                UNION all
                select cor_id,cob_id,dec_dni,usu.nombre,cob_med_tipo,dec_importe,deevento evento,'inscripciones' tipo,emp_id,emp_comision,
                (select pag_id from pago where pag_emp_id=emp_id and pag_evt_id=deevento and pag_cob_id=cob_id LIMIT 1) pag_id
                from cobro
                inner join cobro_renglones on cor_cob_id=cob_id
                inner join decodificado_renglones on dec_id=cor_dec_id
                inner join inscribite_inscripciones ins on ins.id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                inner join inscribite_eventos ev on ev.codigo=deevento
                inner join empresa on emp_nombre=ev.empresa) aux
                where cob_id={$cobro->getId()}) table_b
                ON tabla_a.cor_id=table_b.cor_id
                SET tabla_a.cor_pag_id=table_b.pag_id
                ";
        $this->db->query($query_cobros_pagos);

        $cant_pagos_cobro = $this->db->query("select count(*) cant from pago where pag_cob_id=" . $cobro->getId())->result();
        if ($cant_pagos_cobro) {
            $cobro->setCant_pagos($cant_pagos_cobro[0]->cant);
            $this->orm->flush();
        }
    }

    private function borraPagosAsociados(&$cobro) {
        $this->db->query("DELETE FROM pagos_renglones WHERE par_pag_id in (select cor_pag_id from cobro_renglones where cor_cob_id={$cobro->getId()})");
        $this->db->query("DELETE FROM pago WHERE pag_id in (select cor_pag_id from cobro_renglones where cor_cob_id={$cobro->getId()})");
    }

    public function getCobroAjax($information) {
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

        $query = $this->orm->createQuery("SELECT c FROM Cobro c $where_venta ORDER BY c.id DESC")->setFirstResult($offset)->setMaxResults($limit);
        $cobros = $query->getResult();
        $data ["total"] = $this->orm->createQuery("SELECT count(c) FROM Cobro c $where_venta")->setMaxResults(1)->getSingleScalarResult();
        foreach ($cobros as $k => $cobro) {
            $out [] = $cobro->getDatosArray();
        }
        $data ["rows"] = $out;
        return $data;
    }

    public function getEstadoCuenta() {
        $fecha_mayor_a="2018-01-30";
        $query = "select aux.medio medio,SUM(aux.dec_importe) total from (
        SELECT 'pmc' medio,dc.dec_id,CONCAT(dec_dni,' ',nombre,' ',apellido) cliente,fac_evento_id evento,fac_cat_id categoria,'testing' organizador,dec_importe,'test_terminal' terminal,dec_fechapago,'' hora,'inscribite' FROM `decodificador` dc
          inner join mediodecodificado on med_id=dec_pagomiscuentas
          inner join decodificado_renglones dr on dr.dec_med_id=med_id
          left join facturas on fac_id=dec_codigo
          left join inscribite_usuarios on id=fac_usu_id
          where med_fecha>='$fecha_mayor_a'
        union all 
        SELECT 'rp' medio,dc.dec_id,CONCAT(dec_dni,' ',nombre,' ',apellido) cliente,fac_evento_id evento,fac_cat_id categoria,'testing' organizador,dec_importe,'test_terminal' terminal,dec_fechapago,'' hora,'inscribite' FROM `decodificador` dc
          inner join mediodecodificado on med_id=dec_rapipago
          inner join decodificado_renglones dr on dr.dec_med_id=med_id
          left join facturas on fac_id=dec_codigo
          left join inscribite_usuarios on id=fac_usu_id
          where med_fecha>='$fecha_mayor_a'
        union all 
            SELECT 'pf' medio,dc.dec_id,CONCAT(dec_dni,' ',nombre,' ',apellido) cliente,fac_evento_id evento,fac_cat_id categoria,'testing' organizador,dec_importe,'test_terminal' terminal,dec_fechapago,'' hora,'inscribite' FROM `decodificador` dc
          inner join mediodecodificado on med_id=dec_pagofacil
          inner join decodificado_renglones dr on dr.dec_med_id=med_id
          left join facturas on fac_id=dec_codigo
          left join inscribite_usuarios on id=fac_usu_id
          where med_fecha>='$fecha_mayor_a'
            union all
            SELECT 'pf' medio,dc.dec_id,CONCAT(dec_dni,' ',nombre,' ',apellido) cliente,fac_evento_id evento,fac_cat_id categoria,'testing' organizador,dec_importe,'test_terminal' terminal,dec_fechapago,'' hora,'inscribite' FROM `decodificador` dc
          inner join mediodecodificado on med_id=dec_pagofacilinterior
          inner join decodificado_renglones dr on dr.dec_med_id=med_id
          left join facturas on fac_id=dec_codigo
          left join inscribite_usuarios on id=fac_usu_id
          where med_fecha>='$fecha_mayor_a') aux
          group by aux.medio";
        $decodificados = $this->db->query($query)->result();


        $query = "select cob_med_tipo medio,SUM(dec_importe) total from cobro
                    inner join cobro_renglones on cor_cob_id=cob_id
                    inner join decodificado_renglones on dec_id=cor_dec_id
                    inner join mediodecodificado on med_id=dec_med_id
                    where med_fecha>='$fecha_mayor_a'
                    group by cob_med_tipo";
        $cobrados = $this->db->query($query)->result();

        $query = "select cob_med_tipo medio,SUM(dec_importe) total from(select pag_id from liquidacion
                    inner join pago on pag_liq_id=liq_id 
                    inner join pagos_renglones on par_pag_id=pag_id group by pag_id)aux
                    inner join cobro_renglones on cor_pag_id=aux.pag_id
                    inner join decodificado_renglones on dec_id=cor_dec_id
                    inner join mediodecodificado on med_id=dec_med_id
                    inner join cobro on cob_id=cor_cob_id
                    where med_fecha>='$fecha_mayor_a'
                    group by cob_med_tipo";
        $liquidados = $this->db->query($query)->result();

        $response["decodificados"] = $decodificados;
        $response["cobrados"] = $cobrados;
        $response["liquidados"] = $liquidados;
        return $response;
    }

    function xls_cobro_renglones($cob_id) {
        $query = "SELECT dr.dec_id,med_fecha,CONCAT(usu.nombre,' ',usu.apellido) nombre,usu.dni,dec_importe,med_tipo,concat(men_nombre,' cuota ',mec_nro_cuota) fac_evento_id,dec_tipo_ingreso
                from cobro
                inner join cobro_renglones on cor_cob_id=cob_id
                inner join decodificado_renglones dr on dec_id=cor_dec_id
                inner join mediodecodificado on dec_med_id=med_id
                inner join decodificador dc on dc.dec_id=med_dec_id
                inner join facturas on fac_id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                inner join mensualidad_cuotas on mec_id=fac_mensualidad
                inner join mensualidades on men_id=mec_men_id
                where cob_id=$cob_id and fac_mensualidad>0
                UNION ALL SELECT dr.dec_id,med_fecha,CONCAT(usu.nombre,' ',usu.apellido) nombre,usu.dni,dec_importe,med_tipo,fac_evento_id,dec_tipo_ingreso
                from cobro
                inner join cobro_renglones on cor_cob_id=cob_id
                inner join decodificado_renglones dr on dec_id=cor_dec_id
                inner join mediodecodificado on dec_med_id=med_id
                inner join decodificador dc on dc.dec_id=med_dec_id
                inner join facturas on fac_id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                where cob_id=$cob_id and fac_mensualidad=0
                UNION ALL 
                SELECT dr.dec_id, med_fecha,CONCAT(usu.nombre,' ',usu.apellido) nombre,usu.dni,dec_importe,med_tipo,ins.deevento,dec_tipo_ingreso
                from cobro
                inner join cobro_renglones on cor_cob_id=cob_id
                inner join decodificado_renglones dr on dr.dec_id=cor_dec_id
                inner join mediodecodificado on dr.dec_med_id=med_id
                inner join decodificador dc on dc.dec_id=med_dec_id
				inner join inscribite_inscripciones ins on ins.id=dec_codigo and ins.deusuario=dec_dni
                inner join inscribite_usuarios usu on dni=dec_dni
                where cob_id=$cob_id ORDER BY med_fecha,med_tipo,dec_id ASC";

        $q = $this->db->query($query);
        $sql["query"] = $q;
        $sql["fields"] = array("id", "fecha archivo", "nombre", "dni", "importe", "tipo", "evento", "movimiento");
        to_excel($sql);
    }

    function borrar($cob_id) {
        $this->db->trans_start();
        $query = "DELETE FROM pagos_renglones WHERE par_pag_id in (select cor_pag_id FROM cobro_renglones where cor_cob_id=$cob_id)";
        $this->db->query($query);
        $query = "DELETE FROM pago WHERE pag_id in(select cor_pag_id FROM cobro_renglones where cor_cob_id=$cob_id)";
        $this->db->query($query);
        $query = "DELETE FROM cobro_renglones WHERE cor_cob_id =$cob_id";
        $this->db->query($query);
        $query = "DELETE FROM cobro WHERE cob_id =$cob_id";
        $this->db->query($query);
        $this->db->trans_complete();
    }

}

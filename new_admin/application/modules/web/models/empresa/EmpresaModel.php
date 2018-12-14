<?php

defined("BASEPATH") OR exit("No direct script access allowed");

class empresaModel extends A_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getEmpresas() {
        return $this->orm->createQuery("SELECT e FROM Empresa e")->getResult();
    }

    public function getEmpresaTableAjax($information) {
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

        $by = "e.nombre";
        if (isset($information['sort'])) {
            switch ($information["sort"]) {
                case "nombre" :
                    $by = "e.cosecha";
                    break;
            }
        }

        $empresas_ids = $this->db->query("select emp_id from(select emp_id from inscribite_eventos ev
                inner join empresa on emp_nombre=ev.empresa
                where ver=1
                union all
                select emp_id from mensualidades 
                inner join empresa on emp_id=men_empresa
                where men_activo=1) aux
                group by emp_id")->result_array();
        $ids = "";
        foreach ($empresas_ids as $k => $cada_id) {
            $ids.=$k > 0 ? "," . $cada_id["emp_id"] : $cada_id["emp_id"];
        }
        $where_venta = "WHERE e.id in($ids)";
        if (isset($information['search'])) {
            $where_venta .= " AND e.nombre like :busqueda ";
            $query = $this->orm->createQuery("SELECT e FROM Empresa e $where_venta ORDER BY $by $orden")->setParameter("busqueda", "%" . $information["search"] . "%")->setFirstResult($offset)->setMaxResults($limit);
            $empresas = $query->getResult();
            $data ["total"] = $this->orm->createQuery("SELECT count(e) FROM Empresa e $where_venta")->setParameter("busqueda", $information["search"])->setMaxResults(1)->getSingleScalarResult();
        } else {
            $query = $this->orm->createQuery("SELECT e FROM Empresa e $where_venta ORDER BY $by $orden")->setFirstResult($offset)->setMaxResults($limit);
            $empresas = $query->getResult();
            $data ["total"] = $this->orm->createQuery("SELECT count(e) FROM Empresa e $where_venta")->setMaxResults(1)->getSingleScalarResult();
        }

        foreach ($empresas as $empresa) {
            $empresaArray = $empresa->getDatosArray();
            $out [] = $empresaArray;
        }
        $data ["rows"] = $out;
        return $data;
    }

    function getProvincias() {
        $provincias = $this->orm->createQuery("SELECT p FROM Provincia p")->getResult();
        return $provincias;
    }

    function insertarEmpresa($information) {
        if ($information["emp_id"]) {
            $empresa = $this->getCollectionByid("Empresa", $information["emp_id"]);
            $this->orm->persist($empresa);
            $empresa->setEstado($information["emp_estado"]);
        } else {
            $empresa = new Empresa();
            $this->orm->persist($empresa);
            $empresa->setEstado(1);
        }
        $empresa->setNombre($information["emp_nombre"]);
        $empresa->setCuit($information["emp_cuit"]);
        $empresa->setCondIva($information["emp_cond_iva"]);
        $empresa->setMail($information["emp_mail"]);
        $empresa->setDomicilio($information["emp_domicilio"]);
        $empresa->setComisionACobrar($information["emp_comision"]);

        //We define current date and insert into creationDate atribute
        $tz = 'America/Argentina/Salta';
        $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
        $fecha = $dt->format("Y-m-d");
        $empresa->setFechaCreacion(new \DateTime($fecha));

        $empresa->setCodigoPostal($information["emp_cp"]);
        //$empresa->setProvincia($information["emp_provincia"]);
        $empresa->setProvincia($this->orm->getReference("Provincia", $information["emp_provincia"]));
        $empresa->setLocalidad($information["emp_localidad"]);
        $empresa->setUsuario($information["emp_usuario"]);
        $empresa->setPassword($information["emp_password"]);
        $this->orm->flush();
    }

    public function getById($id) {
        return $this->getCollectionByid("Empresa", $id);
    }

    public function getNombreCondIvas() {
        $condIva = array("", "Consumidor final", "Exento", "Exterior", "Monotributista", "No gravado",
            "Régimen de promoción industrial", "Responsable inscripto", "Responsable no inscripto");
        return $condIva;
    }

    public function getLocalidad($id) {
        $localidad = $this->orm->createQuery("SELECT l FROM localidad l WHERE l.id = :id")->setParameter('id', $id)->getResult();
        return $localidad;
    }

    public function borrarEmpresa($emp_id) {
        $empresa = $this->orm->createQuery("SELECT e FROM Empresa e WHERE e.id=:id")->setParameter("id", $emp_id)->getSingleResult();
        $this->orm->remove($empresa);
        $this->orm->flush();
    }

    public function getJSONempresas($args) {
        $nombre = mb_strtoupper($args['q']['term'], 'utf-8');
        $clientes = $this->db->query("SELECT emp_nombre,emp_id FROM empresa WHERE emp_nombre like '%$nombre%' ORDER BY emp_nombre ASC")->result();
        if ($clientes) {
            foreach ($clientes as $cliente) {
                $data[] = array("id" => $cliente->emp_id, "text" => $cliente->emp_nombre);
            }
        } else {
            $data[] = array("id" => "0", "text" => "No se encontraron resultados..");
        }
        $ret['results'] = $data;
        return $ret;
    }

    function getEmpresaByIdJSON($args) {
        $empresa = $this->orm->createQuery("SELECT e FROM Empresa e WHERE e.id=:id")->setParameter("id", $args["id"])->getSingleResult();
        return $empresa->getDatosArray();
    }

    function getEstadoCuentaAjax($information) {
        $clientes_ids = " emp_id in(" . $information["cliente"] . ")";
        $query = 'select ev.codigo,ev.nombre,emp_nombre cliente,par_importe importe,"pagado" tipo from inscribite_eventos ev
                inner join empresa on emp_nombre=ev.empresa
                inner join inscribite_inscripciones ins on ins.deevento=ev.codigo
                inner join decodificado_renglones on dec_codigo=ins.id
                inner join cobro_renglones on cor_dec_id=dec_id
                inner join pagos_renglones on par_pag_id=cor_pag_id
                inner join pago on pag_id=par_pag_id
                where ' . $clientes_ids . ' and cor_pag_id >0 and pag_pagado_fecha is not null
                union all
                select ev.codigo,ev.nombre,emp_nombre cliente,dec_importe importe,"cobrado no pagado" tipo from inscribite_eventos ev
                inner join empresa on emp_nombre=ev.empresa
                inner join inscribite_inscripciones ins on ins.deevento=ev.codigo
                inner join decodificado_renglones on dec_codigo=ins.id
                inner join cobro_renglones on cor_dec_id=dec_id
                where ' . $clientes_ids . ' and (cor_pag_id =0 or cor_pag_id is null)
                union all
                select ev.codigo,ev.nombre,emp_nombre cliente,dec_importe importe,"decodificado no cobrado" tipo from inscribite_eventos ev
                inner join empresa on emp_nombre=ev.empresa
                inner join inscribite_inscripciones ins on ins.deevento=ev.codigo
                inner join decodificado_renglones on dec_codigo=ins.id
                where ' . $clientes_ids . ' and dec_id not in(select cor_dec_id from cobro_renglones)
                union all
                select ev.codigo,ev.nombre,emp_nombre cliente,fac_imp1 importe,"inscripto no decodificado" tipo from inscribite_eventos ev
                inner join empresa on emp_nombre=ev.empresa
                inner join inscribite_inscripciones ins on ins.deevento=ev.codigo
                inner join inscribite_usuarios usu on usu.dni=ins.deusuario
                inner join facturas on fac_usu_id=usu.id and fac_evento_id=ev.codigo
                where ' . $clientes_ids . ' and ins.id not in(select dec_codigo from decodificado_renglones)
                ';

        //really nigga? that query?
        $qb = $this->db->query($query);
        $registros = $qb->result_array();
        $cant_registros = $qb->num_rows();
        $data["rows"] = $registros;
        $data["total"] = $cant_registros;
        return $data;
    }

    private function procesaClientesIds($clientes) {
        $clientes_ids = "";
        if (($clientes)) {
            foreach ($clientes as $k => $cli_id) {
                $clientes_ids.=$k == 0 ? $cli_id : ',' . $cli_id;
            }
            $clientes_ids = " emp_id in($clientes_ids)";
        } else {
            die('debe elegir clientes');
        }
        return $clientes_ids;
    }

    function getEstadoCuentaTotalesAjax($information) {
        $clientes_ids = " emp_id in(" . $information["cliente"] . ")";
        /* @var $empresa Empresa */
        $empresa = $this->orm->createQuery("SELECT e FROM empresa e WHERE e.id=:id")->setParameter("id", $information["cliente"])->getSingleResult();
        $query = 'select SUM(aux.importe) total,tipo
                    from 
                    (select emp_id,ev.codigo,ev.nombre,emp_nombre cliente,par_importe importe,"pagado" tipo from inscribite_eventos ev
                     inner join empresa on emp_nombre=ev.empresa
                     inner join inscribite_inscripciones ins on ins.deevento=ev.codigo
                     inner join decodificado_renglones on dec_codigo=ins.id
                     inner join cobro_renglones on cor_dec_id=dec_id
                     inner join pagos_renglones on par_pag_id=cor_pag_id
                     inner join pago on pag_id=par_pag_id
                     WHERE ' . $clientes_ids . ' and cor_pag_id >0 and pag_pagado_fecha is not null
                     union all
                     select emp_id,ev.codigo,ev.nombre,emp_nombre cliente,dec_importe importe,"cobrado no pagado" tipo from inscribite_eventos ev
                     inner join empresa on emp_nombre=ev.empresa
                     inner join inscribite_inscripciones ins on ins.deevento=ev.codigo
                     inner join decodificado_renglones on dec_codigo=ins.id
                     inner join cobro_renglones on cor_dec_id=dec_id
                     WHERE ' . $clientes_ids . ' and (cor_pag_id =0 or cor_pag_id is null)
                     union all
                     select emp_id,ev.codigo,ev.nombre,emp_nombre cliente,dec_importe importe,"decodificado no cobrado" tipo from inscribite_eventos ev
                     inner join empresa on emp_nombre=ev.empresa
                     inner join inscribite_inscripciones ins on ins.deevento=ev.codigo
                     inner join decodificado_renglones on dec_codigo=ins.id
                     WHERE ' . $clientes_ids . ' and dec_id not in(select cor_dec_id from cobro_renglones)
                     union all
                     select emp_id,ev.codigo,ev.nombre,emp_nombre cliente,fac_imp1 importe,"inscriptos no decodificados" tipo from inscribite_eventos ev
                     inner join empresa on emp_nombre=ev.empresa
                     inner join inscribite_inscripciones ins on ins.deevento=ev.codigo
                     inner join inscribite_usuarios usu on usu.dni=ins.deusuario
                     inner join facturas on fac_usu_id=usu.id and fac_evento_id=ev.codigo
                     WHERE ' . $clientes_ids . ' and ins.id not in(select dec_codigo from decodificado_renglones))aux
                     group by aux.emp_id,aux.tipo

                ';
        $registros = $this->db->query($query)->result();
        $html = "<h3 style='margin-top:0px;'>" . $empresa->getNombre() . "</h3><ul>";
        foreach ($registros as $cada_total) {
            $html.="<li>" . $cada_total->tipo . ":$" . $cada_total->total . "</li>";
        }
        $html.="</ul>";
        return $html;
    }

    public function getEmpresaEventos($information) {
        $emp_id = $information["emp_id"];
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


        $query = "SELECT aux.emp_id,aux.id,aux.empresa,aux.codigo codigo,aux.evento,SUM(aux.decodificado) decodificado,IFNULL(MAX(pg.total),0) as cobrado,
                    (SUM(aux.decodificado)-IFNULL(MAX(pg.total_bruto),0)) saldo,MAX(pg.iva_comision) iva_comision,aux.llamado llamado,aux.ver ver FROM (
                    select emp_id,ev.id,emp_nombre empresa,ev.codigo codigo,ev.nombre evento,SUM(dec_importe) decodificado,'query1' llamado,ev.ver ver
                    from decodificado_renglones
                    inner join inscribite_usuarios usu on dni=dec_dni
                    inner join facturas on fac_id=dec_codigo
                    inner join inscribite_eventos ev on ev.codigo=fac_evento_id
                    inner join empresa on ev.empresa=emp_nombre
                    where fac_mensualidad =0 AND emp_id=$emp_id
                    group by emp_id,ev.id
                    UNION ALL
                    select emp_id,ev.id,emp_nombre empresa,ev.codigo codigo,ev.nombre evento,SUM(dec_importe) decodificado,'query2' llamado,ev.ver ver
                    from decodificado_renglones
                    inner join inscribite_inscripciones ins on ins.id=dec_codigo
                    inner join inscribite_eventos ev on ev.codigo=deevento
                    inner join empresa on emp_nombre=ev.empresa
                    WHERE emp_id=$emp_id 
                    group by emp_id,ev.id
                    UNION ALL
                    select emp_id,men_id as id,emp_nombre empresa,men_codigo codigo,men_nombre evento,SUM(dec_importe) decodificado,'query3' llamado,men_activo ver
                    from decodificado_renglones
                    inner join inscribite_usuarios usu on dni=dec_dni
                    inner join facturas on fac_id=dec_codigo
                    inner join mensualidad_cuotas on mec_id=fac_mensualidad
                    inner join mensualidades on men_id=mec_men_id
                    inner join empresa on emp_id=men_empresa	
                    where fac_mensualidad > 0 AND emp_id=$emp_id
                    group by emp_id,men_id
                    ) aux
                     LEFT JOIN (select pag_emp_id,CASE WHEN pag_evt_id is null THEN pag_men_id ELSE pag_evt_id END evt_id,ROUND(SUM(par_importe)-(SUM(par_importe)*pag_comision)-((SUM(par_importe)*pag_comision)*0.21),2) total,
                     ROUND((SUM(par_importe)*pag_comision)+((SUM(par_importe)*pag_comision)*0.21),2) iva_comision,SUM(par_importe) total_bruto from pago
                     inner join pagos_renglones on par_pag_id=pag_id
                     inner join liquidacion on liq_id=pag_liq_id 
                     WHERE pag_emp_id=$emp_id
                     group by pag_emp_id,evt_id,pag_comision) pg ON pg.evt_id=aux.codigo
                     WHERE aux.emp_id = $emp_id AND aux.ver=1
                     GROUP BY aux.emp_id,aux.id,aux.empresa,aux.codigo,aux.evento";



        $eventos = $this->db->query($query)->result_array();
        foreach ($eventos as $k => $evento) {
            $eventos[$k]["acciones"] = '<a class="inscripciones ml10" href="' . base_url("empresa-inscripciones/" . $evento["emp_id"] . "/" . $evento["id"]) . '" title="Inscripciones">
            <i class="glyphicon glyphicon-search"></i>
            </a>';
        }

        $data ["total"] = count($eventos);
        $data ["rows"] = $eventos;
        return $data;
    }

    function getInscripcionesDetalles($emp_id, $ev_id) {
        $query = "SELECT aux.der_id,aux.emp_id,aux.id,aux.empresa,aux.evento,(aux.decodificado) decodificado,deportista,dni,der_dni,
                CASE WHEN pg.par_importe IS NULL THEN 'falta cobrar' ELSE 'cobrado' END cobrado,pg.pag_comision comision
                
                FROM (SELECT emp_id,dr.dec_id der_id,emp_nombre empresa,dr.dec_dni der_dni,dr.dec_id,men_id id,med_fecha,CONCAT(usu.nombre,' ',usu.apellido) deportista,men_codigo codigo,CONCAT('cuota:',' ',mec_nro_cuota) categoria,usu.dni,med_tipo,dec_importe decodificado,concat(men_nombre,' cuota ',mec_nro_cuota) evento
                from mediodecodificado
                inner join decodificado_renglones dr on dec_med_id=med_id
                inner join decodificador dc on dc.dec_id=med_dec_id
                inner join facturas on fac_id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                inner join mensualidad_cuotas on mec_id=fac_mensualidad
                inner join mensualidades on men_id=mec_men_id
                inner join empresa on emp_id=men_empresa
                where emp_id=$emp_id and men_id=$ev_id and fac_mensualidad>0
                UNION ALL SELECT emp_id,dr.dec_id der_id,emp_nombre empresa,dr.dec_dni der_dni,dr.dec_id,ev.id,med_fecha,CONCAT(usu.nombre,' ',usu.apellido) deportista,ev.codigo codigo,ins.categoria categoria,usu.dni,med_tipo,dec_importe decodificado,ev.nombre evento
                from mediodecodificado
                inner join decodificado_renglones dr on dec_med_id=med_id
                inner join decodificador dc on dc.dec_id=med_dec_id
                inner join facturas on fac_id=dec_codigo
                inner join inscribite_categorias cat on cat.deevento=fac_evento_id and cat.codigo=fac_cat_id
                inner join inscribite_opciones op on op.evento=fac_evento_id and op.id=fac_op_id
                inner join inscribite_usuarios usu on dni=dec_dni
                left join inscribite_eventos ev on ev.codigo=fac_evento_id
                inner join empresa on emp_nombre=ev.empresa
                INNER JOIN inscribite_inscripciones ins ON ins.deusuario = dec_dni AND ins.deevento = fac_evento_id AND ins.categoria=cat.nombre AND ins.opcion=op.nombre
                where emp_id=$emp_id and ev.id=$ev_id and fac_mensualidad=0
                UNION ALL 
                SELECT emp_id,dr.dec_id der_id,emp_nombre empresa,dr.dec_id,ev.id,dr.dec_dni der_dni, med_fecha,CONCAT(usu.nombre,' ',usu.apellido) deportista,ev.codigo codigo,ins.categoria categoria,usu.dni,med_tipo,dec_importe decodificado,ev.nombre evento
                from mediodecodificado
                inner join decodificador dc on dc.dec_id=med_dec_id
                inner join decodificado_renglones dr on dr.dec_med_id=med_id
                inner join inscribite_inscripciones ins on ins.id=dec_codigo
                inner join inscribite_usuarios usu on dni=dec_dni
                left join inscribite_eventos ev on ev.codigo=deevento
                inner join empresa on emp_nombre=ev.empresa
                where emp_id=$emp_id and ev.id=$ev_id) aux
                LEFT JOIN (select par_dec_id,pag_comision,MAX(par_importe) par_importe
                    from pago 
                    inner join pagos_renglones on par_pag_id=pag_id 
                    inner join liquidacion on liq_id=pag_liq_id 
                    inner join cobro_renglones on cor_pag_id=pag_id 
                    inner join decodificado_renglones on cor_dec_id=dec_id 
                    WHERE pag_emp_id=$emp_id 
                    GROUP BY par_dec_id,pag_comision
                ) pg on pg.par_dec_id=aux.der_id
                    ORDER BY deportista ASC";


        $renglones = $this->db->query($query)->result_array();
        $data ["total"] = count($renglones);
        $data ["rows"] = $renglones;
        return $data;
    }

}

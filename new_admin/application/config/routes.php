<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'web/acceso/login_controller/gidema';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* RUTAS LOGIN */

$route['login'] = 'web/acceso/login_controller/gidema';
$route['logout'] = 'web/acceso/login_controller/logout_ci';
$route['login-validar'] = 'web/acceso/login_controller/validar';
$route['admin-usuarios'] = 'web/usuario/usuario_controller/index';
$route['valida_login'] = 'web/acceso/login_controller/validar';

/* Usuarios */
$route['usuarios'] = 'web/usuario/usuario_controller/index';
$route['editarUsuario/(:num)'] = 'web/usuario/usuario_controller/editar/$1';
$route['editarUsuario'] = 'web/usuario/usuario_controller/editar';
$route['emailsByAjax'] = 'web/admin/usuario_controller/emailsByAjax';


/* Roles */
$route['roles'] = 'web/usuario/rol_controller/index';
$route['rolByAjax'] = 'web/usuario/rol_controller/rolByAjax';

/* RUTAS ADMIN */
$route['migration_update'] = 'web/admin/migrate/index';
$route['admin-panel'] = 'web/admin/panel_controller/index';
$route['nuevo-usuario'] = 'web/usuario/usuario_controller/nuevo_usuario';
$route['maker'] = 'web/admin/panel_controller/maker';
$route['nuevo_form'] = 'web/admin/panel_controller/maker';
$route["sync_db"] = 'web/admin/panel_controller/sync';


/* decodificador rutas */
$route["decodificador"] = "web/admin/Decodificador_controller/index";
$route["decodificador/(:num)"] = "web/admin/Decodificador_controller/index/$1";
$route["reprocesar-medio/(:num)"] = "web/admin/Decodificador_controller/reprocesar/$1";
$route["borrardecodificador/(:num)"] = "web/admin/Decodificador_controller/borrardecodificador/$1";
$route["getDecodificadorAjax"] = "web/admin/Decodificador_controller/getDecodificadorAjax";
$route["xls_decodificador/(:num)"] = "web/admin/Decodificador_controller/xls_decodificador/$1";
$route["xls_acumulado"] = "web/admin/Decodificador_controller/xls_acumulado";
$route["xls_acumulado/(:any)"] = "web/admin/Decodificador_controller/xls_acumulado/$1";
$route["xls_acumulado/(:any)"] = "web/admin/Decodificador_controller/xls_acumulado/$1";
$route["avisaPagos"] = "web/admin/Decodificador_controller/avisa_pagos";



/* liquidacion rutas */
$route["liquidacion"] = "web/admin/Liquidacion_controller/index";
$route["liquidacion/(:num)"] = "web/admin/Liquidacion_controller/index/$1";
$route["admin-liquidacion/borrar/(:num)"] = "web/admin/Liquidacion_controller/borrar/$1";
$route["admin-liquidacion/pagar/(:num)"] = "web/admin/Liquidacion_controller/pagar/$1";
$route["getLiquidacionAjax"] = "web/admin/Liquidacion_controller/getLiquidacionAjax";
$route["getLiquidacionAjax/(:num)"] = "web/admin/Liquidacion_controller/getLiquidacionAjax/$1";
$route["renglonePagosLiquidacion/(:num)"] = "web/Web_controller/getRenglonesPagos/$1";
$route["renglonePagosLiquidacion"] = "web/Web_controller/getRenglonesPagos";
$route["reportePagosLiquidacion/(:num)"] = "web/admin/Liquidacion_controller/getReporteLiquidacion/$1";



/* Pagos */
$route['pagos'] = 'web/pago/Pago_Controller/index';
$route['nuevo_pago'] = 'web/pago/Pago_Controller/nuevo';
$route['ver_pago/(:num)'] = "web/pago/Pago_Controller/ver/$1";
$route['editar_pago/(:num)'] = 'web/pago/Pago_Controller/index/$1';
$route['editar_pago'] = 'web/pago/Pago_Controller/editar';
$route['borrar_pago/(:num)'] = 'web/pago/Pago_Controller/borrar/$1';
$route['traerPagoById'] = 'web/pago/Pago_Controller/obtenerPagoJson';
$route['renglonesPagoDetalle'] = 'web/pago/Pago_Controller/renglonesPagoDetalle';
$route['renglonesPagoDetalle/(:num)'] = 'web/pago/Pago_Controller/renglonesPagoDetalle/$1';
$route['renglonesPagoDocumento/(:num)'] = 'web/pago/Pago_Controller/renglonesPagoDocumento/$1';
$route['getDocumentosPago/(:num)'] = 'web/pago/Pago_Controller/getDocumentosPago/$1';
$route['getDetallesPago/(:num)'] = 'web/pago/Pago_Controller/getDetallesPago/$1';
$route['getPagoById/(:num)'] = 'web/pago/Pago_Controller/getPagoById/$1';
$route['proveedoresSelect2'] = 'web/empresa/EmpresaController/getJSONEmpresas';
$route['JSONempresaById'] = 'web/empresa/EmpresaController/JSONempresaById';
$route['getPagoTableAjax'] = "web/pago/Pago_Controller/getPagoTableAjax";
$route["admin-pago/pagar/(:num)"] = "web/pago/Pago_Controller/setFechaPago/$1";

/* transferencias */
$route['transferencias'] = 'web/pago/Pago_Controller/index';
$route['renglonesTransferenciaDocumento/(:num)'] = 'web/pago/Pago_Controller/renglonesPagoDocumento/$1';
$route['getTransferenciasAjax'] = 'web/pago/Pago_Controller/getPagosAjax';
$route['getDocumentosTransferencias/(:num)'] = 'web/pago/Pago_Controller/getDocumentosPago/$1';
$route['getDetallesTransferencia/(:num)'] = 'web/pago/Pago_Controller/getDetallesPago/$1';
$route['getTransferenciaById/(:num)'] = 'web/pago/Pago_Controller/getPagoById/$1'; /* cobro rutas */
$route["cobro"] = "web/admin/Cobro_controller/index";
$route["cobro/(:num)"] = "web/admin/Cobro_controller/index/$1";
$route["getCobroAjax"] = "web/admin/Cobro_controller/getCobroAjax";
$route["xls_cobro_renglones/(:num)"] = "web/admin/Cobro_controller/xls_cobro_renglones/$1";
$route["borrarcobro/(:num)"] = "web/admin/Cobro_controller/borrar/$1";
$route["admin-cobro/generaPagos/(:num)"] = "web/admin/Cobro_controller/generaPagos/$1";
$route["admin-cobro-genera"] = "web/admin/Cobro_controller/generaTotalPagos";

/* solicitudtransferencia rutas */
$route["solicitudtransferencia"] = "web/admin/Solicitudtransferencia_controller/index";
$route['renglonesTransferenciaDetalle'] = 'web/admin/solicitudtransferencia_controller/renglonesTransferenciaDetalle';
$route['renglonesTransferenciaDetalle/(:num)'] = 'web/admin/solicitudtransferencia_controller/renglonesTransferenciaDetalle/$1';
$route["editar_solicitud_transferencia/(:num)"] = "web/admin/Solicitudtransferencia_controller/index/$1";
$route["getSolTransTableAjax"] = "web/admin/Solicitudtransferencia_controller/getSolTransTableAjax";
$route['pagoSelect2'] = 'web/pago/Pago_Controller/getJSONPagos';
$route["borrarsolicitudtransferencia/(:num)"] = 'web/admin/Solicitudtransferencia_controller/borrarSolicitudTransferencia/$1';

/* Clientes */
$route['cliente'] = "web/empresa/EmpresaController/index";
$route["cliente/(:num)"] = "web/empresa/EmpresaController/index/$1";
$route["borrarCliente/(:num)"] = "web/empresa/EmpresaController/borrarCliente/$1";
$route['getEmpresaTableAjax'] = "web/empresa/EmpresaController/getEmpresaTableAjax";
$route['getEmpresaEventos'] = "web/empresa/EmpresaController/getEmpresaEventos";
$route['cliente-inscripciones/(:num)'] = "web/empresa/EmpresaController/getEmpresaInscripciones/$1";
$route['empresa-inscripciones/(:num)/(:num)'] = "web/empresa/EmpresaController/getInscripcionesDetalles/$1/$2";



/* mediodecodificado rutas */
$route["mediodecodificado"] = "web/admin/Mediodecodificado_controller/index";
$route["mediodecodificado/(:num)"] = "web/admin/Mediodecodificado_controller/index/$1";
$route["getMediodecodificadoAjax"] = "web/admin/Mediodecodificado_controller/getMediodecodificadoAjax";

/* Localidades */
$route['traerLocalidades/(:num)'] = 'web/general/Provincias_controller/getJSONLocalidades/$1';

/* decodificado_renglones rutas */
$route["decodificado_renglones"] = "web/admin/Decodificado_renglones_controller/index";
$route["decodificado_renglones/(:num)"] = "web/admin/Decodificado_renglones_controller/index/$1";
$route["getDecodificado_renglonesAjax"] = "web/admin/Decodificado_renglones_controller/getDecodificado_renglonesAjax";
/* empresacuenta rutas */
$route["empresacuenta"] = "web/admin/Empresacuenta_controller/index";
$route["empresacuenta/(:num)"] = "web/admin/Empresacuenta_controller/index/$1";
$route["getEmpresacuentaAjax"] = "web/admin/Empresacuenta_controller/getEmpresacuentaAjax";


/* Reportes */
$route["reporte-estado-cuenta-cliente"] = "web/Reporte_controller/estadoCuenta";
$route["reporte-estado-cuenta-cliente-ajax"] = "web/Reporte_controller/estadoCuentaAjax";
$route["rep-cuenta-ajax-totales"] = "web/Reporte_controller/estadoCuentaTotalesAjax";
$route["rep-mi-estado-cuenta"] = "web/Reporte_controller/miEstadoCuenta";



/* variables rutas */
$route["variables"] = "web/admin/Variables_controller/index";
$route["variables/(:num)"] = "web/admin/Variables_controller/index/$1";
$route["getVariablesAjax"] = "web/admin/Variables_controller/getVariablesAjax";
/* mailing rutas */
$route["mailing"] = "web/admin/Mailing_controller/index";
$route["mailing/(:num)"] = "web/admin/Mailing_controller/index/$1";
$route["getMailingAjax"] = "web/admin/Mailing_controller/getMailingAjax";
$route["carga-email"] = 'web/admin/Mailing_controller/nuevoMail';
/* listadifusion rutas */
$route["admin-listadifusion"] = "web/admin/Listadifusion_controller/index";
$route["admin-listadifusion/(:num)"] = "web/admin/Listadifusion_controller/index/$1";
$route["getListadifusionAjax"] = "web/admin/Listadifusion_controller/getListadifusionAjax";

/* atributo rutas */
$route["admin-atributo"] = "web/admin/Atributo_controller/index";
$route["admin-atributo/(:num)"] = "web/admin/Atributo_controller/index/$1";
$route["admin-atributo/borrar/(:num)"] = "web/admin/Atributo_controller/borrar/$1";
$route["getAtributoAjax"] = "web/admin/Atributo_controller/getAtributoAjax";
/* tipoatributo rutas */
$route["admin-tipoatributo"] = "web/admin/Tipoatributo_controller/index";
$route["admin-tipoatributo/(:num)"] = "web/admin/Tipoatributo_controller/index/$1";
$route["admin-tipoatributo/borrar/(:num)"] = "web/admin/Tipoatributo_controller/borrar/$1";
$route["getTipoatributoAjax"] = "web/admin/Tipoatributo_controller/getTipoatributoAjax";
/* guardavida rutas */
$route["admin-guardavida"] = "web/admin/Guardavida_controller/index";
$route["admin-guardavida/(:num)"] = "web/admin/Guardavida_controller/index/$1";
$route["admin-guardavida/borrar/(:num)"] = "web/admin/Guardavida_controller/borrar/$1";
$route["getGuardavidaAjax"] = "web/admin/Guardavida_controller/getGuardavidaAjax";
$route['guardaVidaemailsByAjax'] = 'web/admin/Guardavida_controller/emailsByAjax';


/* web */
$route["registro-guardavida"] = "web/Web_controller/index";
$route["registro-guardavida/(:any)"] = "web/Web_controller/index/$1";

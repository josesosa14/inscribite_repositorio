<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_default_schema extends CI_Migration {

    public function up() {
        $query = "

CREATE TABLE IF NOT EXISTS `archivo` (
  `arc_id` int(11) NOT NULL,
  `arc_uid` int(11) NOT NULL,
  `arc_nombre` varchar(300) NOT NULL,
  `arc_total_rows` int(11) NOT NULL,
  `arc_total_cols` int(11) NOT NULL,
  `arc_campos` text NOT NULL,
  `arc_fec_in` datetime NOT NULL,
  `arc_total_hojas` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

CREATE TABLE IF NOT EXISTS `banco` (
  `ban_id` int(11) NOT NULL,
  `ban_nombre` varchar(100) NOT NULL DEFAULT '0',
  `ban_activo` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cheque`
--

CREATE TABLE IF NOT EXISTS `cheque` (
  `cheque_id` int(11) NOT NULL,
  `cheque_numero` varchar(50) NOT NULL DEFAULT '0',
  `cheque_fecha_ingreso` date NOT NULL,
  `cheque_banco_id` int(11) NOT NULL DEFAULT '0',
  `cheque_fecha_vencimiento` date NOT NULL,
  `cheque_importe` double NOT NULL DEFAULT '0',
  `cheque_estado` int(2) NOT NULL DEFAULT '0',
  `cheque_fecha_salida` date DEFAULT NULL,
  `cheque_destino` int(11) DEFAULT '0',
  `cheque_comentario` varchar(50) DEFAULT '0',
  `cheque_activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `cli_id` int(11) NOT NULL,
  `cli_razonsocial` varchar(200) DEFAULT NULL,
  `cli_cuit` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_domicilio_comercial`
--

CREATE TABLE IF NOT EXISTS `cliente_domicilio_comercial` (
  `clc_id` int(11) NOT NULL,
  `clc_razon_social_comercial` varchar(250) CHARACTER SET latin1 DEFAULT '0',
  `clc_calle` varchar(200) CHARACTER SET latin1 DEFAULT '0',
  `clc_numero` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `clc_piso` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `clc_departamento` varchar(10) CHARACTER SET latin1 DEFAULT '0',
  `clc_localidad` varchar(128) DEFAULT NULL,
  `clc_provincia` int(11) DEFAULT '0',
  `clc_cod_postal` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `clc_prefijo` varchar(10) DEFAULT '0',
  `clc_telefono` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `clc_email_publicacion` varchar(200) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_domicilio_legal`
--

CREATE TABLE IF NOT EXISTS `cliente_domicilio_legal` (
  `cll_id` int(11) NOT NULL,
  `cll_calle` varchar(200) DEFAULT '0',
  `cll_numero` varchar(50) DEFAULT '0',
  `cll_piso` varchar(50) DEFAULT '0',
  `cll_departamento` varchar(10) DEFAULT '0',
  `cll_localidad` varchar(128) DEFAULT NULL,
  `cll_provincia` int(11) DEFAULT '0',
  `cll_cod_postal` varchar(50) DEFAULT '0',
  `cll_prefijo` varchar(10) DEFAULT '0',
  `cll_telefono` varchar(50) DEFAULT '0',
  `cll_email` varchar(200) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobro`
--

CREATE TABLE IF NOT EXISTS `cobro` (
  `cobro_id` int(11) NOT NULL,
  `cobro_fecha` date DEFAULT NULL,
  `cobro_numero_recibo` varchar(120) NOT NULL DEFAULT '0',
  `cobro_cue_id` int(11) NOT NULL DEFAULT '0',
  `cobro_cliente` int(11) NOT NULL DEFAULT '0',
  `cobro_activo` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobro_detalle`
--

CREATE TABLE IF NOT EXISTS `cobro_detalle` (
  `cod_id` int(11) NOT NULL,
  `cod_cob_id` int(11) NOT NULL DEFAULT '0',
  `cod_tipo_valor` int(11) NOT NULL DEFAULT '0',
  `cod_banco` int(11) DEFAULT '0',
  `cod_fecha` date DEFAULT NULL,
  `cod_numero` varchar(50) DEFAULT NULL,
  `cod_importe` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobro_factura`
--

CREATE TABLE IF NOT EXISTS `cobro_factura` (
  `cof_id` int(11) NOT NULL,
  `cof_cob_id` int(11) NOT NULL DEFAULT '0',
  `cof_fac_id` int(11) NOT NULL DEFAULT '0',
  `cof_cobranza` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condiva`
--

CREATE TABLE IF NOT EXISTS `condiva` (
  `condiva_id` int(11) NOT NULL,
  `condiva_nombre` varchar(100) DEFAULT '0',
  `condiva_activo` varchar(100) DEFAULT '0',
  `condiva_importe` decimal(5,4) DEFAULT '0.0000'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE IF NOT EXISTS `cuenta` (
  `cue_id` int(11) NOT NULL,
  `cue_nombre` varchar(100) DEFAULT NULL,
  `cue_tipo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentaempresa`
--

CREATE TABLE IF NOT EXISTS `cuentaempresa` (
  `cue_id` int(11) NOT NULL,
  `cue_nombre` varchar(200) DEFAULT NULL,
  `cue_tipo` enum('activo','pasivo','gasto') NOT NULL DEFAULT 'gasto',
  `cue_activa` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `decodificador`
--

CREATE TABLE IF NOT EXISTS `decodificador` (
  `dec_id` int(11) NOT NULL,
  `dec_pagofacil` varchar(200) DEFAULT NULL,
  `dec_rapipago` varchar(200) DEFAULT NULL,
  `dec_pagomiscuentas` varchar(200) DEFAULT NULL,
  `dec_tarjeta` varchar(200) DEFAULT NULL,
  `dec_observaciones` varchar(300) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `decodificado_renglones`
--

CREATE TABLE IF NOT EXISTS `decodificado_renglones` (
  `dec_id` int(11) NOT NULL,
  `dec_dni` int(10) DEFAULT NULL,
  `dec_codigo` varchar(50) DEFAULT NULL,
  `dec_importe` decimal(10,2) DEFAULT NULL,
  `dec_fechapago` date DEFAULT NULL,
  `dec_med_id` int(11) NOT NULL,
  `dec_fechaacreditacion` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_cliente`
--

CREATE TABLE IF NOT EXISTS `documento_cliente` (
  `doc_id` int(11) NOT NULL,
  `doc_numero` varchar(50) DEFAULT NULL,
  `doc_fecha` date DEFAULT NULL,
  `doc_estado` int(11) DEFAULT NULL,
  `doc_cliente_id` int(11) DEFAULT NULL,
  `doc_tipo` enum('factura a','factura b','factura c','factura m','nota credito a','nota credito b','nota credito c','nota credito m','nota debito a','nota debito b','nota debito c','nota debito m') NOT NULL DEFAULT 'factura a',
  `doc_importe` decimal(10,2) DEFAULT '0.00',
  `doc_comentario` text,
  `doc_fecha_pago` date DEFAULT NULL,
  `doc_desde` date DEFAULT NULL,
  `doc_hasta` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_percepciones`
--

CREATE TABLE IF NOT EXISTS `documento_percepciones` (
  `dpp_id` int(11) NOT NULL,
  `dpp_dop_id` int(11) NOT NULL,
  `dpp_per_id` int(11) NOT NULL,
  `dpp_importe` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_proveedor`
--

CREATE TABLE IF NOT EXISTS `documento_proveedor` (
  `dop_id` int(11) NOT NULL,
  `dop_numero` varchar(50) NOT NULL DEFAULT '0',
  `dop_fecha` date DEFAULT NULL,
  `dop_estado` tinyint(1) NOT NULL DEFAULT '0',
  `dop_proveedor_id` int(11) NOT NULL DEFAULT '0',
  `dop_importe` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dop_tipo` enum('factura a','factura b','factura c','factura m','nota credito a','nota credito b','nota credito c','nota credito m','nota debito a','nota debito b','nota debito c','nota debito m') NOT NULL DEFAULT 'factura a'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `emp_id` int(10) NOT NULL,
  `emp_nombre` varchar(120) NOT NULL,
  `emp_cuit` int(12) NOT NULL,
  `emp_cond_iva` varchar(150) NOT NULL,
  `emp_mail` varchar(120) NOT NULL,
  `emp_domicilio` varchar(200) NOT NULL,
  `emp_cp` int(6) NOT NULL,
  `emp_fecha_in` date NOT NULL,
  `emp_localidad` int(6) NOT NULL,
  `emp_provincia` int(2) NOT NULL,
  `emp_usuario` varchar(120) NOT NULL,
  `emp_password` varchar(120) NOT NULL,
  `emp_estado` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `error`
--

CREATE TABLE IF NOT EXISTS `error` (
  `err_id` int(11) NOT NULL,
  `err_tipo` varchar(64) DEFAULT NULL,
  `err_usu_id` int(11) DEFAULT NULL,
  `err_mensaje` text CHARACTER SET latin1,
  `err_resuelto` tinyint(4) DEFAULT '0',
  `err_fec_in` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_cheque`
--

CREATE TABLE IF NOT EXISTS `estado_cheque` (
  `estado_cheque_id` int(11) NOT NULL,
  `estado_cheque_nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pago`
--

CREATE TABLE IF NOT EXISTS `estado_pago` (
  `id_estado_pago` int(11) NOT NULL,
  `nombre_estado_pago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE IF NOT EXISTS `facturas` (
  `fac_id` int(15) NOT NULL,
  `fac_evento_id` int(10) NOT NULL,
  `fac_venc1` date DEFAULT NULL,
  `fac_imp1` decimal(9,2) NOT NULL,
  `fac_venc2` date DEFAULT NULL,
  `fac_imp2` decimal(9,2) NOT NULL,
  `fac_venc3` date DEFAULT NULL,
  `fac_imp3` decimal(9,2) NOT NULL,
  `fac_fecha_in` datetime DEFAULT NULL,
  `fac_usu_id` int(10) NOT NULL,
  `fac_cat_id` int(11) NOT NULL,
  `fac_op_id` int(11) NOT NULL,
  `fac_pedido` tinyint(4) NOT NULL DEFAULT '0',
  `fac_fecha_pedido` date DEFAULT NULL,
  `fac_mensualidad` tinyint(1) NOT NULL DEFAULT '0',
  `fac_tipo` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5773 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_pagas`
--

CREATE TABLE IF NOT EXISTS `facturas_pagas` (
  `facp_id` int(10) NOT NULL,
  `facp_fecha_aplicacion` date NOT NULL,
  `facp_fecha_acreditacion` date NOT NULL,
  `facp_fecha_in` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `facp_monto` decimal(9,2) NOT NULL,
  `facp_fac_id` int(10) NOT NULL,
  `facp_archivo` varchar(20) NOT NULL,
  `facp_avisado` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=2043 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_rp_pagas`
--

CREATE TABLE IF NOT EXISTS `facturas_rp_pagas` (
  `facp_id` int(10) NOT NULL,
  `facp_fecha_aplicacion` date NOT NULL,
  `facp_fecha_acreditacion` date NOT NULL,
  `facp_fecha_in` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `facp_monto` decimal(9,2) NOT NULL,
  `facp_fac_id` int(10) NOT NULL,
  `facp_archivo` varchar(20) NOT NULL,
  `facp_avisado` tinyint(1) DEFAULT '0',
  `facp_dni` int(11) DEFAULT NULL,
  `facp_evento` int(11) DEFAULT NULL,
  `facp_categoria` int(11) DEFAULT NULL,
  `facp_empresa` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2718 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_venta_articulo`
--

CREATE TABLE IF NOT EXISTS `factura_venta_articulo` (
  `fva_id` int(11) NOT NULL,
  `fva_ver_id` int(11) NOT NULL,
  `fva_fac_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscribite_categorias`
--

CREATE TABLE IF NOT EXISTS `inscribite_categorias` (
  `id` int(7) NOT NULL,
  `deevento` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `opcion` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `nombre` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `codigo` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8_unicode_ci NOT NULL,
  `limitedeedad` int(1) NOT NULL DEFAULT '0',
  `edadminima` int(3) NOT NULL DEFAULT '0',
  `edadmaxima` int(3) NOT NULL DEFAULT '0',
  `fechadecomputo` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `sexo` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `precio1` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `precio2` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `precio3` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fechavenc1` int(8) NOT NULL DEFAULT '0',
  `fechavenc2` int(8) NOT NULL DEFAULT '0',
  `fechavenc3` int(8) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=16178 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscribite_eventos`
--

CREATE TABLE IF NOT EXISTS `inscribite_eventos` (
  `id` int(7) NOT NULL,
  `orden` int(4) NOT NULL DEFAULT '0',
  `ver` int(1) NOT NULL DEFAULT '0',
  `nombre` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `web` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `fecha` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `fechaord` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `codigo` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8_unicode_ci NOT NULL,
  `imagen` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `imagen1` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `imagen2` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `tipo` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `empresa` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `opcion1` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `opcion2` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `opcion3` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `opcion4` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `logo` tinytext CHARACTER SET latin1 NOT NULL,
  `eventodelmes` int(1) NOT NULL DEFAULT '0',
  `pubdate` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `textoencupon` text COLLATE utf8_unicode_ci NOT NULL,
  `codigodedescuento` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `porcentajedescuento` int(3) NOT NULL DEFAULT '0',
  `puntos` int(7) NOT NULL DEFAULT '0',
  `pregunta1` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `pregunta2` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `pregunta3` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `mostrarcinscriptos` int(1) NOT NULL DEFAULT '0',
  `textoemailreserva` text COLLATE utf8_unicode_ci NOT NULL,
  `textoemailconfirma` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=695 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscribite_inscripciones`
--

CREATE TABLE IF NOT EXISTS `inscribite_inscripciones` (
  `id` int(7) NOT NULL,
  `deusuario` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `empresa` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `deevento` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `categoria` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `opcion` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `codigo` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `iniciadoeldia` date NOT NULL DEFAULT '0000-00-00',
  `venceeldia` int(8) NOT NULL DEFAULT '0',
  `pagado` int(1) NOT NULL DEFAULT '0',
  `pagoeldia` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `selemandomail` int(1) NOT NULL DEFAULT '0',
  `precio` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `respuestapart1` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `respuestapart2` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `respuestapart3` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `mes` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cargopuntos` int(1) NOT NULL DEFAULT '0',
  `pmc` tinyint(4) DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=114348 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscribite_opciones`
--

CREATE TABLE IF NOT EXISTS `inscribite_opciones` (
  `id` int(7) NOT NULL,
  `nombre` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `evento` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cupo` int(7) NOT NULL DEFAULT '0',
  `cuporestante` int(7) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=1568 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscribite_usuarios`
--

CREATE TABLE IF NOT EXISTS `inscribite_usuarios` (
  `id` int(7) NOT NULL,
  `nombre` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `apellido` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dni` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fechanac` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sexo` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `telefonoparticular` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `telefonolaboral` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `telefonocelular` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `domicilio` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `localidad` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `provincia` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pais` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `entrenador` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pileta` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `puntos` int(7) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=53199 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liqudacion_cuentas`
--

CREATE TABLE IF NOT EXISTS `liqudacion_cuentas` (
  `lic_id` int(11) NOT NULL,
  `lic_liq_id` int(11) NOT NULL DEFAULT '0',
  `lic_cue_id` int(11) NOT NULL DEFAULT '0',
  `lic_importe` decimal(9,2) NOT NULL DEFAULT '0.00',
  `lic_entrego` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lic_recibio` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidacion`
--

CREATE TABLE IF NOT EXISTS `liquidacion` (
  `liq_id` int(11) NOT NULL,
  `liq_inicio` date DEFAULT NULL,
  `liq_fin` date DEFAULT NULL,
  `liq_ingresos` decimal(10,2) DEFAULT NULL,
  `liq_gastos` decimal(10,2) DEFAULT NULL,
  `liq_observaciones` varchar(300) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidacion_cobros_detalles`
--

CREATE TABLE IF NOT EXISTS `liquidacion_cobros_detalles` (
  `lcd_id` int(11) NOT NULL,
  `lcd_liq_id` int(11) NOT NULL DEFAULT '0',
  `lcd_cod_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidacion_pagos_detalles`
--

CREATE TABLE IF NOT EXISTS `liquidacion_pagos_detalles` (
  `lpd_id` int(11) NOT NULL,
  `lpd_liq_id` int(11) NOT NULL DEFAULT '0',
  `lpd_pad_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidades`
--

CREATE TABLE IF NOT EXISTS `localidades` (
  `id` int(8) NOT NULL,
  `id_provincia` tinyint(3) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `codigo_postal` smallint(5) unsigned NOT NULL,
  `peso` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=22709 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mediodecodificado`
--

CREATE TABLE IF NOT EXISTS `mediodecodificado` (
  `med_id` int(11) NOT NULL,
  `med_tipo` varchar(50) DEFAULT NULL,
  `med_cant_registros` int(4) DEFAULT NULL,
  `med_total` varchar(50) DEFAULT NULL,
  `med_fecha` varchar(50) DEFAULT NULL,
  `med_nombre_archivo` varchar(120) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensualidades`
--

CREATE TABLE IF NOT EXISTS `mensualidades` (
  `men_id` int(11) NOT NULL,
  `men_nombre` varchar(150) NOT NULL,
  `men_descripcion` varchar(200) NOT NULL,
  `men_activo` tinyint(1) NOT NULL,
  `men_codigo` int(7) NOT NULL,
  `men_empresa` int(11) NOT NULL,
  `men_cuotas` int(11) NOT NULL,
  `men_punitorio` decimal(6,3) NOT NULL,
  `men_texto_cupon` varchar(200) NOT NULL,
  `men_imagen` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensualidad_cuotas`
--

CREATE TABLE IF NOT EXISTS `mensualidad_cuotas` (
  `mec_id` int(11) NOT NULL,
  `mec_men_id` int(11) NOT NULL,
  `mec_imp_1` decimal(6,2) NOT NULL,
  `mec_venc_1` date NOT NULL,
  `mec_imp_2` decimal(6,2) NOT NULL,
  `mec_venc_2` date NOT NULL,
  `mec_imp_3` decimal(6,2) NOT NULL,
  `mec_venc_3` date NOT NULL,
  `mec_nro_cuota` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensualidad_cuota_usuario`
--

CREATE TABLE IF NOT EXISTS `mensualidad_cuota_usuario` (
  `meu_id` int(11) NOT NULL,
  `meu_u_dni` int(11) NOT NULL,
  `meu_mec_id` int(11) NOT NULL,
  `meu_importe` decimal(9,2) NOT NULL,
  `meu_fecha` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1382 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensualidad_usuario`
--

CREATE TABLE IF NOT EXISTS `mensualidad_usuario` (
  `meu_id` int(11) NOT NULL,
  `meu_u_dni` int(11) NOT NULL,
  `meu_men_id` int(11) NOT NULL,
  `meu_fecha_in` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=918 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE IF NOT EXISTS `pago` (
  `pag_id` int(11) NOT NULL,
  `pag_emp_id` int(11) NOT NULL,
  `pag_fecha_in` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pag_fecha` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_renglones`
--

CREATE TABLE IF NOT EXISTS `pagos_renglones` (
  `par_id` int(11) NOT NULL,
  `par_pag_id` int(11) NOT NULL,
  `par_importe` decimal(10,2) NOT NULL,
  `par_numero` varchar(15) DEFAULT NULL,
  `par_ban_id` int(11) DEFAULT NULL,
  `par_tip_id` int(2) NOT NULL,
  `par_fecha` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `percepcion`
--

CREATE TABLE IF NOT EXISTS `percepcion` (
  `per_id` int(11) NOT NULL,
  `per_nombre` varchar(90) NOT NULL DEFAULT '0',
  `per_activa` tinyint(1) NOT NULL DEFAULT '0',
  `per_peso` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE IF NOT EXISTS `permiso` (
  `permiso_id` int(11) NOT NULL,
  `permiso_nombre` varchar(32) NOT NULL,
  `permiso_descripcion` varchar(128) NOT NULL,
  `permiso_peso` int(11) DEFAULT '0',
  `permiso_fecha_in` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `persona_id` int(11) NOT NULL,
  `persona_nombres` varchar(128) DEFAULT '0',
  `persona_apellidos` varchar(128) DEFAULT '0',
  `persona_fecha_nacimiento` date DEFAULT '0000-00-00',
  `persona_tipo_documento_id` int(11) DEFAULT NULL,
  `persona_nro_documento` varchar(64) DEFAULT NULL,
  `persona_email` varchar(64) DEFAULT NULL,
  `persona_telefono` varchar(25) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE IF NOT EXISTS `proveedor` (
  `proveedor_id` int(11) NOT NULL,
  `proveedor_razon_social` varchar(50) DEFAULT NULL,
  `proveedor_cuit` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `proveedor_servicio` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `proveedor_condiva_id` int(11) NOT NULL DEFAULT '0',
  `proveedor_telefono` int(11) NOT NULL DEFAULT '0',
  `proveedor_provincia` int(11) DEFAULT '0',
  `proveedor_localidad` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `proveedor_calle` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `proveedor_piso` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `proveedor_dpto` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `proveedor_cp` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `proveedor_altura` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `proveedor_comentario` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `proveedor_activo` int(11) DEFAULT NULL,
  `proveedor_contacto` varchar(50) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE IF NOT EXISTS `provincias` (
  `id` int(3) NOT NULL,
  `ISO_3166-2` char(4) NOT NULL,
  `ISO_3166-2_letra` char(1) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `superficie` mediumint(8) unsigned NOT NULL COMMENT 'Expresada en kilómetros cuadrados',
  `peso` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE IF NOT EXISTS `proyecto` (
  `pro_id` int(11) NOT NULL,
  `pro_nombre` varchar(150) DEFAULT NULL,
  `pro_inicio` datetime DEFAULT NULL,
  `pro_activo` bit(1) DEFAULT b'0',
  `pro_fin` datetime DEFAULT NULL,
  `pro_horas` int(4) DEFAULT NULL,
  `pro_cliente` int(150) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `rol_id` int(11) NOT NULL,
  `rol_nombre` varchar(32) NOT NULL,
  `rol_descripcion` varchar(128) NOT NULL,
  `rol_peso` int(11) DEFAULT '0',
  `rol_fecha_in` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rol_panel` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permiso`
--

CREATE TABLE IF NOT EXISTS `rol_permiso` (
  `rp_id` int(11) NOT NULL,
  `rp_rol_id` int(11) DEFAULT NULL,
  `rp_permiso_id` int(11) DEFAULT NULL,
  `rp_fecha_in` datetime NOT NULL,
  `rp_consulta` bit(1) NOT NULL DEFAULT b'0',
  `rp_editar` bit(1) NOT NULL DEFAULT b'0',
  `rp_borrar` bit(1) NOT NULL DEFAULT b'0',
  `rp_alta` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudtransferencia`
--

CREATE TABLE IF NOT EXISTS `solicitudtransferencia` (
  `sol_id` int(11) NOT NULL,
  `sol_importe` varchar(150) DEFAULT NULL,
  `sol_cbu` varchar(150) DEFAULT NULL,
  `sol_cuit` varchar(150) DEFAULT NULL,
  `sol_destinatario` varchar(150) DEFAULT NULL,
  `sol_cliente` varchar(50) DEFAULT NULL,
  `sol_pago` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla1`
--

CREATE TABLE IF NOT EXISTS `tabla1` (
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `dni` varchar(255) DEFAULT NULL,
  `fecnac` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla2`
--

CREATE TABLE IF NOT EXISTS `tabla2` (
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `dni` varchar(255) DEFAULT NULL,
  `fecnac` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

CREATE TABLE IF NOT EXISTS `tarea` (
  `tar_id` int(11) NOT NULL,
  `tar_nombre` varchar(150) DEFAULT NULL,
  `tar_estimado` int(4) DEFAULT NULL,
  `tar_real` int(4) DEFAULT NULL,
  `tar_proyecto` int(40) DEFAULT NULL,
  `tar_descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `tic_id` int(11) NOT NULL,
  `tic_titulo` varchar(200) DEFAULT NULL,
  `tic_inicio` varchar(40) DEFAULT NULL,
  `tic_fin` varchar(40) DEFAULT NULL,
  `tic_activo` bit(1) DEFAULT b'0',
  `tic_estimado` int(3) DEFAULT NULL,
  `tic_real` int(3) DEFAULT NULL,
  `tic_tipo` varchar(40) DEFAULT NULL,
  `tic_descripcion` text,
  `tic_pro_id` int(11) DEFAULT NULL,
  `tic_usu_id` int(11) NOT NULL,
  `tic_fecha_in` datetime DEFAULT NULL,
  `tic_fecha_ticket` datetime DEFAULT NULL,
  `tic_fecha_cerrado` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopago`
--

CREATE TABLE IF NOT EXISTS `tipopago` (
  `tip_id` int(11) NOT NULL,
  `tip_nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cheque`
--

CREATE TABLE IF NOT EXISTS `tipo_cheque` (
  `tipo_cheque_id` int(11) NOT NULL,
  `tipo_cheque_nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_de_documento`
--

CREATE TABLE IF NOT EXISTS `tipo_de_documento` (
  `tipo_documento_id` int(11) NOT NULL,
  `tipo_documento_nombre` varchar(32) NOT NULL DEFAULT '0',
  `tipo_documento_descripcion` varchar(64) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE IF NOT EXISTS `tipo_pago` (
  `tipo_pago_id` int(11) NOT NULL,
  `tipo_pago_nombre` varchar(50) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `usuario_id` int(11) NOT NULL,
  `usuario_nombre` varchar(128) NOT NULL,
  `usuario_password` varchar(256) NOT NULL,
  `usuario_persona_id` int(11) DEFAULT NULL,
  `usuario_email` varchar(64) NOT NULL,
  `usuario_last_login` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `usuario_fecha_in` datetime DEFAULT '0000-00-00 00:00:00',
  `usuario_activo` tinyint(4) NOT NULL DEFAULT '1',
  `usuario_rol_id` int(11) NOT NULL,
  `usuario_token` varchar(256) DEFAULT NULL,
  `usuario_fb` text,
  `usuario_fb_image` text,
  `usuario_foto_id` int(11) DEFAULT NULL,
  `usuario_foto_extension` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE IF NOT EXISTS `usuario_rol` (
  `id` int(11) NOT NULL,
  `ur_usuario_id` int(11) NOT NULL DEFAULT '0',
  `ur_rol_id` int(11) NOT NULL DEFAULT '0',
  `ur_fecha_in` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE IF NOT EXISTS `venta` (
  `ven_id` int(11) NOT NULL,
  `ven_numero_solicitud` int(11) NOT NULL DEFAULT '0',
  `ven_fecha` date DEFAULT NULL,
  `ven_vendedor` int(11) DEFAULT NULL,
  `ven_cliente` int(11) DEFAULT NULL,
  `ven_activo` tinyint(1) DEFAULT '1',
  `ven_tipo` enum('renta','canje','nueva') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_articulo`
--

CREATE TABLE IF NOT EXISTS `ventas_articulo` (
  `ver_id` int(11) NOT NULL,
  `ver_ven_id` int(11) NOT NULL,
  `ver_articulo_id` int(11) NOT NULL DEFAULT '0',
  `ver_rub_id` int(11) NOT NULL DEFAULT '0',
  `ver_edicion` int(11) NOT NULL DEFAULT '0',
  `ver_ingreso` decimal(8,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivo`
--
ALTER TABLE `archivo`
  ADD PRIMARY KEY (`arc_id`);

--
-- Indices de la tabla `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`ban_id`), ADD KEY `ban_nombre` (`ban_nombre`);

--
-- Indices de la tabla `cheque`
--
ALTER TABLE `cheque`
  ADD PRIMARY KEY (`cheque_id`), ADD KEY `cheque_numero` (`cheque_numero`), ADD KEY `cheque_banco_id` (`cheque_banco_id`), ADD KEY `cheque_estado` (`cheque_estado`), ADD KEY `cheque_destino` (`cheque_destino`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cli_id`);

--
-- Indices de la tabla `cliente_domicilio_comercial`
--
ALTER TABLE `cliente_domicilio_comercial`
  ADD PRIMARY KEY (`clc_id`), ADD KEY `clc_telefono` (`clc_telefono`), ADD KEY `clc_razon_social_comercial` (`clc_razon_social_comercial`);

--
-- Indices de la tabla `cliente_domicilio_legal`
--
ALTER TABLE `cliente_domicilio_legal`
  ADD PRIMARY KEY (`cll_id`), ADD KEY `cll_telefono` (`cll_telefono`);

--
-- Indices de la tabla `cobro`
--
ALTER TABLE `cobro`
  ADD PRIMARY KEY (`cobro_id`);

--
-- Indices de la tabla `cobro_detalle`
--
ALTER TABLE `cobro_detalle`
  ADD PRIMARY KEY (`cod_id`);

--
-- Indices de la tabla `cobro_factura`
--
ALTER TABLE `cobro_factura`
  ADD PRIMARY KEY (`cof_id`);

--
-- Indices de la tabla `condiva`
--
ALTER TABLE `condiva`
  ADD PRIMARY KEY (`condiva_id`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`cue_id`);

--
-- Indices de la tabla `cuentaempresa`
--
ALTER TABLE `cuentaempresa`
  ADD PRIMARY KEY (`cue_id`);

--
-- Indices de la tabla `decodificador`
--
ALTER TABLE `decodificador`
  ADD PRIMARY KEY (`dec_id`);

--
-- Indices de la tabla `decodificado_renglones`
--
ALTER TABLE `decodificado_renglones`
  ADD PRIMARY KEY (`dec_id`);

--
-- Indices de la tabla `documento_cliente`
--
ALTER TABLE `documento_cliente`
  ADD PRIMARY KEY (`doc_id`), ADD KEY `doc_numero` (`doc_numero`), ADD KEY `doc_fecha` (`doc_fecha`), ADD KEY `FK_documento_cliente_cliente` (`doc_cliente_id`);

--
-- Indices de la tabla `documento_percepciones`
--
ALTER TABLE `documento_percepciones`
  ADD PRIMARY KEY (`dpp_id`);

--
-- Indices de la tabla `documento_proveedor`
--
ALTER TABLE `documento_proveedor`
  ADD PRIMARY KEY (`dop_id`), ADD KEY `dop_numero` (`dop_numero`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`emp_id`), ADD UNIQUE KEY `emp_usuario` (`emp_usuario`);

--
-- Indices de la tabla `error`
--
ALTER TABLE `error`
  ADD PRIMARY KEY (`err_id`);

--
-- Indices de la tabla `estado_cheque`
--
ALTER TABLE `estado_cheque`
  ADD PRIMARY KEY (`estado_cheque_id`);

--
-- Indices de la tabla `estado_pago`
--
ALTER TABLE `estado_pago`
  ADD PRIMARY KEY (`id_estado_pago`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`fac_id`);

--
-- Indices de la tabla `facturas_pagas`
--
ALTER TABLE `facturas_pagas`
  ADD PRIMARY KEY (`facp_id`);

--
-- Indices de la tabla `facturas_rp_pagas`
--
ALTER TABLE `facturas_rp_pagas`
  ADD PRIMARY KEY (`facp_id`);

--
-- Indices de la tabla `factura_venta_articulo`
--
ALTER TABLE `factura_venta_articulo`
  ADD PRIMARY KEY (`fva_id`), ADD KEY `FK_factura_venta_articulo_ventas_articulo` (`fva_ver_id`), ADD KEY `FK_factura_venta_articulo_documento_cliente` (`fva_fac_id`);

--
-- Indices de la tabla `inscribite_categorias`
--
ALTER TABLE `inscribite_categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inscribite_eventos`
--
ALTER TABLE `inscribite_eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inscribite_inscripciones`
--
ALTER TABLE `inscribite_inscripciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inscribite_opciones`
--
ALTER TABLE `inscribite_opciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inscribite_usuarios`
--
ALTER TABLE `inscribite_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `liqudacion_cuentas`
--
ALTER TABLE `liqudacion_cuentas`
  ADD PRIMARY KEY (`lic_id`);

--
-- Indices de la tabla `liquidacion`
--
ALTER TABLE `liquidacion`
  ADD PRIMARY KEY (`liq_id`);

--
-- Indices de la tabla `liquidacion_cobros_detalles`
--
ALTER TABLE `liquidacion_cobros_detalles`
  ADD PRIMARY KEY (`lcd_id`);

--
-- Indices de la tabla `liquidacion_pagos_detalles`
--
ALTER TABLE `liquidacion_pagos_detalles`
  ADD PRIMARY KEY (`lpd_id`);

--
-- Indices de la tabla `localidades`
--
ALTER TABLE `localidades`
  ADD PRIMARY KEY (`id`), ADD KEY `id_provincia` (`id_provincia`);

--
-- Indices de la tabla `mediodecodificado`
--
ALTER TABLE `mediodecodificado`
  ADD PRIMARY KEY (`med_id`);

--
-- Indices de la tabla `mensualidades`
--
ALTER TABLE `mensualidades`
  ADD PRIMARY KEY (`men_id`);

--
-- Indices de la tabla `mensualidad_cuotas`
--
ALTER TABLE `mensualidad_cuotas`
  ADD PRIMARY KEY (`mec_id`);

--
-- Indices de la tabla `mensualidad_cuota_usuario`
--
ALTER TABLE `mensualidad_cuota_usuario`
  ADD PRIMARY KEY (`meu_id`);

--
-- Indices de la tabla `mensualidad_usuario`
--
ALTER TABLE `mensualidad_usuario`
  ADD PRIMARY KEY (`meu_id`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`pag_id`), ADD KEY `pago_proveedor_id` (`pag_emp_id`);

--
-- Indices de la tabla `pagos_renglones`
--
ALTER TABLE `pagos_renglones`
  ADD PRIMARY KEY (`par_id`);

--
-- Indices de la tabla `percepcion`
--
ALTER TABLE `percepcion`
  ADD PRIMARY KEY (`per_id`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`permiso_id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`persona_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`proveedor_id`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`rol_id`), ADD KEY `nombre` (`rol_nombre`);

--
-- Indices de la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD PRIMARY KEY (`rp_id`), ADD KEY `FK_rol_permiso_rol` (`rp_rol_id`), ADD KEY `FK_rol_permiso_permiso` (`rp_permiso_id`);

--
-- Indices de la tabla `solicitudtransferencia`
--
ALTER TABLE `solicitudtransferencia`
  ADD PRIMARY KEY (`sol_id`);

--
-- Indices de la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`tar_id`);

--
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`tic_id`);

--
-- Indices de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  ADD PRIMARY KEY (`tip_id`);

--
-- Indices de la tabla `tipo_cheque`
--
ALTER TABLE `tipo_cheque`
  ADD PRIMARY KEY (`tipo_cheque_id`);

--
-- Indices de la tabla `tipo_de_documento`
--
ALTER TABLE `tipo_de_documento`
  ADD PRIMARY KEY (`tipo_documento_id`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`tipo_pago_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`), ADD UNIQUE KEY `usuario` (`usuario_nombre`), ADD KEY `password` (`usuario_password`(255)), ADD KEY `FK_usuario_persona` (`usuario_persona_id`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`ven_id`), ADD KEY `ven_numero_solicitud` (`ven_numero_solicitud`), ADD KEY `FK_venta_cliente` (`ven_cliente`), ADD KEY `ven_fecha` (`ven_fecha`), ADD KEY `FK_venta_persona` (`ven_vendedor`), ADD KEY `ven_activo` (`ven_activo`);

--
-- Indices de la tabla `ventas_articulo`
--
ALTER TABLE `ventas_articulo`
  ADD PRIMARY KEY (`ver_id`), ADD KEY `ver_ven_id` (`ver_ven_id`), ADD KEY `ver_articulo_id` (`ver_articulo_id`), ADD KEY `FK_ventas_articulo_rubro` (`ver_rub_id`), ADD KEY `FK_ventas_articulo_edicion` (`ver_edicion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivo`
--
ALTER TABLE `archivo`
  MODIFY `arc_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `ban_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT de la tabla `cheque`
--
ALTER TABLE `cheque`
  MODIFY `cheque_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cli_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `cliente_domicilio_comercial`
--
ALTER TABLE `cliente_domicilio_comercial`
  MODIFY `clc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cliente_domicilio_legal`
--
ALTER TABLE `cliente_domicilio_legal`
  MODIFY `cll_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cobro`
--
ALTER TABLE `cobro`
  MODIFY `cobro_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `cobro_detalle`
--
ALTER TABLE `cobro_detalle`
  MODIFY `cod_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `cobro_factura`
--
ALTER TABLE `cobro_factura`
  MODIFY `cof_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `condiva`
--
ALTER TABLE `condiva`
  MODIFY `condiva_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `cue_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `cuentaempresa`
--
ALTER TABLE `cuentaempresa`
  MODIFY `cue_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `decodificador`
--
ALTER TABLE `decodificador`
  MODIFY `dec_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `decodificado_renglones`
--
ALTER TABLE `decodificado_renglones`
  MODIFY `dec_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT de la tabla `documento_cliente`
--
ALTER TABLE `documento_cliente`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `documento_percepciones`
--
ALTER TABLE `documento_percepciones`
  MODIFY `dpp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `documento_proveedor`
--
ALTER TABLE `documento_proveedor`
  MODIFY `dop_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `emp_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=121;
--
-- AUTO_INCREMENT de la tabla `error`
--
ALTER TABLE `error`
  MODIFY `err_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `estado_cheque`
--
ALTER TABLE `estado_cheque`
  MODIFY `estado_cheque_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `fac_id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5773;
--
-- AUTO_INCREMENT de la tabla `facturas_pagas`
--
ALTER TABLE `facturas_pagas`
  MODIFY `facp_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2043;
--
-- AUTO_INCREMENT de la tabla `facturas_rp_pagas`
--
ALTER TABLE `facturas_rp_pagas`
  MODIFY `facp_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2718;
--
-- AUTO_INCREMENT de la tabla `factura_venta_articulo`
--
ALTER TABLE `factura_venta_articulo`
  MODIFY `fva_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `inscribite_categorias`
--
ALTER TABLE `inscribite_categorias`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16178;
--
-- AUTO_INCREMENT de la tabla `inscribite_eventos`
--
ALTER TABLE `inscribite_eventos`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=695;
--
-- AUTO_INCREMENT de la tabla `inscribite_inscripciones`
--
ALTER TABLE `inscribite_inscripciones`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=114348;
--
-- AUTO_INCREMENT de la tabla `inscribite_opciones`
--
ALTER TABLE `inscribite_opciones`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1568;
--
-- AUTO_INCREMENT de la tabla `inscribite_usuarios`
--
ALTER TABLE `inscribite_usuarios`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=53199;
--
-- AUTO_INCREMENT de la tabla `liqudacion_cuentas`
--
ALTER TABLE `liqudacion_cuentas`
  MODIFY `lic_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `liquidacion`
--
ALTER TABLE `liquidacion`
  MODIFY `liq_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `liquidacion_cobros_detalles`
--
ALTER TABLE `liquidacion_cobros_detalles`
  MODIFY `lcd_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `liquidacion_pagos_detalles`
--
ALTER TABLE `liquidacion_pagos_detalles`
  MODIFY `lpd_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `localidades`
--
ALTER TABLE `localidades`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22709;
--
-- AUTO_INCREMENT de la tabla `mediodecodificado`
--
ALTER TABLE `mediodecodificado`
  MODIFY `med_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `mensualidades`
--
ALTER TABLE `mensualidades`
  MODIFY `men_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `mensualidad_cuotas`
--
ALTER TABLE `mensualidad_cuotas`
  MODIFY `mec_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT de la tabla `mensualidad_cuota_usuario`
--
ALTER TABLE `mensualidad_cuota_usuario`
  MODIFY `meu_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1382;
--
-- AUTO_INCREMENT de la tabla `mensualidad_usuario`
--
ALTER TABLE `mensualidad_usuario`
  MODIFY `meu_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=918;
--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `pag_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `pagos_renglones`
--
ALTER TABLE `pagos_renglones`
  MODIFY `par_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `percepcion`
--
ALTER TABLE `percepcion`
  MODIFY `per_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `permiso_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `persona_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  MODIFY `rp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `solicitudtransferencia`
--
ALTER TABLE `solicitudtransferencia`
  MODIFY `sol_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
  MODIFY `tar_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `tic_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  MODIFY `tip_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tipo_cheque`
--
ALTER TABLE `tipo_cheque`
  MODIFY `tipo_cheque_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tipo_de_documento`
--
ALTER TABLE `tipo_de_documento`
  MODIFY `tipo_documento_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `tipo_pago_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `ven_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ventas_articulo`
--
ALTER TABLE `ventas_articulo`
  MODIFY `ver_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
";

        $this->db->query($query);
    }

    public function down() {
        //$this->dbforge->drop_table('blog');
    }

}


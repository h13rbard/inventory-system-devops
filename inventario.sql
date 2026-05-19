-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 11, 2026 at 01:59 PM
-- Server version: 10.6.25-MariaDB-cll-lve-log
-- PHP Version: 8.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bashtico_pape`
--

-- --------------------------------------------------------

--
-- Table structure for table `almacenes`
--

CREATE TABLE `almacenes` (
  `id` int(11) NOT NULL,
  `clave` char(3) DEFAULT NULL,
  `nombre` varchar(25) DEFAULT NULL,
  `tipo` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `almacenes`
--

INSERT INTO `almacenes` (`id`, `clave`, `nombre`, `tipo`) VALUES
(1, '001', 'ALMACEN 1', 'FIJO'),
(2, 'C01', 'CLIENTES', 'PARTNER'),
(3, 'P01', 'PROVEEDORES', 'PARTNER'),
(4, 'V01', 'INV. INICIAL', 'VIRTUAL'),
(5, 'V02', 'DESECHO', 'VIRTUAL'),
(6, 'V03', 'CONVERSION', 'VIRTUAL'),
(7, 'V04', 'AJUSTES', 'VIRTUAL');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `clave` varchar(5) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `clave`, `nombre`, `direccion`, `telefono`, `correo`) VALUES
(1, '0', 'PUBLICO EN GENERAL', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cobranza`
--

CREATE TABLE `cobranza` (
  `id` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `no_referencia` varchar(6) DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `movimiento` char(1) DEFAULT NULL,
  `concepto` varchar(3) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `cliente` varchar(50) DEFAULT NULL,
  `saldo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cliente_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `folio` varchar(6) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `proveedor` varchar(50) DEFAULT NULL,
  `doc` varchar(3) DEFAULT NULL,
  `pago` char(3) NOT NULL DEFAULT 'CON',
  `proveedor_id` int(11) NOT NULL,
  `no_referencia` varchar(50) DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `fecha_confirmacion` date DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `compra`
--

INSERT INTO `compra` (`id`, `folio`, `total`, `estado`, `fecha`, `hora`, `proveedor`, `doc`, `pago`, `proveedor_id`, `no_referencia`, `fecha_compra`, `fecha_confirmacion`, `usuario_id`) VALUES
(1, 'C00001', 204.00, 'C', '2024-02-16', '23:56:40', 'SUPER', 'COM', 'CON', 1, '0110111', '2024-02-16', '2024-02-16', 4);

-- --------------------------------------------------------

--
-- Table structure for table `corte`
--

CREATE TABLE `corte` (
  `id` int(11) NOT NULL,
  `folio` varchar(6) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `corte`
--

INSERT INTO `corte` (`id`, `folio`, `fecha`) VALUES
(1, 'CC0001', '2024-02-16'),
(2, 'CC0002', '2025-05-08');

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `eslogan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`id`, `nombre`, `direccion`, `ciudad`, `correo`, `logo`, `eslogan`) VALUES
(1, 'PUNTO DE VENTA', 'AV. NACIONAL', 'TEHUACAN', 'ventas@gmail.com', 'images/logo.png', 'Sistema');

-- --------------------------------------------------------

--
-- Table structure for table `flujo`
--

CREATE TABLE `flujo` (
  `id` int(11) NOT NULL,
  `tipo` char(1) DEFAULT NULL,
  `concepto` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT 0,
  `corte_id` int(11) DEFAULT NULL,
  `proceso` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `flujo`
--

INSERT INTO `flujo` (`id`, `tipo`, `concepto`, `fecha`, `importe`, `borrado`, `corte_id`, `proceso`) VALUES
(1, 'I', 'VTA V00002', '2024-02-16', 38.00, 0, 1, 'VTA'),
(2, 'I', 'SALDO INICIAL', '2024-02-16', 38.00, 0, 2, 'INI'),
(3, 'I', 'SALDO INICIAL', '2025-05-08', 38.00, 0, NULL, 'INI');

-- --------------------------------------------------------

--
-- Table structure for table `folios`
--

CREATE TABLE `folios` (
  `id` int(11) NOT NULL,
  `serie` varchar(10) NOT NULL,
  `consecutivo` int(11) NOT NULL,
  `longitud` int(11) NOT NULL,
  `clave_proceso` varchar(3) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `tipo_id` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `folios`
--

INSERT INTO `folios` (`id`, `serie`, `consecutivo`, `longitud`, `clave_proceso`, `descripcion`, `tipo`, `tipo_id`, `activo`) VALUES
(1, 'C', 1, 5, 'CLI', 'CLIENTES', '', 0, 1),
(2, 'P', 2, 5, 'PRO', 'PROVEEDORES', '', 0, 1),
(3, 'V', 4, 6, 'VTA', 'VENTA', '', 0, 1),
(4, 'D', 40, 6, 'DEV', 'DEVOLUCION', '', 0, 1),
(5, 'E', 1, 6, 'DES', 'DESECHO', '', 0, 1),
(6, 'CC', 3, 6, 'CCJ', 'CORTE DE CAJA', '', 0, 1),
(7, 'C', 2, 6, 'COM', 'COMPRAS', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'gerente', 'Gerente'),
(4, 'cajero', 'Cajero');

-- --------------------------------------------------------

--
-- Table structure for table `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historial_productos`
--

CREATE TABLE `historial_productos` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `campo` varchar(25) DEFAULT NULL,
  `valor_original` varchar(25) DEFAULT NULL,
  `valor_nuevo` varchar(25) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `historial_productos`
--

INSERT INTO `historial_productos` (`id`, `producto_id`, `campo`, `valor_original`, `valor_nuevo`, `fecha`, `hora`, `user_id`) VALUES
(1, 1, 'precio_venta', '0.00', '19.00', '2024-02-16', '23:57:39', 4);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movsinv`
--

CREATE TABLE `movsinv` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` decimal(8,2) DEFAULT NULL,
  `proceso` char(3) DEFAULT NULL,
  `num_referencia` varchar(6) DEFAULT NULL,
  `origen_id` int(11) DEFAULT NULL,
  `destino_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `movsinv`
--

INSERT INTO `movsinv` (`id`, `fecha`, `hora`, `producto_id`, `cantidad`, `proceso`, `num_referencia`, `origen_id`, `destino_id`, `usuario_id`) VALUES
(1, '2024-02-16', '23:56:40', 1, 12.00, 'COM', 'C00001', 3, 1, 4),
(2, '2024-02-16', '23:58:35', 1, 2.00, 'VTA', 'V00002', 1, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `partcompra`
--

CREATE TABLE `partcompra` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `precio` decimal(10,4) NOT NULL,
  `cantidad` decimal(10,4) NOT NULL,
  `compra_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `partcompra`
--

INSERT INTO `partcompra` (`id`, `producto_id`, `precio`, `cantidad`, `compra_id`) VALUES
(1, 1, 17.0000, 12.0000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `partventa`
--

CREATE TABLE `partventa` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `precio` decimal(10,4) NOT NULL,
  `cantidad` decimal(10,4) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `costo` decimal(10,4) DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `partventa`
--

INSERT INTO `partventa` (`id`, `producto_id`, `precio`, `cantidad`, `venta_id`, `costo`) VALUES
(1, 1, 19.0000, 2.0000, 3, 17.0000);

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `clave_art` varchar(50) NOT NULL,
  `clave_prov` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_uni` decimal(10,6) NOT NULL,
  `no_impues1` int(11) NOT NULL,
  `unidad` varchar(25) NOT NULL,
  `marca` varchar(25) NOT NULL,
  `iva_uni` decimal(10,6) NOT NULL,
  `codigo_b` varchar(50) NOT NULL,
  `linea` varchar(50) NOT NULL,
  `descrip` varchar(255) NOT NULL,
  `precio_compra` decimal(10,6) DEFAULT NULL,
  `precio_venta_aux` decimal(10,6) DEFAULT NULL,
  `precio_venta` decimal(10,6) DEFAULT NULL,
  `localizacion` varchar(25) DEFAULT NULL,
  `existencias` decimal(10,2) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `minimo` int(11) NOT NULL DEFAULT 0,
  `proveedor_id` int(11) DEFAULT 1,
  `actualiza` tinyint(4) DEFAULT 1,
  `act_pre` date DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `clasif` varchar(2) DEFAULT NULL,
  `grupo_id` int(11) DEFAULT NULL,
  `baja` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_alta` date DEFAULT NULL,
  `ult_vta` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `clave_art`, `clave_prov`, `cantidad`, `precio_uni`, `no_impues1`, `unidad`, `marca`, `iva_uni`, `codigo_b`, `linea`, `descrip`, `precio_compra`, `precio_venta_aux`, `precio_venta`, `localizacion`, `existencias`, `imagen`, `minimo`, `proveedor_id`, `actualiza`, `act_pre`, `url`, `clasif`, `grupo_id`, `baja`, `fecha_alta`, `ult_vta`) VALUES
(1, 'COCA600', 'COCA600', 0, 17.000000, 0, 'PZA', 'COCA-COLA', 0.000000, 'COCA600', '', 'REFRESCO COCA COLA SABOR ORIGINAL 600 ML', 17.000000, 0.000000, 19.000000, 'REFRI', 10.00, NULL, 0, 1, 1, '2024-02-16', '', NULL, NULL, 0, '2024-02-16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `clave` varchar(5) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `proveedores`
--

INSERT INTO `proveedores` (`id`, `clave`, `nombre`) VALUES
(1, 'P0001', 'SUPER');

-- --------------------------------------------------------

--
-- Table structure for table `relacionados`
--

CREATE TABLE `relacionados` (
  `id` int(11) NOT NULL,
  `producto1_id` int(11) NOT NULL,
  `producto2_id` int(11) NOT NULL,
  `comentario` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resultados_semanales`
--

CREATE TABLE `resultados_semanales` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `semana` varchar(50) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `venta_con` decimal(10,2) NOT NULL,
  `venta_cre` decimal(10,2) NOT NULL,
  `venta_total` decimal(10,2) NOT NULL,
  `sueldo` decimal(10,2) NOT NULL,
  `compras` decimal(10,2) NOT NULL,
  `gastos` decimal(10,2) NOT NULL,
  `desecho` decimal(10,2) NOT NULL,
  `cobranza` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_tickets`
--

CREATE TABLE `template_tickets` (
  `id` int(11) NOT NULL,
  `clave` varchar(5) DEFAULT NULL,
  `formato` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `template_tickets`
--

INSERT INTO `template_tickets` (`id`, `clave`, `formato`) VALUES
(1, 'VTA', '<html>\r\n<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<style>\r\nbody {\r\n	margin: 0px; padding: 0;\r\n	padding-bottom: 0px;\r\n	font-size: 11px;\r\n	\r\n}\r\nbody, td, th {\r\n	font-family: Tahoma;\r\n	font-size:12px;\r\n\r\n}\r\n/*------------- Divisiones---------------- */\r\n.zona_total{\r\nwidth:400px;\r\nfloat:left;\r\nmargin-left:50px;\r\n}\r\n.zona_impresion{\r\nwidth: 260px;\r\npadding:0px 0px 0px 0px;\r\nfloat:left;\r\nmargin-left:00px;\r\n/*border-style: solid;\r\nborder:1px solid  #999;\r\nbox-shadow: 0 1px 4px rgba(0, 0, 0, 0.4); \r\n*/\r\n}\r\n</style>\r\n</head>\r\n<body onload=\"window.print();\">\r\n<br>\r\n<div class=\"zona_impresion\">\r\n<!-- codigo imprimir -->\r\n<br>\r\n<table border=\"0\" align=\"center\" style=\"table-layout: fixed; width: 260px;\">\r\n	<tr>\r\n		<td align=\"center\" style=\"width: 30%\">\r\n			<img src=\"{logo}\" alt=\" srcset=\" width=\"50\"><br>\r\n		</td>\r\n		<td align=\"center\" style=\"width: 70%; font-size: 120%\">\r\n		<!-- Mostramos los datos de la empresa en el documento HTML -->\r\n		{nombre}<br>\r\n		{eslogan}<br>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td  align=\"center\" colspan=\"2\">\r\n		{direccion}<br>\r\n		{ciudad}<br>\r\n		{correo}\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td align=\"left\" colspan=\"2\" style=\"padding-top: 10px;\">\r\n		CLIENTE: {cliente}<br>\r\n		{folio}<br>\r\n		{tipo_venta}\r\n		</td>\r\n	</tr>\r\n</table>\r\n<!-- Mostramos los detalles de la venta en el documento HTML -->\r\n<table align=\"center\" style=\"table-layout: fixed; width: 250px;\">\r\n	<tr>\r\n		<td style=\"width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\">CANT.</td>\r\n		<td style=\"width: 150px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\" align=\"center\">DESCRIPCIÓN</td>\r\n		<td style=\"width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\" align=\"right\">IMPORTE</td>\r\n	</tr>\r\n\r\n	{partidas}\r\n	<tr>\r\n		<td align=\"left\" valign=\"top\" style=\"padding-top: 5px;\">{clave_art}</td>\r\n		<td align=\"center\" colspan=\"2\" style=\"padding-top: 5px;\">{descrip}</td>\r\n	</tr>\r\n	<tr>\r\n		<td align=\"right\" style=\"padding-top: 5px;\">{cantidad}</td>\r\n		<td align=\"left\" style=\"padding-top: 5px;\">X {precio}</td>\r\n		<td align=\"right\" style=\"padding-top: 5px;\">{importe}</td>\r\n	</tr>\r\n	{/partidas}\r\n\r\n	<tr>\r\n		<td colspan=\"3\" style=\"border-top: 1px solid black;\">&nbsp;</td>\r\n	</tr>\r\n	<!-- Mostramos los totales de la venta en el documento HTML -->\r\n	<tr>\r\n	<td colspan=\"3\" align=\"center\" style=\"font-size: 100%;\">TOTAL: $ {total}</td>\r\n	</tr>\r\n	<tr>\r\n		<td colspan=\"3\">&nbsp;</td>\r\n	</tr>\r\n	<tr>\r\n		<td colspan=\"3\" align=\"center\">\r\n		{fecha_hora}<br>\r\n		¡Gracias por su compra!</td>\r\n	</tr>\r\n</table>\r\n</div>\r\n</body>\r\n</html>'),
(2, 'DEV', '<html>\r\n<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<style>\r\nbody {\r\n	margin: 0px; padding: 0;\r\n	padding-bottom: 0px;\r\n	font-size: 11px;\r\n	\r\n}\r\nbody, td, th {\r\n	font-family: Tahoma;\r\n	font-size:12px;\r\n\r\n}\r\n/*------------- Divisiones---------------- */\r\n.zona_total{\r\nwidth:400px;\r\nfloat:left;\r\nmargin-left:50px;\r\n}\r\n.zona_impresion{\r\nwidth: 260px;\r\npadding:0px 0px 0px 0px;\r\nfloat:left;\r\nmargin-left:00px;\r\n/*border-style: solid;\r\nborder:1px solid  #999;\r\nbox-shadow: 0 1px 4px rgba(0, 0, 0, 0.4); \r\n*/\r\n}\r\n</style>\r\n</head>\r\n<body onload=\"window.print();\">\r\n<br>\r\n<div class=\"zona_impresion\">\r\n<!-- codigo imprimir -->\r\n<br>\r\n<table border=\"0\" align=\"center\" style=\"table-layout: fixed; width: 260px;\">\r\n	<tr>\r\n		<td align=\"center\" style=\"width: 30%\">\r\n			<img src=\"{logo}\" alt=\" srcset=\" width=\"50\"><br>\r\n		</td>\r\n		<td align=\"center\" style=\"width: 70%; font-size: 120%\">\r\n		<!-- Mostramos los datos de la empresa en el documento HTML -->\r\n		{nombre}<br>\r\n		{eslogan}<br>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td  align=\"center\" colspan=\"2\">\r\n		{direccion}<br>\r\n		{ciudad}<br>\r\n		{correo}\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td align=\"left\" colspan=\"2\" style=\"padding-top: 10px;\">\r\n		CLIENTE: {cliente}<br>\r\n		{folio}\r\n		</td>\r\n	</tr>\r\n</table>\r\n<!-- Mostramos los detalles de la venta en el documento HTML -->\r\n<table align=\"center\" style=\"table-layout: fixed; width: 250px;\">\r\n	<tr>\r\n		<td style=\"width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\">CANT.</td>\r\n		<td style=\"width: 150px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\" align=\"center\">DESCRIPCIÓN</td>\r\n		<td style=\"width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\" align=\"right\">IMPORTE</td>\r\n	</tr>\r\n\r\n	{partidas}\r\n	<tr>\r\n		<td align=\"left\" valign=\"top\" style=\"padding-top: 5px;\">{clave_art}</td>\r\n		<td align=\"center\" colspan=\"2\" style=\"padding-top: 5px;\">{descrip}</td>\r\n	</tr>\r\n	<tr>\r\n		<td align=\"right\" style=\"padding-top: 5px;\">{cantidad}</td>\r\n		<td align=\"left\" style=\"padding-top: 5px;\">X {precio}</td>\r\n		<td align=\"right\" style=\"padding-top: 5px;\">{importe}</td>\r\n	</tr>\r\n	{/partidas}\r\n\r\n	<tr>\r\n		<td colspan=\"3\" style=\"border-top: 1px solid black;\">&nbsp;</td>\r\n	</tr>\r\n	<!-- Mostramos los totales de la venta en el documento HTML -->\r\n	<tr>\r\n	<td colspan=\"3\" align=\"center\" style=\"font-size: 100%;\">TOTAL: $ {total}</td>\r\n	</tr>\r\n	<tr>\r\n		<td colspan=\"3\">&nbsp;</td>\r\n	</tr>\r\n	<tr>\r\n		<td colspan=\"3\" align=\"center\">\r\n		{fecha_hora}<br>\r\n		DEVOLUCION</td>\r\n	</tr>\r\n</table>\r\n</div>\r\n</body>\r\n</html>'),
(3, 'DES', '<html>\r\n<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<style>\r\nbody {\r\n	margin: 0px; padding: 0;\r\n	padding-bottom: 0px;\r\n	font-size: 11px;\r\n	\r\n}\r\nbody, td, th {\r\n	font-family: Tahoma;\r\n	font-size:12px;\r\n\r\n}\r\n/*------------- Divisiones---------------- */\r\n.zona_total{\r\nwidth:400px;\r\nfloat:left;\r\nmargin-left:50px;\r\n}\r\n.zona_impresion{\r\nwidth: 260px;\r\npadding:0px 0px 0px 0px;\r\nfloat:left;\r\nmargin-left:00px;\r\n/*border-style: solid;\r\nborder:1px solid  #999;\r\nbox-shadow: 0 1px 4px rgba(0, 0, 0, 0.4); \r\n*/\r\n}\r\n</style>\r\n</head>\r\n<body onload=\"window.print();\">\r\n<br>\r\n<div class=\"zona_impresion\">\r\n<!-- codigo imprimir -->\r\n<br>\r\n<table border=\"0\" align=\"center\" style=\"table-layout: fixed; width: 260px;\">\r\n	<tr>\r\n		<td align=\"center\" style=\"width: 30%\">\r\n			<img src=\"{logo}\" alt=\" srcset=\" width=\"50\"><br>\r\n		</td>\r\n		<td align=\"center\" style=\"width: 70%; font-size: 120%\">\r\n		<!-- Mostramos los datos de la empresa en el documento HTML -->\r\n		{nombre}<br>\r\n		{eslogan}<br>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td  align=\"center\" colspan=\"2\">\r\n		{direccion}<br>\r\n		{ciudad}<br>\r\n		{correo}\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td align=\"left\" colspan=\"2\" style=\"padding-top: 10px;\">\r\n		CLIENTE: {cliente}<br>\r\n		{folio}\r\n		</td>\r\n	</tr>\r\n</table>\r\n<!-- Mostramos los detalles de la venta en el documento HTML -->\r\n<table align=\"center\" style=\"table-layout: fixed; width: 250px;\">\r\n	<tr>\r\n		<td style=\"width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\">CANT.</td>\r\n		<td style=\"width: 150px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\" align=\"center\">DESCRIPCIÓN</td>\r\n		<td style=\"width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\" align=\"right\">IMPORTE</td>\r\n	</tr>\r\n\r\n	{partidas}\r\n	<tr>\r\n		<td align=\"left\" valign=\"top\" style=\"padding-top: 5px;\">{clave_art}</td>\r\n		<td align=\"center\" colspan=\"2\" style=\"padding-top: 5px;\">{descrip}</td>\r\n	</tr>\r\n	<tr>\r\n		<td align=\"right\" style=\"padding-top: 5px;\">{cantidad}</td>\r\n		<td align=\"left\" style=\"padding-top: 5px;\">X {precio}</td>\r\n		<td align=\"right\" style=\"padding-top: 5px;\">{importe}</td>\r\n	</tr>\r\n	{/partidas}\r\n\r\n	<tr>\r\n		<td colspan=\"3\" style=\"border-top: 1px solid black;\">&nbsp;</td>\r\n	</tr>\r\n	<!-- Mostramos los totales de la venta en el documento HTML -->\r\n	<tr>\r\n	<td colspan=\"3\" align=\"center\" style=\"font-size: 100%;\">TOTAL: $ {total}</td>\r\n	</tr>\r\n	<tr>\r\n		<td colspan=\"3\">&nbsp;</td>\r\n	</tr>\r\n	<tr>\r\n		<td colspan=\"3\" align=\"center\">\r\n		{fecha_hora}<br>\r\n		DESECHO</td>\r\n	</tr>\r\n</table>\r\n</div>\r\n</body>\r\n</html>'),
(4, 'COB', '<html>\r\n<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<style>\r\nbody {\r\n	margin: 0px; padding: 0;\r\n	padding-bottom: 0px;\r\n	font-size: 11px;\r\n	\r\n}\r\nbody, td, th {\r\n	font-family: Tahoma;\r\n	font-size:12px;\r\n\r\n}\r\n\r\n/*------------- Divisiones---------------- */\r\n.zona_total{\r\nwidth:400px;\r\nfloat:left;\r\nmargin-left:50px;\r\n\r\n\r\n\r\n}\r\n.zona_impresion{\r\n\r\nwidth: 260px;\r\npadding:0px 0px 0px 0px;\r\n\r\nfloat:left;\r\nmargin-left:00px;\r\n/*border-style: solid;\r\nborder:1px solid  #999;\r\nbox-shadow: 0 1px 4px rgba(0, 0, 0, 0.4); \r\n*/\r\n}\r\n</style>\r\n</head>\r\n<!-- <body onload=\"window.print();\"> -->\r\n<body>\r\n<br>\r\n<div class=\"zona_impresion\">\r\n<!-- codigo imprimir -->\r\n<br>\r\n<table border=\"0\" align=\"center\" style=\"table-layout: fixed; width: 260px;\">\r\n	<tr>\r\n		<td align=\"center\" style=\"width: 30%\">\r\n			<img src=\"{logo}\" alt=\" srcset=\" width=\"50\"><br>\r\n		</td>\r\n		<td align=\"center\" style=\"width: 70%; font-size: 120%\">\r\n		<!-- Mostramos los datos de la empresa en el documento HTML -->\r\n		{nombre}<br>\r\n		{eslogan}<br>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td  align=\"center\" colspan=\"2\">\r\n		{direccion}<br>\r\n		{ciudad}<br>\r\n		{correo}\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td align=\"left\" colspan=\"2\" style=\"padding-top: 10px;\">\r\n		CLIENTE: {cliente}<br>\r\n		{folio}<br>\r\n		</td>\r\n	</tr>\r\n</table>\r\n\r\n<!-- <br> -->\r\n<!-- Mostramos los detalles de la venta en el documento HTML -->\r\n<table align=\"center\" style=\"table-layout: fixed; width: 250px;\">\r\n    <tr>\r\n        <td style=\"width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\">FECHA</td>\r\n        <td style=\"width: 150px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\" align=\"center\">DESCRIPCIÓN</td>\r\n        <td style=\"width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\" align=\"right\">IMPORTE</td>\r\n    </tr>\r\n    {partidas}\r\n    <tr>\r\n        <td align=\"left\" valign=\"top\" style=\"padding-top: 5px;\">{movimiento} {fecha}</td>\r\n        <td align=\"center\" style=\"padding-top: 5px;\">{cliente}</td>\r\n		<td align=\"right\" style=\"padding-top: 5px;\">{importe}</td>\r\n    </tr>\r\n    {/partidas}\r\n    <tr>\r\n      <td colspan=\"3\" style=\"border-top: 1px solid black;\"></td>\r\n    </tr>\r\n    <tr>\r\n	<td></td>\r\n	<td align=\"center\">CARGOS</td>\r\n	<td align=\"right\" style=\"padding-top: 5px;\">{total_cargo}</td>\r\n	</tr>\r\n	<tr>\r\n	<td></td>\r\n	<td align=\"center\">ABONOS</td>\r\n	<td align=\"right\" style=\"padding-top: 5px;\">{total_abono}</td>\r\n	</tr>\r\n	<tr>\r\n      <td colspan=\"3\" style=\"border-top: 1px solid black;\">&nbsp;</td>\r\n    </tr>\r\n    <!-- Mostramos los totales de la venta en el documento HTML -->\r\n    <tr>\r\n    <td colspan=\"3\" align=\"center\" style=\"font-size: 100%;\">SALDO: $ {saldo}</td>\r\n    </tr>\r\n    <tr>\r\n      <td colspan=\"3\">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n      <td colspan=\"3\" align=\"center\">\r\n      {fecha_hora}<br>\r\n      ¡Gracias por su compra!</td>\r\n    </tr>\r\n</table>\r\n\r\n</div>\r\n\r\n\r\n</body>\r\n</html>'),
(5, 'EDOCT', '<html>\r\n<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<style>\r\nbody {\r\n	margin: 0px; padding: 0;\r\n	padding-bottom: 0px;\r\n	font-size: 11px;\r\n	\r\n}\r\nbody, td, th {\r\n	font-family: Tahoma;\r\n	font-size:12px;\r\n\r\n}\r\n\r\n/*------------- Divisiones---------------- */\r\n.zona_total{\r\nwidth:400px;\r\nfloat:left;\r\nmargin-left:50px;\r\n\r\n\r\n\r\n}\r\n.zona_impresion{\r\n\r\nwidth: 260px;\r\npadding:0px 0px 0px 0px;\r\n\r\nfloat:left;\r\nmargin-left:00px;\r\n/*border-style: solid;\r\nborder:1px solid  #999;\r\nbox-shadow: 0 1px 4px rgba(0, 0, 0, 0.4); \r\n*/\r\n}\r\n</style>\r\n</head>\r\n<!-- <body onload=\"window.print();\"> -->\r\n<body>\r\n<br>\r\n<div class=\"zona_impresion\">\r\n<!-- codigo imprimir -->\r\n<br>\r\n<table border=\"0\" align=\"center\" style=\"table-layout: fixed; width: 260px;\">\r\n	<tr>\r\n		<td align=\"center\" style=\"width: 30%\">\r\n			<img src=\"{logo}\" alt=\" srcset=\" width=\"50\"><br>\r\n		</td>\r\n		<td align=\"center\" style=\"width: 70%; font-size: 120%\">\r\n		<!-- Mostramos los datos de la empresa en el documento HTML -->\r\n		{nombre}<br>\r\n		{eslogan}<br>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td  align=\"center\" colspan=\"2\">\r\n		{direccion}<br>\r\n		{ciudad}<br>\r\n		{correo}\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td align=\"left\" colspan=\"2\" style=\"padding-top: 10px;\">\r\n		ESTADO DE CUENTA<br><br>\r\n		CLIENTE: {cliente}<br><br>\r\n        </td>\r\n	</tr>\r\n</table>\r\n\r\n<!-- <br> -->\r\n<!-- Mostramos los detalles de la venta en el documento HTML -->\r\n<table align=\"center\" style=\"table-layout: fixed; width: 250px;\">\r\n	<tr>\r\n        <td style=\"width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\">FECHA</td>\r\n        <td style=\"width: 150px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\" align=\"center\">CONCEPTO</td>\r\n        <td style=\"width: 50px; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 5px; padding-bottom: 5px;\" align=\"right\">IMPORTE</td>\r\n    </tr>\r\n    {partidas}\r\n    <tr>\r\n		<td align=\"left\" valign=\"top\" style=\"padding-top: 5px;\">{fecha}</td>\r\n        <td align=\"center\" style=\"padding-top: 5px;\">{concepto}</td>\r\n		<td align=\"right\" style=\"padding-top: 5px;\">{importe}</td>\r\n    </tr>\r\n    {/partidas}\r\n    <tr>\r\n      <td colspan=\"3\" style=\"border-top: 1px solid black;\"></td>\r\n    </tr>\r\n	<tr>\r\n	<td></td>\r\n	<td align=\"center\">TOTAL</td>\r\n	<td align=\"right\" style=\"padding-top: 5px;\"></td>\r\n	</tr>\r\n    <tr>\r\n	<td></td>\r\n	<td align=\"center\">CARGOS</td>\r\n	<td align=\"right\" style=\"padding-top: 5px;\">{total_cargo}</td>\r\n	</tr>\r\n	<tr>\r\n	<td></td>\r\n	<td align=\"center\">ABONOS</td>\r\n	<td align=\"right\" style=\"padding-top: 5px;\">{total_abono}</td>\r\n	</tr>\r\n	<tr>\r\n      <td colspan=\"3\" style=\"border-top: 1px solid black;\">&nbsp;</td>\r\n    </tr>\r\n    <!-- Mostramos los totales de la venta en el documento HTML -->\r\n    <tr>\r\n    <td colspan=\"3\" align=\"center\" style=\"font-size: 100%;\">RESTA: $ {saldo}</td>\r\n    </tr>\r\n    <tr>\r\n      <td colspan=\"3\">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n      <td colspan=\"3\" align=\"center\">\r\n      {fecha_hora}<br>\r\n    </tr>\r\n</table>\r\n\r\n</div>\r\n\r\n</body>\r\n</html>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `group_id` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `group_id`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$12$G9r9LFL4myY6gDo7rjPAUOrrPhxqoCAATgroATTFX.wasUUupT.L.', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1760111751, 1, 'Admin', 'istrator', 'ADMIN', '0', 1),
(2, '187.235.38.230', 'gerente@alternativa.com', '$2y$12$fatM9LCXXZXD7LOteNMpmOSM4Ym4prexF2P2P7/HGjXPjBqKMqafC', 'gerente@alternativa.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1597988572, 1639922972, 1, 'gerente', '-', '-', '-', 1),
(3, '187.235.38.230', 'cajero@alternativa.com', '$2y$10$3ZFEJVJF4YX/Pe7lz0WHYOKNimD/GOLge3QX76hXpt9l7tYfhsVf.', 'cajero@alternativa.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1597988625, 1599003552, 1, 'cajero', '01', '-', '-', 4),
(4, '189.183.25.126', 'prueba@sistema.com', '$2y$10$IRIYZz/5svekvpT016DsF.wdMJzYPsIiztbW1jrqkOceQPDF2oNi2', 'prueba@sistema.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1708146992, 1746724187, 1, 'Donato', 'Hilario', '-', '-', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(10, 1, 1),
(8, 2, 1),
(6, 3, 4),
(12, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

CREATE TABLE `venta` (
  `id` int(11) NOT NULL,
  `folio` varchar(6) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `cliente` varchar(50) DEFAULT NULL,
  `doc` varchar(3) DEFAULT NULL,
  `pago` char(3) NOT NULL DEFAULT 'CON',
  `cliente_id` int(11) NOT NULL DEFAULT 1,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `venta`
--

INSERT INTO `venta` (`id`, `folio`, `total`, `estado`, `fecha`, `hora`, `cliente`, `doc`, `pago`, `cliente_id`, `usuario_id`) VALUES
(1, 'D00039', 0.00, 'P', '2023-03-14', '22:29:49', 'DEV ', 'DEV', 'CON', 1, 1),
(2, 'V00001', 0.00, 'P', '2023-03-14', '22:48:16', 'PUBLICO EN GENERAL', 'VTA', 'CON', 1, 1),
(3, 'V00002', 38.00, 'C', '2024-02-16', '23:58:35', 'PUBLICO EN GENERAL', 'VTA', 'CON', 1, 4),
(4, 'V00003', 0.00, 'P', '2024-02-19', '00:03:37', 'PUBLICO EN GENERAL', 'VTA', 'CON', 1, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `almacenes`
--
ALTER TABLE `almacenes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cobranza`
--
ALTER TABLE `cobranza`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `corte`
--
ALTER TABLE `corte`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flujo`
--
ALTER TABLE `flujo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folios`
--
ALTER TABLE `folios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `historial_productos`
--
ALTER TABLE `historial_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movsinv`
--
ALTER TABLE `movsinv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partcompra`
--
ALTER TABLE `partcompra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partventa`
--
ALTER TABLE `partventa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relacionados`
--
ALTER TABLE `relacionados`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resultados_semanales`
--
ALTER TABLE `resultados_semanales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_tickets`
--
ALTER TABLE `template_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `almacenes`
--
ALTER TABLE `almacenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cobranza`
--
ALTER TABLE `cobranza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `corte`
--
ALTER TABLE `corte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `flujo`
--
ALTER TABLE `flujo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `folios`
--
ALTER TABLE `folios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historial_productos`
--
ALTER TABLE `historial_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `movsinv`
--
ALTER TABLE `movsinv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `partcompra`
--
ALTER TABLE `partcompra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `partventa`
--
ALTER TABLE `partventa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `relacionados`
--
ALTER TABLE `relacionados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resultados_semanales`
--
ALTER TABLE `resultados_semanales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_tickets`
--
ALTER TABLE `template_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

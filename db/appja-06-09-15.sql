-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-09-2015 a las 19:27:03
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `appja`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wsp_opciones`
--

CREATE TABLE IF NOT EXISTS `wsp_opciones` (
  `opcion_id` bigint(20) unsigned NOT NULL,
  `opcion_nombre` varchar(64) NOT NULL DEFAULT '',
  `opcion_valor` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wsp_paginas`
--

CREATE TABLE IF NOT EXISTS `wsp_paginas` (
  `ID` bigint(20) unsigned NOT NULL,
  `pagina_nombre` varchar(200) NOT NULL DEFAULT '',
  `pagina_tipo` varchar(20) NOT NULL DEFAULT 'pagina',
  `pagina_autor` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pagina_fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pagina_fecha_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pagina_contenido` longtext NOT NULL,
  `pagina_titulo` text NOT NULL,
  `pagina_leermas` text NOT NULL,
  `pagina_estado` varchar(20) NOT NULL DEFAULT 'publicado',
  `comentario_estado` varchar(20) NOT NULL DEFAULT 'abierto',
  `ping_status` varchar(20) NOT NULL DEFAULT 'abierto',
  `pagina_password` varchar(20) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `pagina_modificado` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pagina_modificado_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pagina_content_filtered` longtext NOT NULL,
  `pagina_padre` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_orden` int(11) NOT NULL DEFAULT '0',
  `pagina_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comentario_count` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wsp_usuarios`
--

CREATE TABLE IF NOT EXISTS `wsp_usuarios` (
  `uid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `wsp_usuarios`
--

INSERT INTO `wsp_usuarios` (`uid`, `name`, `email`, `phone`, `password`, `address`, `city`, `created`) VALUES
(169, 'Swadesh Behera', 'swadesh@gmail.com', '1234567890', '$2a$10$251b3c3d020155f7553c1ugKfEH04BD6nbCbo78AIDVOqS3GVYQ46', '4092 Furth Circle', 'Singapore', '2014-08-31 14:21:20'),
(170, 'Ipsita Sahoo', 'ipsita@gmail.com', '1111111111', '$2a$10$d84ffcf46967db4e1718buENHT7GVpcC7FfbSqCLUJDkKPg4RcgV2', '2, rue du Commerce', 'NYC', '2014-08-31 14:30:58'),
(171, 'Trisha Tamanna Priyadarsini', 'trisha@gmail.com', '2222222222', '$2a$10$c9b32f5baa3315554bffcuWfjiXNhO1Rn4hVxMXyJHJaesNHL9U/O', 'C/ Moralzarzal, 86', 'Burlingame', '2014-08-31 14:32:03'),
(172, 'Sai Rimsha', 'rimsha@gmail.com', '3333333333', '$2a$10$477f7567571278c17ebdees5xCunwKISQaG8zkKhvfE5dYem5sTey', '897 Long Airport Avenue', 'Madrid', '2014-08-31 16:34:21'),
(173, 'Satwik Mohanty', 'satwik@gmail.com', '4444444444', '$2a$10$2b957be577db7727fed13O2QmHMd9LoEUjioYe.zkXP5lqBumI6Dy', 'Lyonerstr. 34', 'San Francisco\n', '2014-08-31 16:36:02'),
(174, 'Tapaswini Sahoo', 'linky@gmail.com', '5555555555', '$2a$10$b2f3694f56fdb5b5c9ebeulMJTSx2Iv6ayQR0GUAcDsn0Jdn4c1we', 'ul. Filtrowa 68', 'Warszawa', '2014-08-31 16:44:54'),
(175, 'Manas Ranjan Subudhi', 'manas@gmail.com', '6666666666', '$2a$10$03ab40438bbddb67d4f13Odrzs6Rwr92xKEYDbOO7IXO8YvBaOmlq', '5677 Strong St.', 'Stavern\n', '2014-08-31 16:45:08'),
(178, 'AngularCode Administrator', 'admin@angularcode.com', '0000000000', '$2a$10$72442f3d7ad44bcf1432cuAAZAURj9dtXhEMBQXMn9C8SpnZjmK1S', 'C/1052, Bangalore', '', '2014-08-31 17:00:26'),
(187, 'alex sosa', 'correo@correo.com', '698344738', '$2a$10$487e47243f513225d8fc4uO5Ep4064.pnxzZcXPineMzKSj6qWlG2', 'Calle del Gobernador 16, 2 C', '', '2015-02-26 19:51:42'),
(188, 'alex sosa', 'admin@correo.com', '000000000', 'admin', 'direccion', '', '2015-02-27 16:38:57'),
(189, 'alejandro sosa', 'correo@correo.com', '000000000', '$2a$10$487e47243f513225d8fc4uO5Ep4064.pnxzZcXPineMzKSj6qWlG2', '', '', '2015-03-01 13:32:04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `wsp_opciones`
--
ALTER TABLE `wsp_opciones`
  ADD PRIMARY KEY (`opcion_id`),
  ADD UNIQUE KEY `option_name` (`opcion_nombre`);

--
-- Indices de la tabla `wsp_paginas`
--
ALTER TABLE `wsp_paginas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `pagina_nombre` (`pagina_nombre`),
  ADD KEY `tipo_estado_fecha` (`pagina_tipo`,`pagina_estado`,`pagina_fecha`,`ID`),
  ADD KEY `pagina_padre` (`pagina_padre`),
  ADD KEY `pagina_autor` (`pagina_autor`);

--
-- Indices de la tabla `wsp_usuarios`
--
ALTER TABLE `wsp_usuarios`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `wsp_opciones`
--
ALTER TABLE `wsp_opciones`
  MODIFY `opcion_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `wsp_paginas`
--
ALTER TABLE `wsp_paginas`
  MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `wsp_usuarios`
--
ALTER TABLE `wsp_usuarios`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=190;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

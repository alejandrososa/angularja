-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2015 a las 14:37:25
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `appja`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getMenuJerarquia`(IN categoria int(4))
BEGIN

	IF categoria IS NOT NULL THEN
		SELECT  CONCAT(REPEAT('', level - 1), CAST(mj.id AS CHAR)) as id, 
				md.nombre, md.enlace, md.clase, md.tipo_enlace, md.target, 
				mj.padre, md.hijos,  mj.level as nivel, md.categoria
			FROM    (
					SELECT  id, padre, IF(ancestry, @cl := @cl + 1, level + @cl) AS level
					FROM    (
							SELECT  TRUE AS ancestry, _id AS id, padre, level
							FROM    (
									SELECT  @r AS _id,
											(SELECT  @r := padre
											FROM    ja_menu
											WHERE   id = _id
											) AS padre,
											@l := @l + 1 AS level
									FROM    (SELECT  @r := 0, @l := 0, @cl := 0) vars,
											ja_menu h
									WHERE   @r <> 0
									ORDER BY level DESC
									) qi
							UNION ALL
							SELECT  FALSE, hi.id, padre, level
							FROM    (
									SELECT  f_getMenuJerarquia_by_padre(id) AS id, @level AS level
									FROM    (SELECT  @start_with := 0, @id := @start_with, @level := 0) vars, ja_menu
									WHERE   @id IS NOT NULL
									) ho
							JOIN    ja_menu hi ON hi.id = ho.id
							) q
					) mj
					
					inner join v_getmenudetallado md on mj.id = md.id
					where md.categoria = categoria
					order by id;
					
	ELSE 
    
		SELECT  CONCAT(REPEAT('', level - 1), CAST(mj.id AS CHAR)) as id, 
				md.nombre, md.enlace, md.clase, md.tipo_enlace, md.target, 
				mj.padre, md.hijos,  mj.level as nivel
			FROM    (
					SELECT  id, padre, IF(ancestry, @cl := @cl + 1, level + @cl) AS level
					FROM    (
							SELECT  TRUE AS ancestry, _id AS id, padre, level
							FROM    (
									SELECT  @r AS _id,
											(SELECT  @r := padre
											FROM    ja_menu
											WHERE   id = _id
											) AS padre,
											@l := @l + 1 AS level
									FROM    (SELECT  @r := 0, @l := 0, @cl := 0) vars,
											ja_menu h
									WHERE   @r <> 0
									ORDER BY level DESC
									) qi
							UNION ALL
							SELECT  FALSE, hi.id, padre, level
							FROM    (
									SELECT  f_getMenuJerarquia_by_padre(id) AS id, @level AS level
									FROM    (SELECT  @start_with := 0, @id := @start_with, @level := 0) vars, ja_menu
									WHERE   @id IS NOT NULL
									) ho
							JOIN    ja_menu hi ON hi.id = ho.id
							) q
					) mj
					
					inner join v_getmenudetallado md on mj.id = md.id
					order by id;

	END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getPermisosUsuario`(
	idusuario int(4),
    idrecurso int(4)
)
BEGIN

	IF idusuario IS NOT NULL AND idusuario > 0 AND idrecurso IS NOT NULL AND idrecurso > 0 THEN

		SELECT IF(SUM(consultar) >= 1, 1,0) as consultar,
			   IF(SUM(agregar) >= 1, 1,0) as agregar,
			   IF(SUM(editar) >= 1, 1,0) as editar,
			   IF(SUM(eliminar) >= 1, 1,0) as eliminar
		FROM ja_acl_perfiles_recursos
		WHERE recurso_id = idrecurso
		AND perfil_id IN (
			/* SELECCIONO LOS PERFILES DEL USUARIO*/
			SELECT perfil_id
			FROM ja_acl_usuarios_perfiles
			WHERE usuario_id = idusuario
		)
		GROUP BY recurso_id;
    
    END IF;

END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `f_cortartexto`(texto text, textoalterno longtext, longitud int(10)) RETURNS text CHARSET latin1
BEGIN
	declare p1_texto text;
    declare p2_texto longtext;
    declare _logintud_texto1 int(10);
    declare _logintud_texto2 int(10);
    declare _resultado text;
    
    SET _logintud_texto1 = LENGTH(texto);
    SET _logintud_texto2 = LENGTH(textoalterno);
        
    IF _logintud_texto1 > 0 THEN BEGIN     
		set _resultado = IF(longitud > 0, SUBSTRING(texto,1,longitud), texto);
	END; END IF;  
    
    IF _logintud_texto2 > 0 AND _logintud_texto1 = 0 THEN BEGIN     
		set _resultado = IF(longitud > 0, SUBSTRING(textoalterno,1,longitud), textoalterno);
	END; END IF;  

RETURN f_eliminar_dobleespacios(f_eliminar_tags_html(_resultado));
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_eliminar_dobleespacios`(str text) RETURNS text CHARSET latin1
BEGIN
    while instr(str, '  ') > 0 do
        set str := replace(str, '  ', ' ');
    end while;
    return trim(str);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_eliminar_tags_html`(x longtext) RETURNS longtext CHARSET latin1
BEGIN
	DECLARE sstart INT UNSIGNED;
	DECLARE ends INT UNSIGNED;
	SET sstart = LOCATE('<', x, 1);
	REPEAT
	SET ends = LOCATE('>', x, sstart);
	SET x = CONCAT(SUBSTRING( x, 1 ,sstart -1) ,SUBSTRING(x, ends +1 )) ;
	SET sstart = LOCATE('<', x, 1);
	UNTIL sstart < 1 END REPEAT;
return x;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_getMenuHijos`(GivenID INT) RETURNS varchar(1024) CHARSET latin1
    DETERMINISTIC
BEGIN

	DECLARE rv,q,queue,queue_children VARCHAR(1024);
	DECLARE queue_length,front_id,pos INT;
	SET rv = '';
	SET queue = GivenID;
	SET queue_length = 1;

	WHILE queue_length > 0 DO
		SET front_id = FORMAT(queue,0);
		IF queue_length = 1 THEN
			SET queue = '';
		ELSE
			SET pos = LOCATE(',',queue) + 1;
			SET q = SUBSTR(queue,pos);
			SET queue = q;
		END IF;
		SET queue_length = queue_length - 1;
		SELECT IFNULL(qc,'') INTO queue_children
		FROM (SELECT GROUP_CONCAT(id) qc
		FROM ja_menu WHERE padre = front_id) A;
		IF LENGTH(queue_children) = 0 THEN
			IF LENGTH(queue) = 0 THEN
				SET queue_length = 0;
			END IF;
		ELSE
			IF LENGTH(rv) = 0 THEN
				SET rv = queue_children;
			ELSE
				SET rv = CONCAT(rv,',',queue_children);
			END IF;
			IF LENGTH(queue) = 0 THEN
				SET queue = queue_children;
			ELSE
				SET queue = CONCAT(queue,',',queue_children);
			END IF;
			SET queue_length = LENGTH(queue) - LENGTH(REPLACE(queue,',','')) + 1;
		END IF;
	END WHILE;
	RETURN rv;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_getMenuJerarquia_by_padre`(value INT) RETURNS int(11)
    READS SQL DATA
BEGIN
	DECLARE _id INT;
	DECLARE _parent INT;
	DECLARE _next INT;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET @id = NULL;

	SET _parent = @id;
	SET _id = -1;

	IF @id IS NULL THEN
		RETURN NULL;
	END IF;
	 
	LOOP
		SELECT  MIN(id) INTO @id
		FROM    ja_menu
		WHERE   padre = _parent
		AND id > _id;

		IF @id IS NOT NULL OR _parent = @start_with THEN
			SET @level = @level + 1;
			RETURN @id;
		END IF;

		SET @level := @level - 1;
		SELECT  id, padre INTO    _id, _parent
		FROM    ja_menu
		WHERE   id = _parent;
	END LOOP;      
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_setRutaImagenUsuario`(imagen CHAR(250)) RETURNS char(250) CHARSET latin1
BEGIN
	
	DECLARE imagenUsuario CHAR(250);
	SET imagenUsuario = IF(imagen IS NULL OR IMAGEN = '', imagen, CONCAT('assets/archivos/usuarios/',imagen));
    RETURN imagenUsuario;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ja_acl_perfiles`
--

CREATE TABLE IF NOT EXISTS `ja_acl_perfiles` (
  `id` int(11) NOT NULL COMMENT 'llave primaria de la tabla',
  `nombre` varchar(45) DEFAULT NULL COMMENT 'Descripción del perfil',
  `fecha_registro` datetime DEFAULT NULL COMMENT 'fecha de registro'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `ja_acl_perfiles`:
--

--
-- Truncar tablas antes de insertar `ja_acl_perfiles`
--

TRUNCATE TABLE `ja_acl_perfiles`;
--
-- Volcado de datos para la tabla `ja_acl_perfiles`
--

INSERT INTO `ja_acl_perfiles` (`id`, `nombre`, `fecha_registro`) VALUES
(1, 'Administrador', '2015-10-21 15:53:16'),
(2, 'Editor', '2015-10-21 15:53:16'),
(3, 'Escritor', '2015-10-21 15:53:16'),
(4, 'Marketing', '2015-10-21 15:53:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ja_acl_perfiles_recursos`
--

CREATE TABLE IF NOT EXISTS `ja_acl_perfiles_recursos` (
  `consultar` tinyint(1) DEFAULT '0',
  `agregar` tinyint(1) DEFAULT '0',
  `editar` tinyint(1) DEFAULT '0',
  `eliminar` tinyint(1) DEFAULT '0',
  `recurso_id` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `ja_acl_perfiles_recursos`:
--   `perfil_id`
--       `ja_acl_perfiles` -> `id`
--   `recurso_id`
--       `ja_acl_recursos` -> `id`
--

--
-- Truncar tablas antes de insertar `ja_acl_perfiles_recursos`
--

TRUNCATE TABLE `ja_acl_perfiles_recursos`;
--
-- Volcado de datos para la tabla `ja_acl_perfiles_recursos`
--

INSERT INTO `ja_acl_perfiles_recursos` (`consultar`, `agregar`, `editar`, `eliminar`, `recurso_id`, `perfil_id`) VALUES
(1, 1, 1, 1, 1, 1),
(1, 1, 1, 1, 2, 1),
(1, 1, 1, 1, 3, 1),
(1, 1, 1, 1, 4, 1),
(1, 1, 1, 1, 1, 3),
(1, 1, 1, 1, 1, 4),
(1, 1, 1, 1, 2, 4),
(1, 1, 1, 1, 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ja_acl_recursos`
--

CREATE TABLE IF NOT EXISTS `ja_acl_recursos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL COMMENT 'nombre del recurso',
  `fecha_registro` datetime DEFAULT NULL COMMENT 'Fecha en la que se registro el recurso'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `ja_acl_recursos`:
--

--
-- Truncar tablas antes de insertar `ja_acl_recursos`
--

TRUNCATE TABLE `ja_acl_recursos`;
--
-- Volcado de datos para la tabla `ja_acl_recursos`
--

INSERT INTO `ja_acl_recursos` (`id`, `nombre`, `fecha_registro`) VALUES
(1, 'Gestion Articulos', '2015-10-21 15:58:01'),
(2, 'Publicar Articulos', '2015-10-21 15:58:01'),
(3, 'Gestion Usuarios', '2015-10-21 15:58:01'),
(4, 'Gestion Configuracion', '2015-10-21 15:58:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ja_acl_usuarios_perfiles`
--

CREATE TABLE IF NOT EXISTS `ja_acl_usuarios_perfiles` (
  `usuario_id` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `ja_acl_usuarios_perfiles`:
--   `perfil_id`
--       `ja_acl_perfiles` -> `id`
--   `usuario_id`
--       `ja_usuarios` -> `id`
--

--
-- Truncar tablas antes de insertar `ja_acl_usuarios_perfiles`
--

TRUNCATE TABLE `ja_acl_usuarios_perfiles`;
--
-- Volcado de datos para la tabla `ja_acl_usuarios_perfiles`
--

INSERT INTO `ja_acl_usuarios_perfiles` (`usuario_id`, `perfil_id`) VALUES
(1, 1),
(214, 4),
(214, 3),
(1, 3),
(1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ja_categorias`
--

CREATE TABLE IF NOT EXISTS `ja_categorias` (
  `id` int(10) unsigned NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `ja_categorias`:
--

--
-- Truncar tablas antes de insertar `ja_categorias`
--

TRUNCATE TABLE `ja_categorias`;
--
-- Volcado de datos para la tabla `ja_categorias`
--

INSERT INTO `ja_categorias` (`id`, `titulo`, `slug`) VALUES
(1, 'Sin categoria', 'sin-categoria'),
(2, 'Noticias', 'noticias'),
(3, 'Blog', 'blog');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ja_menu`
--

CREATE TABLE IF NOT EXISTS `ja_menu` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `clase` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `enlace` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '#',
  `tipo_enlace` enum('interno','externo','_top') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'interno',
  `target` enum('_self','_blank','_top') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '_self',
  `padre` int(11) NOT NULL DEFAULT '0',
  `categoria` enum('1','2','3','4','5','6') DEFAULT '6'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `ja_menu`:
--

--
-- Truncar tablas antes de insertar `ja_menu`
--

TRUNCATE TABLE `ja_menu`;
--
-- Volcado de datos para la tabla `ja_menu`
--

INSERT INTO `ja_menu` (`id`, `nombre`, `clase`, `enlace`, `tipo_enlace`, `target`, `padre`, `categoria`) VALUES
(1, 'Portada', 'borde-verde', '/', 'interno', '_self', 0, '1'),
(2, 'Demo', '', '/demo', 'interno', '_self', 1, '1'),
(3, 'Jovenes', 'borde-azul', '/demo', 'interno', '_self', 0, '1'),
(4, 'Sub nivel', '', '/subdemo', 'interno', '_self', 2, '1'),
(5, 'Sub sub nivel', '', '/subsubdemo', 'interno', '_self', 2, '1'),
(6, 'Noticias', 'borde-amarillo', '/noticias', 'interno', '_self', 0, '1'),
(7, '', '', '', 'interno', '', 0, ''),
(8, '', '', '', 'interno', '', 0, ''),
(9, 'Prueba', 'borde-amarillo', '/prueba', 'interno', '', 0, '2'),
(10, 'Mister', 'borde', '/mister', 'interno', '_blank', 0, '3'),
(11, 'Inicio', 'hola', '/', 'interno', '_self', 0, '5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ja_opciones`
--

CREATE TABLE IF NOT EXISTS `ja_opciones` (
  `id` bigint(20) unsigned NOT NULL,
  `nombre` varchar(64) NOT NULL DEFAULT '',
  `valor` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `ja_opciones`:
--

--
-- Truncar tablas antes de insertar `ja_opciones`
--

TRUNCATE TABLE `ja_opciones`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ja_paginas`
--

CREATE TABLE IF NOT EXISTS `ja_paginas` (
  `id` int(10) unsigned NOT NULL,
  `titulo` text NOT NULL,
  `contenido` longtext,
  `imagen` varchar(200) DEFAULT NULL,
  `leermas` varchar(150) DEFAULT NULL,
  `estado` enum('publicado','pendiente','programado') DEFAULT 'publicado',
  `categoria` int(10) DEFAULT NULL,
  `tipo` enum('pagina','articulo','portada','contacto') NOT NULL DEFAULT 'articulo',
  `autor` int(4) DEFAULT '0',
  `padre` bigint(20) DEFAULT '0',
  `slug` text,
  `meta_descripcion` text,
  `meta_palabras` text,
  `meta_titulo` varchar(80) DEFAULT NULL,
  `fecha_creado` datetime DEFAULT '0000-00-00 00:00:00',
  `fecha_modificado` datetime DEFAULT '0000-00-00 00:00:00',
  `configuracion` text
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- RELACIONES PARA LA TABLA `ja_paginas`:
--

--
-- Truncar tablas antes de insertar `ja_paginas`
--

TRUNCATE TABLE `ja_paginas`;
--
-- Volcado de datos para la tabla `ja_paginas`
--

INSERT INTO `ja_paginas` (`id`, `titulo`, `contenido`, `imagen`, `leermas`, `estado`, `categoria`, `tipo`, `autor`, `padre`, `slug`, `meta_descripcion`, `meta_palabras`, `meta_titulo`, `fecha_creado`, `fecha_modificado`, `configuracion`) VALUES
(1, 'Portada', '<p>Esto es el contenido de la pagina portada yes</p>', NULL, '', '', 0, 'portada', 1, 0, '', 'Esto es una descripcion demo de la portada', 'uno,               dos,               tres,               cuatro,               cinco,               seis,               siete,               ocho,               nueve,               diez', 'JA | CMSJS 2015', '0000-00-00 00:00:00', '2015-11-20 12:47:01', ''),
(2, 'Esto es un titulo de prueba muy largo', '<p>The Mathematical Symphony of Typography</p>\n<p>As it turns out, this symphony is not unique to websites. You “hear” it every time you read a book, newspaper, magazine, or web site—every place where typography exists. At first glance, you might think that typography and math have nothing to do with one another. After all, typography consists of letters and words, and math is…well…numbers. But the truth is, typography is a combination of artistic letterforms and mathematical proportions, an exquisite marriage of form and function.</p>\n<p>Lorem ipsum dolor sit amet, his ad homero quodsi. Definitiones vituperatoribus mei et. Simul regione ea quo, cu vel eius scaevola, per accusata quaerendum eu. Mei at diam accusam, vel tale sint error ex, labore moderatius eos ut.</p><p>Perfecto corrumpit no sed, cu facer postea has. In eam iusto dicam, cum ut sale vituperata. Eam dignissim torquatos ne, nobis dolorum sit ut sale vituperata</p><p>Ex mucius adipiscing scripserit est, pri ut nihil maiorum invenire. Usu erat mazim altera in, tacimats regione indoctum, usu cu lorem appellantur, dissentiunt accommodare no vis. Pri prompta conclud.</p><p>Conversely, when the proportions of your typography are imbalanced, your content isn’t as attractive to readers, and your site seems cluttered and disorganized.</p>', NULL, '', '', 2, 'articulo', 1, 0, 'noticias-titulo-largo2', 'Descripcion breve', 'palabra1, palabra2, palabra3', 'Titulo seo 2', '2015-10-21 12:54:10', '0000-00-00 00:00:00', NULL),
(3, 'Esto es un titulo de prueba muy largo', '<p>The Mathematical Symphony of Typography</p>\n<p>As it turns out, this symphony is not unique to websites. You “hear” it every time you read a book, newspaper, magazine, or web site—every place where typography exists. At first glance, you might think that typography and math have nothing to do with one another. After all, typography consists of letters and words, and math is…well…numbers. But the truth is, typography is a combination of artistic letterforms and mathematical proportions, an exquisite marriage of form and function.</p>\n<p>Lorem ipsum dolor sit amet, his ad homero quodsi. Definitiones vituperatoribus mei et. Simul regione ea quo, cu vel eius scaevola, per accusata quaerendum eu. Mei at diam accusam, vel tale sint error ex, labore moderatius eos ut.</p><p>Perfecto corrumpit no sed, cu facer postea has. In eam iusto dicam, cum ut sale vituperata. Eam dignissim torquatos ne, nobis dolorum sit ut sale vituperata</p><p>Ex mucius adipiscing scripserit est, pri ut nihil maiorum invenire. Usu erat mazim altera in, tacimats regione indoctum, usu cu lorem appellantur, dissentiunt accommodare no vis. Pri prompta conclud.</p><p>Conversely, when the proportions of your typography are imbalanced, your content isn’t as attractive to readers, and your site seems cluttered and disorganized.</p>', NULL, '', '', 3, 'articulo', 214, 0, 'entrada-blog-titulo-largo', 'descripcion seo', 'titulo, seo, palabras', 'Titulo seo 3', '2015-10-20 12:54:10', '0000-00-00 00:00:00', NULL),
(4, 'Esto es un titulo de prueba muy largo', '<p>The Mathematical Symphony of Typography</p>\n<p>As it turns out, this symphony is not unique to websites. You “hear” it every time you read a book, newspaper, magazine, or web site—every place where typography exists. At first glance, you might think that typography and math have nothing to do with one another. After all, typography consists of letters and words, and math is…well…numbers. But the truth is, typography is a combination of artistic letterforms and mathematical proportions, an exquisite marriage of form and function.</p>\n<p>Lorem ipsum dolor sit amet, his ad homero quodsi. Definitiones vituperatoribus mei et. Simul regione ea quo, cu vel eius scaevola, per accusata quaerendum eu. Mei at diam accusam, vel tale sint error ex, labore moderatius eos ut.</p><p>Perfecto corrumpit no sed, cu facer postea has. In eam iusto dicam, cum ut sale vituperata. Eam dignissim torquatos ne, nobis dolorum sit ut sale vituperata</p><p>Ex mucius adipiscing scripserit est, pri ut nihil maiorum invenire. Usu erat mazim altera in, tacimats regione indoctum, usu cu lorem appellantur, dissentiunt accommodare no vis. Pri prompta conclud.</p><p>Conversely, when the proportions of your typography are imbalanced, your content isn’t as attractive to readers, and your site seems cluttered and disorganized.</p>', NULL, '', '', 2, 'articulo', 214, 0, 'noticias-titulo-largo4', 'Descripcion breve', 'palabra1, palabra2, palabra3', 'Titulo seo 4', '2015-10-15 10:54:10', '0000-00-00 00:00:00', NULL),
(5, 'Esto es un titulo de prueba muy largo', '<p>The Mathematical Symphony of Typography</p>\r <p>As it turns out, this symphony is not unique to websites. You “hear” it every time you read a book, newspaper, magazine, or web site—every place where typography exists. At first glance, you might think that typography and math have nothing to do with one another. After all, typography consists of letters and words, and math is…well…numbers. But the truth is, typography is a combination of artistic letterforms and mathematical proportions, an exquisite marriage of form and function.</p>\r <p>Lorem ipsum dolor sit amet, his ad homero quodsi. Definitiones vituperatoribus mei et. Simul regione ea quo, cu vel eius scaevola, per accusata quaerendum eu. Mei at diam accusam, vel tale sint error ex, labore moderatius eos ut.</p><p>Perfecto corrumpit no sed, cu facer postea has. In eam iusto dicam, cum ut sale vituperata. Eam dignissim torquatos ne, nobis dolorum sit ut sale vituperata</p><p>Ex mucius adipiscing scripserit est, pri ut nihil maiorum invenire. Usu erat mazim altera in, tacimats regione indoctum, usu cu lorem appellantur, dissentiunt accommodare no vis. Pri prompta conclud.</p><p>Conversely, when the proportions of your typography are imbalanced, your content isn\\’t as attractive to readers, and your site seems cluttered and disorganized.</p>', NULL, '', '', 2, 'articulo', 1, 0, 'noticias-titulo-largo5', 'asdf', 'asdf, sdf', 'Titulo seo 5', '2015-10-15 12:54:10', '0000-00-00 00:00:00', NULL),
(6, 'Esto es un titulo de prueba muy largo', '<p>The Mathematical Symphony of Typography</p>\n<p>As it turns out, this symphony is not unique to websites. You “hear” it every time you read a book, newspaper, magazine, or web site—every place where typography exists. At first glance, you might think that typography and math have nothing to do with one another. After all, typography consists of letters and words, and math is…well…numbers. But the truth is, typography is a combination of artistic letterforms and mathematical proportions, an exquisite marriage of form and function.</p>\n<p>Lorem ipsum dolor sit amet, his ad homero quodsi. Definitiones vituperatoribus mei et. Simul regione ea quo, cu vel eius scaevola, per accusata quaerendum eu. Mei at diam accusam, vel tale sint error ex, labore moderatius eos ut.</p><p>Perfecto corrumpit no sed, cu facer postea has. In eam iusto dicam, cum ut sale vituperata. Eam dignissim torquatos ne, nobis dolorum sit ut sale vituperata</p><p>Ex mucius adipiscing scripserit est, pri ut nihil maiorum invenire. Usu erat mazim altera in, tacimats regione indoctum, usu cu lorem appellantur, dissentiunt accommodare no vis. Pri prompta conclud.</p><p>Conversely, when the proportions of your typography are imbalanced, your content isn’t as attractive to readers, and your site seems cluttered and disorganized.</p>', NULL, '', '', 3, 'articulo', 214, 0, 'noticias-titulo-largo6', 'descripcion seo', 'titulo, seo, palabras', 'Titulo seo 3', '2015-10-20 12:54:10', '0000-00-00 00:00:00', NULL),
(7, 'Esto es un titulo de prueba muy largo', '<p>The Mathematical Symphony of Typography</p>\n<p>As it turns out, this symphony is not unique to websites. You “hear” it every time you read a book, newspaper, magazine, or web site—every place where typography exists. At first glance, you might think that typography and math have nothing to do with one another. After all, typography consists of letters and words, and math is…well…numbers. But the truth is, typography is a combination of artistic letterforms and mathematical proportions, an exquisite marriage of form and function.</p>\n<p>Lorem ipsum dolor sit amet, his ad homero quodsi. Definitiones vituperatoribus mei et. Simul regione ea quo, cu vel eius scaevola, per accusata quaerendum eu. Mei at diam accusam, vel tale sint error ex, labore moderatius eos ut.</p><p>Perfecto corrumpit no sed, cu facer postea has. In eam iusto dicam, cum ut sale vituperata. Eam dignissim torquatos ne, nobis dolorum sit ut sale vituperata</p><p>Ex mucius adipiscing scripserit est, pri ut nihil maiorum invenire. Usu erat mazim altera in, tacimats regione indoctum, usu cu lorem appellantur, dissentiunt accommodare no vis. Pri prompta conclud.</p><p>Conversely, when the proportions of your typography are imbalanced, your content isn’t as attractive to readers, and your site seems cluttered and disorganized.</p>', NULL, '', '', 2, 'articulo', 214, 0, 'noticias-titulo-largo7', 'Descripcion breve', 'palabra1, palabra2, palabra3', 'Titulo seo 4', '2015-10-15 10:54:10', '0000-00-00 00:00:00', NULL),
(8, 'Esto es un titulo de prueba muy largo', '<p>The Mathematical Symphony of Typography</p>\n<p>As it turns out, this symphony is not unique to websites. You “hear” it every time you read a book, newspaper, magazine, or web site—every place where typography exists. At first glance, you might think that typography and math have nothing to do with one another. After all, typography consists of letters and words, and math is…well…numbers. But the truth is, typography is a combination of artistic letterforms and mathematical proportions, an exquisite marriage of form and function.</p>\n<p>Lorem ipsum dolor sit amet, his ad homero quodsi. Definitiones vituperatoribus mei et. Simul regione ea quo, cu vel eius scaevola, per accusata quaerendum eu. Mei at diam accusam, vel tale sint error ex, labore moderatius eos ut.</p><p>Perfecto corrumpit no sed, cu facer postea has. In eam iusto dicam, cum ut sale vituperata. Eam dignissim torquatos ne, nobis dolorum sit ut sale vituperata</p><p>Ex mucius adipiscing scripserit est, pri ut nihil maiorum invenire. Usu erat mazim altera in, tacimats regione indoctum, usu cu lorem appellantur, dissentiunt accommodare no vis. Pri prompta conclud.</p><p>Conversely, when the proportions of your typography are imbalanced, your content isn’t as attractive to readers, and your site seems cluttered and disorganized.</p>', NULL, '', '', 3, 'articulo', 1, 0, 'entrada-blog-titulo-largo2', 'Descripcion breve', 'palabra1, palabra2, palabra3', 'Titulo seo 2', '2015-10-21 12:54:10', '0000-00-00 00:00:00', NULL),
(9, 'Esto es un titulo de prueba muy largo', '<p>The Mathematical Symphony of Typography</p>\n<p>As it turns out, this symphony is not unique to websites. You “hear” it every time you read a book, newspaper, magazine, or web site—every place where typography exists. At first glance, you might think that typography and math have nothing to do with one another. After all, typography consists of letters and words, and math is…well…numbers. But the truth is, typography is a combination of artistic letterforms and mathematical proportions, an exquisite marriage of form and function.</p>\n<p>Lorem ipsum dolor sit amet, his ad homero quodsi. Definitiones vituperatoribus mei et. Simul regione ea quo, cu vel eius scaevola, per accusata quaerendum eu. Mei at diam accusam, vel tale sint error ex, labore moderatius eos ut.</p><p>Perfecto corrumpit no sed, cu facer postea has. In eam iusto dicam, cum ut sale vituperata. Eam dignissim torquatos ne, nobis dolorum sit ut sale vituperata</p><p>Ex mucius adipiscing scripserit est, pri ut nihil maiorum invenire. Usu erat mazim altera in, tacimats regione indoctum, usu cu lorem appellantur, dissentiunt accommodare no vis. Pri prompta conclud.</p><p>Conversely, when the proportions of your typography are imbalanced, your content isn’t as attractive to readers, and your site seems cluttered and disorganized.</p>', NULL, '', '', 3, 'articulo', 1, 0, 'entrada-blog-titulo-largo4', 'Descripcion breve', 'palabra1, palabra2, palabra3', 'Titulo seo 2', '2015-10-21 12:54:10', '0000-00-00 00:00:00', NULL),
(10, 'Esto es un titulo de prueba muy largo', '<p>The Mathematical Symphony of Typography</p>\n<p>As it turns out, this symphony is not unique to websites. You “hear” it every time you read a book, newspaper, magazine, or web site—every place where typography exists. At first glance, you might think that typography and math have nothing to do with one another. After all, typography consists of letters and words, and math is…well…numbers. But the truth is, typography is a combination of artistic letterforms and mathematical proportions, an exquisite marriage of form and function.</p>\n<p>Lorem ipsum dolor sit amet, his ad homero quodsi. Definitiones vituperatoribus mei et. Simul regione ea quo, cu vel eius scaevola, per accusata quaerendum eu. Mei at diam accusam, vel tale sint error ex, labore moderatius eos ut.</p><p>Perfecto corrumpit no sed, cu facer postea has. In eam iusto dicam, cum ut sale vituperata. Eam dignissim torquatos ne, nobis dolorum sit ut sale vituperata</p><p>Ex mucius adipiscing scripserit est, pri ut nihil maiorum invenire. Usu erat mazim altera in, tacimats regione indoctum, usu cu lorem appellantur, dissentiunt accommodare no vis. Pri prompta conclud.</p><p>Conversely, when the proportions of your typography are imbalanced, your content isn’t as attractive to readers, and your site seems cluttered and disorganized.</p>', NULL, '', '', 3, 'articulo', 1, 0, 'entrada-blog-titulo-largo5', 'Descripcion breve', 'palabra1, palabra2, palabra3', 'Titulo seo 2', '2015-10-21 12:54:10', '0000-00-00 00:00:00', NULL),
(11, 'Esto es un titulo de prueba muy largo', '<p>The Mathematical Symphony of Typography</p>\n<p>As it turns out, this symphony is not unique to websites. You “hear” it every time you read a book, newspaper, magazine, or web site—every place where typography exists. At first glance, you might think that typography and math have nothing to do with one another. After all, typography consists of letters and words, and math is…well…numbers. But the truth is, typography is a combination of artistic letterforms and mathematical proportions, an exquisite marriage of form and function.</p>\n<p>Lorem ipsum dolor sit amet, his ad homero quodsi. Definitiones vituperatoribus mei et. Simul regione ea quo, cu vel eius scaevola, per accusata quaerendum eu. Mei at diam accusam, vel tale sint error ex, labore moderatius eos ut.</p><p>Perfecto corrumpit no sed, cu facer postea has. In eam iusto dicam, cum ut sale vituperata. Eam dignissim torquatos ne, nobis dolorum sit ut sale vituperata</p><p>Ex mucius adipiscing scripserit est, pri ut nihil maiorum invenire. Usu erat mazim altera in, tacimats regione indoctum, usu cu lorem appellantur, dissentiunt accommodare no vis. Pri prompta conclud.</p><p>Conversely, when the proportions of your typography are imbalanced, your content isn’t as attractive to readers, and your site seems cluttered and disorganized.</p>', NULL, '', '', 2, 'articulo', 214, 0, 'noticias-titulo-largo8', 'Descripcion breve', 'palabra1, palabra2, palabra3', 'Titulo seo 4', '2015-10-15 10:54:10', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ja_usuarios`
--

CREATE TABLE IF NOT EXISTS `ja_usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `biografia` text,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `redessociales` text,
  `clave` varchar(200) NOT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `fechacreado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `ja_usuarios`:
--

--
-- Truncar tablas antes de insertar `ja_usuarios`
--

TRUNCATE TABLE `ja_usuarios`;
--
-- Volcado de datos para la tabla `ja_usuarios`
--

INSERT INTO `ja_usuarios` (`id`, `usuario`, `imagen`, `nombre`, `apellidos`, `biografia`, `correo`, `telefono`, `redessociales`, `clave`, `direccion`, `ciudad`, `pais`, `fechacreado`) VALUES
(1, 'admin', 'avatar-5.png', 'Alex', 'Sosa', NULL, 'admin@correo.com', '000000000', NULL, '$2y$11$wJBCb6M1X03StqdWDXoYUeaXvVHzziSez6L3jbO3mDrCWPZYYriEW', 'direccion', '', 'repdominicana', '2015-02-27 16:38:57'),
(173, 'user5', 'avatar-4.png', 'Satwik Mohanty', '', NULL, 'satwik@gmail.com', '4444444444', NULL, '$2a$10$2b957be577db7727fed13O2QmHMd9LoEUjioYe.zkXP5lqBumI6Dy', 'Lyonerstr. 34', 'San Francisco\n', NULL, '2014-08-31 16:36:02'),
(214, 'Step', 'usuario_214.jpg', 'Steph', 'Sosa', NULL, 'steph@correo.com', '1234564', NULL, '$2y$11$3Znlb0L7UvmNYbTsPxolW.nmBogoOmurHPKnL0NO3f1uT8sKm7pEO', 'asdf', 'asdf', '', '2015-10-20 10:28:01'),
(215, 'Mister', 'usuario_215.jpg', 'mister', 'demo', NULL, 'misterdm@correo.com', '123456', NULL, '$2y$11$287b6SooJ3tpjtqbG6eQ2eSJBM4Yv6uxk5izdIfcbDf5IIbvQmyF2', 'asdf', 'asdf', 'repdominicana', '2015-10-21 10:50:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propel_migration`
--

CREATE TABLE IF NOT EXISTS `propel_migration` (
  `version` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `propel_migration`:
--

--
-- Truncar tablas antes de insertar `propel_migration`
--

TRUNCATE TABLE `propel_migration`;
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_getmenudetallado`
--
CREATE TABLE IF NOT EXISTS `v_getmenudetallado` (
`id` int(11)
,`nombre` varchar(255)
,`clase` varchar(255)
,`enlace` varchar(255)
,`tipo_enlace` enum('interno','externo','_top')
,`target` enum('_self','_blank','_top')
,`padre` int(11)
,`hijos` varchar(1024)
,`categoria` enum('1','2','3','4','5','6')
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_getperfilusuario`
--
CREATE TABLE IF NOT EXISTS `v_getperfilusuario` (
`id` int(11)
,`nombre` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_getusuarios`
--
CREATE TABLE IF NOT EXISTS `v_getusuarios` (
`id` int(11)
,`usuario` varchar(45)
,`imagen` char(250)
,`nombre` varchar(50)
,`apellidos` varchar(45)
,`biografia` text
,`correo` varchar(50)
,`telefono` varchar(100)
,`clave` varchar(200)
,`redessociales` text
,`direccion` varchar(50)
,`ciudad` varchar(50)
,`pais` varchar(45)
,`fechacreado` timestamp
);

-- --------------------------------------------------------

--
-- Estructura para la vista `v_getmenudetallado`
--
DROP TABLE IF EXISTS `v_getmenudetallado`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_getmenudetallado` AS select `ja_menu`.`id` AS `id`,`ja_menu`.`nombre` AS `nombre`,`ja_menu`.`clase` AS `clase`,`ja_menu`.`enlace` AS `enlace`,`ja_menu`.`tipo_enlace` AS `tipo_enlace`,`ja_menu`.`target` AS `target`,`ja_menu`.`padre` AS `padre`,`F_GETMENUHIJOS`(`ja_menu`.`id`) AS `hijos`,`ja_menu`.`categoria` AS `categoria` from `ja_menu`;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_getperfilusuario`
--
DROP TABLE IF EXISTS `v_getperfilusuario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_getperfilusuario` AS select `u`.`id` AS `id`,`p`.`nombre` AS `nombre` from ((`ja_usuarios` `u` join `ja_acl_usuarios_perfiles` `up` on((`u`.`id` = `up`.`usuario_id`))) join `ja_acl_perfiles` `p` on((`p`.`id` = `up`.`perfil_id`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `v_getusuarios`
--
DROP TABLE IF EXISTS `v_getusuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_getusuarios` AS select `ja_usuarios`.`id` AS `id`,`ja_usuarios`.`usuario` AS `usuario`,`F_SETRUTAIMAGENUSUARIO`(`ja_usuarios`.`imagen`) AS `imagen`,`ja_usuarios`.`nombre` AS `nombre`,`ja_usuarios`.`apellidos` AS `apellidos`,`ja_usuarios`.`biografia` AS `biografia`,`ja_usuarios`.`correo` AS `correo`,`ja_usuarios`.`telefono` AS `telefono`,`ja_usuarios`.`clave` AS `clave`,`ja_usuarios`.`redessociales` AS `redessociales`,`ja_usuarios`.`direccion` AS `direccion`,`ja_usuarios`.`ciudad` AS `ciudad`,`ja_usuarios`.`pais` AS `pais`,`ja_usuarios`.`fechacreado` AS `fechacreado` from `ja_usuarios`;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ja_acl_perfiles`
--
ALTER TABLE `ja_acl_perfiles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ja_acl_perfiles_recursos`
--
ALTER TABLE `ja_acl_perfiles_recursos`
  ADD KEY `fk_perfiles_recursos_recursos1_idx` (`recurso_id`), ADD KEY `fk_perfiles_recursos_perfiles1_idx` (`perfil_id`);

--
-- Indices de la tabla `ja_acl_recursos`
--
ALTER TABLE `ja_acl_recursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ja_acl_usuarios_perfiles`
--
ALTER TABLE `ja_acl_usuarios_perfiles`
  ADD KEY `fk_usuarios_perfiles_usuarios_idx` (`usuario_id`), ADD KEY `fk_usuarios_perfiles_perfiles1_idx` (`perfil_id`);

--
-- Indices de la tabla `ja_categorias`
--
ALTER TABLE `ja_categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ja_menu`
--
ALTER TABLE `ja_menu`
  ADD PRIMARY KEY (`id`), ADD KEY `ix_hierarchy_parent` (`padre`,`id`);

--
-- Indices de la tabla `ja_opciones`
--
ALTER TABLE `ja_opciones`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `option_name` (`nombre`);

--
-- Indices de la tabla `ja_paginas`
--
ALTER TABLE `ja_paginas`
  ADD PRIMARY KEY (`id`), ADD KEY `tipo_estado_fecha` (`tipo`,`estado`,`fecha_creado`,`id`), ADD KEY `pagina_padre` (`padre`), ADD KEY `pagina_autor` (`autor`);

--
-- Indices de la tabla `ja_usuarios`
--
ALTER TABLE `ja_usuarios`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ja_acl_perfiles`
--
ALTER TABLE `ja_acl_perfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'llave primaria de la tabla',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `ja_categorias`
--
ALTER TABLE `ja_categorias`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `ja_menu`
--
ALTER TABLE `ja_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `ja_paginas`
--
ALTER TABLE `ja_paginas`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `ja_usuarios`
--
ALTER TABLE `ja_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=216;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ja_acl_perfiles_recursos`
--
ALTER TABLE `ja_acl_perfiles_recursos`
ADD CONSTRAINT `fk_perfiles_recursos_perfiles1` FOREIGN KEY (`perfil_id`) REFERENCES `ja_acl_perfiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_perfiles_recursos_recursos1` FOREIGN KEY (`recurso_id`) REFERENCES `ja_acl_recursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ja_acl_usuarios_perfiles`
--
ALTER TABLE `ja_acl_usuarios_perfiles`
ADD CONSTRAINT `fk_usuarios_perfiles_perfiles1` FOREIGN KEY (`perfil_id`) REFERENCES `ja_acl_perfiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_usuarios_perfiles_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `ja_usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

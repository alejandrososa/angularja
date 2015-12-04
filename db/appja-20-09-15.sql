ALTER TABLE `appja`.`wsp_opciones`
CHANGE COLUMN `opcion_id` `id` BIGINT(20) UNSIGNED NOT NULL COMMENT '' ,
CHANGE COLUMN `opcion_nombre` `nombre` VARCHAR(64) NOT NULL DEFAULT '' COMMENT '' ,
CHANGE COLUMN `opcion_valor` `valor` LONGTEXT NOT NULL COMMENT '' , RENAME TO  `appja`.`ja_opciones` ;


ALTER TABLE `appja`.`wsp_paginas`
CHANGE COLUMN `pagina_nombre` `nombre` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '' ,
CHANGE COLUMN `pagina_tipo` `tipo` VARCHAR(20) NOT NULL DEFAULT 'pagina' COMMENT '' ,
CHANGE COLUMN `pagina_autor` `autor` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '' ,
CHANGE COLUMN `pagina_fecha` `fecha` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '' ,
CHANGE COLUMN `pagina_fecha_gmt` `fecha_gmt` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '' ,
CHANGE COLUMN `pagina_contenido` `contenido` LONGTEXT NOT NULL COMMENT '' ,
CHANGE COLUMN `pagina_titulo` `titulo` TEXT NOT NULL COMMENT '' ,
CHANGE COLUMN `pagina_leermas` `leermas` TEXT NOT NULL COMMENT '' ,
CHANGE COLUMN `pagina_estado` `estado` VARCHAR(20) NOT NULL DEFAULT 'publicado' COMMENT '' ,
CHANGE COLUMN `pagina_password` `password` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '' ,
CHANGE COLUMN `pagina_modificado` `modificado` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '' ,
CHANGE COLUMN `pagina_modificado_gmt` `modificado_gmt` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '' ,
CHANGE COLUMN `pagina_content_filtered` `content_filtered` LONGTEXT NOT NULL COMMENT '' ,
CHANGE COLUMN `pagina_padre` `padre` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '' ,
CHANGE COLUMN `pagina_mime_type` `mime_type` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '' , RENAME TO  `appja`.`ja_paginas` ;


ALTER TABLE `appja`.`wsp_usuarios`
CHANGE COLUMN `name` `nombre` VARCHAR(50) NOT NULL COMMENT '' ,
CHANGE COLUMN `email` `correo` VARCHAR(50) NOT NULL COMMENT '' ,
CHANGE COLUMN `phone` `telefono` VARCHAR(100) NOT NULL COMMENT '' ,
CHANGE COLUMN `password` `clave` VARCHAR(200) NOT NULL COMMENT '' ,
CHANGE COLUMN `address` `direccion` VARCHAR(50) NOT NULL COMMENT '' ,
CHANGE COLUMN `city` `ciudad` VARCHAR(50) NOT NULL COMMENT '' ,
CHANGE COLUMN `created` `fechacreado` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '' , RENAME TO  `appja`.`ja_usuarios` ;


CREATE TABLE `ja_categorias` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `titulo` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `slug` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '');


ALTER TABLE `appja`.`ja_paginas`
CHANGE COLUMN `ID` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '' ;

CREATE TABLE `ja_pagina_categorias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pagina` int(10) unsigned NOT NULL,
  `id_categoria` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pag_idx` (`id_pagina`),
  KEY `fk_cat_idx` (`id_categoria`),
  CONSTRAINT `fk_cat` FOREIGN KEY (`id_categoria`) REFERENCES `ja_categorias` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_pag` FOREIGN KEY (`id_pagina`) REFERENCES `ja_paginas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
);

INSERT INTO `appja`.`ja_categorias` (`titulo`, `slug`) VALUES ('Sin Categoria','sin-categoria');

ALTER TABLE `appja`.`ja_paginas`
ADD COLUMN `slug` TEXT NULL COMMENT '' AFTER `comentario_count`,
ADD COLUMN `meta_description` TEXT NULL COMMENT '' AFTER `slug`,
ADD COLUMN `meta_keyword` TEXT NULL COMMENT '' AFTER `meta_description`,
ADD COLUMN `meta_title` VARCHAR(80) NULL COMMENT '' AFTER `meta_keyword`;


ALTER TABLE `appja`.`ja_paginas`
CHANGE COLUMN `estado` `estado` ENUM('publicado', 'pendiente', 'programado') NOT NULL DEFAULT 'publicado' COMMENT '' ;




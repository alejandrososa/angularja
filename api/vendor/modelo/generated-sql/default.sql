
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- demo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `demo`;

CREATE TABLE `demo`
(
    `iddemo` INTEGER NOT NULL AUTO_INCREMENT,
    `titulo` VARCHAR(45),
    `prueba` VARCHAR(100),
    `otrocampo` VARCHAR(45),
    PRIMARY KEY (`iddemo`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ja_acl_perfiles
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ja_acl_perfiles`;

CREATE TABLE `ja_acl_perfiles`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(45),
    `fecha_registro` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ja_acl_perfiles_recursos
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ja_acl_perfiles_recursos`;

CREATE TABLE `ja_acl_perfiles_recursos`
(
    `consultar` TINYINT(1) DEFAULT 0,
    `agregar` TINYINT(1) DEFAULT 0,
    `editar` TINYINT(1) DEFAULT 0,
    `eliminar` TINYINT(1) DEFAULT 0,
    `recurso_id` INTEGER NOT NULL,
    `perfil_id` INTEGER NOT NULL,
    INDEX `fk_perfiles_recursos_recursos1_idx` (`recurso_id`),
    INDEX `fk_perfiles_recursos_perfiles1_idx` (`perfil_id`),
    CONSTRAINT `fk_perfiles_recursos_perfiles1`
        FOREIGN KEY (`perfil_id`)
        REFERENCES `ja_acl_perfiles` (`id`),
    CONSTRAINT `fk_perfiles_recursos_recursos1`
        FOREIGN KEY (`recurso_id`)
        REFERENCES `ja_acl_recursos` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ja_acl_recursos
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ja_acl_recursos`;

CREATE TABLE `ja_acl_recursos`
(
    `id` INTEGER NOT NULL,
    `nombre` VARCHAR(100),
    `fecha_registro` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ja_acl_usuarios_perfiles
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ja_acl_usuarios_perfiles`;

CREATE TABLE `ja_acl_usuarios_perfiles`
(
    `usuario_id` INTEGER NOT NULL,
    `perfil_id` INTEGER NOT NULL,
    INDEX `fk_usuarios_perfiles_usuarios_idx` (`usuario_id`),
    INDEX `fk_usuarios_perfiles_perfiles1_idx` (`perfil_id`),
    CONSTRAINT `fk_usuarios_perfiles_perfiles1`
        FOREIGN KEY (`perfil_id`)
        REFERENCES `ja_acl_perfiles` (`id`),
    CONSTRAINT `fk_usuarios_perfiles_usuarios`
        FOREIGN KEY (`usuario_id`)
        REFERENCES `ja_usuarios` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ja_categorias
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ja_categorias`;

CREATE TABLE `ja_categorias`
(
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `titulo` VARCHAR(255),
    `slug` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ja_menu
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ja_menu`;

CREATE TABLE `ja_menu`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(255) DEFAULT '' NOT NULL,
    `clase` VARCHAR(255) DEFAULT '' NOT NULL,
    `enlace` VARCHAR(255) DEFAULT '#' NOT NULL,
    `tipo_enlace` enum('interno','externo','_top') DEFAULT 'interno',
    `target` enum('_self','_blank','_top') DEFAULT '_self' NOT NULL,
    `padre` INTEGER DEFAULT 0 NOT NULL,
    `categoria` enum('1','2','3','4','5','6') DEFAULT '6',
    PRIMARY KEY (`id`),
    INDEX `ix_hierarchy_parent` (`padre`, `id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ja_opciones
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ja_opciones`;

CREATE TABLE `ja_opciones`
(
    `id` bigint(20) unsigned NOT NULL,
    `nombre` VARCHAR(64) DEFAULT '' NOT NULL,
    `valor` LONGTEXT NOT NULL,
    `autoload` VARCHAR(20) DEFAULT 'yes' NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `option_name` (`nombre`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ja_pagina_categorias
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ja_pagina_categorias`;

CREATE TABLE `ja_pagina_categorias`
(
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `id_pagina` int(10) unsigned NOT NULL,
    `id_categoria` int(10) unsigned,
    PRIMARY KEY (`id`),
    INDEX `fk_pag_idx` (`id_pagina`),
    INDEX `fk_cat_idx` (`id_categoria`),
    CONSTRAINT `fk_cat`
        FOREIGN KEY (`id_categoria`)
        REFERENCES `ja_categorias` (`id`)
        ON DELETE SET NULL,
    CONSTRAINT `fk_pag`
        FOREIGN KEY (`id_pagina`)
        REFERENCES `ja_paginas` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ja_paginas
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ja_paginas`;

CREATE TABLE `ja_paginas`
(
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `titulo` TEXT NOT NULL,
    `contenido` LONGTEXT,
    `imagen` VARCHAR(200),
    `categoria` INTEGER(4),
    `leermas` TEXT,
    `estado` enum('publicado','pendiente','programado') DEFAULT 'publicado',
    `tipo` enum('pagina','articulo','portada','contacto') DEFAULT 'articulo' NOT NULL,
    `autor` INTEGER(4) DEFAULT 0,
    `padre` BIGINT DEFAULT 0,
    `slug` TEXT,
    `meta_descripcion` TEXT,
    `meta_palabras` TEXT,
    `meta_titulo` VARCHAR(80),
    `fecha_creado` DATETIME DEFAULT '0000-00-00 00:00:00',
    `fecha_modificado` DATETIME DEFAULT '0000-00-00 00:00:00',
    `configuracion` TEXT,
    PRIMARY KEY (`id`),
    INDEX `tipo_estado_fecha` (`tipo`, `estado`, `fecha_creado`, `id`),
    INDEX `pagina_padre` (`padre`),
    INDEX `pagina_autor` (`autor`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ja_usuarios
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ja_usuarios`;

CREATE TABLE `ja_usuarios`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `usuario` VARCHAR(45) NOT NULL,
    `imagen` VARCHAR(100),
    `nombre` VARCHAR(50) NOT NULL,
    `apellidos` VARCHAR(45) NOT NULL,
    `biografia` TEXT,
    `correo` VARCHAR(50) NOT NULL,
    `telefono` VARCHAR(100),
    `redessociales` TEXT,
    `clave` VARCHAR(200) NOT NULL,
    `direccion` VARCHAR(50),
    `ciudad` VARCHAR(50),
    `pais` VARCHAR(45),
    `fechacreado` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `usuario_UNIQUE` (`usuario`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;

ALTER TABLE `appja`.`ja_paginas`
CHANGE COLUMN `contenido` `contenido` LONGTEXT NOT NULL COMMENT '' AFTER `titulo`,
ADD COLUMN `imagen` VARCHAR(200) NULL COMMENT '' AFTER `contenido`,
ADD COLUMN `categoria` int(4) NULL COMMENT '' AFTER `estado`;


ALTER TABLE `appja`.`ja_usuarios`
ADD COLUMN `biografia` TEXT NULL COMMENT '' AFTER `fechacreado`,
ADD COLUMN `redessociales` TEXT NULL COMMENT '' AFTER `biografia`;

ALTER TABLE `appja`.`ja_usuarios`
CHANGE COLUMN `biografia` `biografia` TEXT NULL DEFAULT NULL COMMENT '' AFTER `apellidos`,
CHANGE COLUMN `redessociales` `redessociales` TEXT NULL DEFAULT NULL COMMENT '' AFTER `telefono`;


USE `appja`;
CREATE
     OR REPLACE ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `v_getusuarios` AS
    SELECT
        `ja_usuarios`.`id` AS `id`,
        `ja_usuarios`.`usuario` AS `usuario`,
        F_SETRUTAIMAGENUSUARIO(`ja_usuarios`.`imagen`) AS `imagen`,
        `ja_usuarios`.`nombre` AS `nombre`,
        `ja_usuarios`.`apellidos` AS `apellidos`,
        `ja_usuarios`.`biografia` AS `biografia`,
        `ja_usuarios`.`correo` AS `correo`,
        `ja_usuarios`.`telefono` AS `telefono`,
        `ja_usuarios`.`clave` AS `clave`,
        `ja_usuarios`.`redessociales` AS `redessociales`,
        `ja_usuarios`.`direccion` AS `direccion`,
        `ja_usuarios`.`ciudad` AS `ciudad`,
        `ja_usuarios`.`pais` AS `pais`,
        `ja_usuarios`.`fechacreado` AS `fechacreado`
    FROM
        `ja_usuarios`;


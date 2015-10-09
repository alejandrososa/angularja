ALTER TABLE `appja`.`ja_usuarios`
CHANGE COLUMN `usuario` `usuario` VARCHAR(45) NOT NULL COMMENT '' ;
CHANGE COLUMN `telefono` `telefono` VARCHAR(100) NULL COMMENT '' ,
CHANGE COLUMN `direccion` `direccion` VARCHAR(50) NULL COMMENT '' ,
CHANGE COLUMN `ciudad` `ciudad` VARCHAR(50) NULL COMMENT '' ;

ADD COLUMN `apellidos` VARCHAR(45) NOT NULL COMMENT '' AFTER `nombre`;
ADD COLUMN `pais` VARCHAR(45) NULL COMMENT '' AFTER `ciudad`;
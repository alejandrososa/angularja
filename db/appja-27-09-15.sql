ALTER TABLE `appja`.`ja_usuarios`
CHANGE COLUMN `clave` `clave` VARCHAR(200) NOT NULL COMMENT '' AFTER `correo`,
CHANGE COLUMN `telefono` `telefono` VARCHAR(100) NULL COMMENT '' ,
CHANGE COLUMN `direccion` `direccion` VARCHAR(50) NULL COMMENT '' ,
CHANGE COLUMN `ciudad` `ciudad` VARCHAR(50) NULL COMMENT '' ,
ADD COLUMN `usuario` VARCHAR(50) NOT NULL DEFAULT 'user_temp' COMMENT '' AFTER `uid`,
ADD COLUMN `apellidos` VARCHAR(50) NOT NULL COMMENT '' AFTER `nombre`,
ADD COLUMN `pais` VARCHAR(45) NULL COMMENT '' AFTER `ciudad`,
ADD UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC)  COMMENT '';